<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Forum;
use App\Model\Good;
use App\Model\SubscribeForumPassword;
use App\Model\User;
use App\Model\UserAddress;
use App\Model\UserSubscribe;
use App\Model\UserSubscribePassword;
use Carbon\Carbon;
use Hyperf\DbConnection\Db;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use App\Service\OrderService;
use Hyperf\Di\Annotation\Inject;
use ZYProSoft\Log\Log;

class ForumService extends BaseService
{
    /**
     * @Inject
     * @var \App\Service\OrderService
     */
    protected OrderService $orderService;

    public function getUserPublishForumList()
    {
        //管理员可以返回全部的板块
        $user = User::findOrFail($this->userId());
        if($user->isAdmin()) {
            return $this->getForumList();
        }

        //非授权或者付费板块
        $list = Forum::query()->with(['child_forum_list'])
            ->where('goods_id',0)
            ->orWhere('need_auth',Constants::STATUS_WAIT)
            ->where('forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('type',Constants::FORUM_TYPE_MAIN)
            ->get();
        //获取用户已经获得授权的板块信息
        $userSubscribeList = UserSubscribe::query()->where('user_id', $this->userId())
                                                   ->with(['forum'])
                                                   ->get()
                                                   ->pluck('forum');

        //合并数据
        return $userSubscribeList->union($list)->unique()->sortByDesc('need_auth')->sortByDesc('goods_id')->values()->all();
    }

    public function getForumList()
    {
        $list = Forum::query()->with(['child_forum_list'])
            ->where('forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('type',Constants::FORUM_TYPE_MAIN)
            ->orderByDesc('goods_id')
            ->orderByDesc('need_auth')
            ->get();

        //增加订阅状态
        $mySubscribeList = UserSubscribe::query()->where('user_id',$this->userId())
                                                 ->get()
                                                 ->keyBy('forum_id');

        $list->map(function (Forum $forum) use ($mySubscribeList) {
            if($mySubscribeList->get($forum->forum_id) !== null) {
                $forum->is_subscribe = 1;
            }else{
                $forum->is_subscribe = 0;
            }
            return $forum;
        });

        return $list;
    }

    public function subscribe(int $forumId, int $userId = null)
    {
        if(!isset($userId)) {
            $userId = $this->userId();
        }
        $subscribe = UserSubscribe::query()->where('user_id', $userId)
            ->where('forum_id', $forumId)
            ->first();
        if ($subscribe instanceof UserSubscribe) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $subscribe = new UserSubscribe();
        $subscribe->user_id = $userId;
        $subscribe->forum_id = $forumId;
        $subscribe->saveOrFail();
        return $this->success();
    }

    public function unlockSubscribe(int $forumId, string $unlockSn, int $policyId)
    {
        Db::transaction(function () use ($forumId,$unlockSn,$policyId) {
            //解锁
            $voucher = UserSubscribePassword::query()->where('policy_id',$policyId)
                ->where('unlock_sn',$unlockSn)
                ->lockForUpdate()
                ->first();
            if(!$voucher instanceof UserSubscribePassword) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            if($voucher->status == Constants::STATUS_DONE) {
                throw new HyperfCommonException(\App\Constants\ErrorCode::FORUM_UNLOCK_STATUS_DONE);
            }
            if($voucher->status == Constants::STATUS_INVALIDATE) {
                throw new HyperfCommonException(\App\Constants\ErrorCode::FORUM_UNLOCK_STATUS_INVALIDATE);
            }
            if($voucher->policy->forum->forum_id !== $forumId) {
                throw new HyperfCommonException(\App\Constants\ErrorCode::FORUM_UNLOCK_NOT_EQUAL);
            }
            $this->subscribe($forumId);
            $voucher->status = Constants::STATUS_DONE;
            $voucher->saveOrFail();
        });
        return $this->success();
    }

    public function buyAndSubscribe(int $forumId)
    {
        $forum = Forum::findOrFail($forumId);
        if($forum->goods_id == Constants::GOODS_ID_INVALIDATE) {
            //无需付费，直接走常规订阅
            return $this->subscribe($forumId);
        }
        //查出商品
        $goodsInfo = Good::findOrFail($forum->goods_id);
        $user = User::findOrFail($this->userId());
        $orderInfo = [
            'goodsList' => [
                [
                    'goodsId' => $goodsInfo->goods_id,
                    'count' => 1
                ]
            ],
            'shopId' => $goodsInfo->shop_id,
            'nickname' => $user->nickname,
            'mobile' => $user->mobile,
            'note' => '自动发货',
            'deliverType' => 0
        ];
        //查出用户的地址信息
        $address = UserAddress::query()->where('owner_id',$this->userId())->first();
        if ($address instanceof UserAddress) {
            $addressInfo = "{$address->city}{$address->country}{$address->detail_info}";
        }else{
            $addressInfo = "购买虚拟产品可不填写地址";
        }
        $orderInfo['address'] = $addressInfo;
        return $this->orderService->create($orderInfo);
    }

    public function unsubscribe(int $forumId)
    {
        $subscribe = UserSubscribe::query()->where('user_id', $this->userId())
            ->where('forum_id', $forumId)
            ->first();
        if (!$subscribe instanceof UserSubscribe) {
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }
        $subscribe->delete();
        return $this->success();
    }

    public function mySubscribeList()
    {
        $list = UserSubscribe::query()->with(['forum'])
            ->where('forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('user_id', $this->userId())
                                    ->get()
                                    ->pluck('forum');
        $list->map(function (Forum $forum) {
            $forum->is_subscribe = 1;
            return $forum;
        });
        return $list->sortByDesc('need_auth')->sortByDesc('goods_id')->values()->all();
    }

    protected function generateUnlockSn(string $prefix)
    {
        $datetime = date('YmdHis');
        $now = Carbon::now();
        $microsecond = $now->microsecond;
        return $prefix.$datetime.$microsecond;
    }

    public function getUnlockForumSn(int $forumId, int $policyId)
    {
        $voucher = null;
        Db::transaction(function () use ($forumId, $policyId, &$voucher){
            //用户是不是已经领过券了
            $voucher = UserSubscribePassword::query()->where('policy_id',$policyId)
                                                     ->where('owner_id',$this->userId())
                                                     ->first();
            if($voucher instanceof UserSubscribePassword) {
                throw new HyperfCommonException(\App\Constants\ErrorCode::DO_NOT_REPEAT_ACTION,'您已经领过该券了');
            }
            $policy = SubscribeForumPassword::query()->where('policy_id',$policyId)
                                                     ->lockForUpdate()
                                                     ->first();
            if(!$policy instanceof SubscribeForumPassword) {
                throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
            }
            if ($policy->forum_id !== $forumId) {
                Log::error("传递的板块ID($forumId)和批次内包含的板块ID({$policy->forum_id})不一致!");
                throw new HyperfCommonException(ErrorCode::PARAM_ERROR);
            }
            if ($policy->left_count == 0) {
                Log::error("{$policyId}批次授权已经用完");
                throw new HyperfCommonException(\App\Constants\ErrorCode::FORUM_UNLOCK_PASSWORD_ERROR);
            }
            //创建批次对应的授权码
            $sn = $this->generateUnlockSn($policy->sn_prefix);
            $voucher = new UserSubscribePassword();
            $voucher->unlock_sn = $sn;
            $voucher->policy_id = $policyId;
            $voucher->owner_id = $this->userId();
            $voucher->saveOrFail();
            $policy->decrement('left_count');
        });

        if (!isset($voucher)) {
            Log::info("($policyId)批次领取失败!");
            throw new HyperfCommonException(ErrorCode::RECORD_NOT_EXIST);
        }

        return $this->success($voucher);
    }

    public function getMySubscribeVoucherList(int $pageIndex, int $pageSize)
    {
        $list = UserSubscribePassword::query()->where('owner_id', $this->userId())
                                              ->offset($pageIndex * $pageSize)
                                              ->limit($pageSize)
                                              ->get();
        $total = UserSubscribePassword::query()->where('owner_id', $this->userId())->count();

        return ['total'=>$total,'list'=>$list];
    }
}