<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\Forum;
use App\Model\Good;
use App\Model\User;
use App\Model\UserAddress;
use App\Model\UserSubscribe;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;
use App\Service\OrderService;
use Hyperf\Di\Annotation\Inject;

class ForumService extends BaseService
{
    /**
     * @Inject
     * @var \App\Service\OrderService
     */
    protected OrderService $orderService;

    public function getForumList()
    {
        $list = Forum::query()->with(['child_forum_list'])
            ->where('forum_id','>',Constants::FORUM_MAIN_FORUM_ID)
            ->where('type',Constants::FORUM_TYPE_MAIN)
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
                'goodsId' => $forum->goods_id,
                'count' => 1
            ],
            'shopId' => $goodsInfo->shop_id,
            'nickname' => $user->nickname,
            'mobile' => $user->mobile,
            'note' => '自动发货',
            'deliverType' => 0
        ];
        //查出用户的地址信息
        $address = UserAddress::first();
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
        return $list;
    }
}