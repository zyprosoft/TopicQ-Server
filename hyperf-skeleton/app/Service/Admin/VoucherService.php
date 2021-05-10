<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Model\Post;
use App\Model\VoucherActivity;
use App\Model\VoucherPolicy;
use App\Model\VoucherPolicyBlackGood;
use App\Model\VoucherPolicyGood;
use App\Service\BaseService;
use Hyperf\DbConnection\Db;
use Hyperf\Utils\Str;
use ZYProSoft\Constants\ErrorCode;
use ZYProSoft\Exception\HyperfCommonException;

class VoucherService extends BaseService
{
    public function createActivity(array $params)
    {
        $activity = VoucherActivity::query()->where('name',$params['name'])
                                            ->first();
        if ($activity instanceof VoucherActivity) {
            throw new HyperfCommonException(ErrorCode::RECORD_DID_EXIST);
        }
        $activity = new VoucherActivity();
        $activity->name = $params['name'];
        if (isset($params['introduce'])) {
            $activity->introduce = $params['introduce'];
        }
        if (isset($params['imageList'])) {
            $activity->image_list = implode(';',$params['imageList']);
        }
        if(isset($params['beginTime'])) {
            $activity->begin_time = $params['beginTime'];
        }
        if (isset($params['endTime'])) {
            $activity->end_time = $params['endTime'];
        }
        $activity->saveOrFail();
        return $this->success();
    }

    public function getActivityList(int $pageIndex,int $pageSize)
    {
        $list = VoucherActivity::query()->where('status',Constants::STATUS_WAIT)
                                        ->offset($pageIndex * $pageSize)
                                        ->limit($pageSize)
                                        ->get();
        $list->map(function (VoucherActivity $activity) {
            if(!empty($activity->image_list)) {
                $activity->image_list = explode(';',$activity->image_list);
                return $activity;
            }
        });
        $total = VoucherActivity::query()->where('status',Constants::STATUS_WAIT)->count();
        return ['total'=>$total,'list'=>$list];
    }

    public function createPolicy(array $params)
    {
        Db::transaction(function () use ($params){

            $policy = new VoucherPolicy();
            $policy->activity_id = data_get($params,'activityId');
            $policy->total_count = data_get($params,'totalCount');
            $policy->left_count = $policy->total_count;
            $policy->amount = data_get($params,'amount');
            $policy->base_amount = data_get($params,'baseAmount',0);
            $policy->multi_use = data_get($params,'multiUse',0);
            $policy->sn_prefix = Str::upper(Str::random(10));
            $policy->time_span = data_get($params,'timeSpan');
            $policy->time_unit = data_get($params,'timeUnit');
            $acceptGoods = data_get($params,'acceptGoods', []);
            $blackGoods = data_get($params,'blackGoods', []);
            if (!empty($acceptGoods) && !empty($blackGoods)) {
                throw new HyperfCommonException(\App\Constants\ErrorCode::VOUCHER_POLICY_CREATE_CONFLICT);
            }
            //创建黑白名单适用记录
            if (!empty($acceptGoods)) {
                $policyGoods = new VoucherPolicyGood();
                $acceptCategoryIds = data_get($acceptGoods,'categoryIds', []);
                $acceptGoodsIds = data_get($acceptGoods,'goodsIds', []);
                if (!empty($acceptCategoryIds)) {
                    $policyGoods->category_list = implode(',',$acceptCategoryIds);
                }
                if (!empty($acceptGoodsIds)) {
                    $policyGoods->goods_list = implode(',',$acceptGoodsIds);
                }
                $policyGoods->saveOrFail();
                $policy->policy_goods_id = $policyGoods->policy_goods_id;
            }
            if (!empty($blackGoods)) {
                $policyBlackGoods = new VoucherPolicyBlackGood();
                $blackCategoryIds = data_get($blackGoods,'categoryIds', []);
                $blackGoodsIds = data_get($blackGoods,'goodsIds', []);
                if (!empty($blackCategoryIds)) {
                    $policyBlackGoods->category_list = implode(',',$blackCategoryIds);
                }
                if (!empty($blackGoodsIds)) {
                    $policyBlackGoods->goods_list = implode(',',$blackGoods);
                }
                $policyBlackGoods->saveOrFail();
                $policy->policy_black_id = $policyBlackGoods->policy_black_id;
            }
            $policy->saveOrFail();
        });
        return $this->success();
    }

    protected function getDisplayName($goodsOrBlackGoods,$isBlack)
    {
        $categoryItems = $goodsOrBlackGoods->category_items();
        $goodsItems = $goodsOrBlackGoods->goods_items();
        if($goodsItems->isNotEmpty()) {
            $names = $goodsItems->pluck('name')->toArray();
            return implode(';',$names);
        }else{
            if ($categoryItems->isNotEmpty()) {
                $names = $categoryItems->pluck('name')->toArray();
                return  implode(';',$names);
            }
        }
        return $isBlack? '无黑名单产品限制':'适用产品无限制';
    }

    public function getPolicyList(int $pageIndex, int $pageSize)
    {
        $list = VoucherPolicy::query()->offset($pageIndex * $pageSize)
                                      ->limit($pageSize)
                                      ->get();
        $list->map(function (VoucherPolicy $policy) {
             $policy->activity->image_list = explode(';',$policy->activity->image_list);
             if (isset($policy->goods)) {
                 $goodsDisplay =  $this->getDisplayName($policy->goods,false);
                 $policy->goods_display = $goodsDisplay;
             }else{
                 $policy->goods_display = '未选择适用产品';
             }
             if(isset($policy->black_goods)) {
                 $blackDisplay = $this->getDisplayName($policy->black_goods, true);
                 $policy->black_display = $blackDisplay;
             }else{
                 $policy->black_display = '未选择不适用产品';
             }
             return $policy;
        });
        $total = VoucherPolicy::count();
        return ['total'=>$total,'list'=>$list];
    }

    public function createPostForPolicy(int $policyId, string $title, string $content, string $link = null, array $imageList = null, int $forumId = null)
    {
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        if (mb_strlen($content) < 40) {
            $post->summary = $content;
        } else {
            $post->summary = mb_substr($content, 0, 40);
        }
        if (isset($imageList)) {
            $post->image_list = implode(';',$imageList);
        }
        if (isset($link)) {
            $post->link = $link;
        }
        //固定板块
        if (isset($forumId)) {
            $post->forum_id = $forumId;
        }else{
            $post->forum_id = Constants::FORUM_MAIN_FORUM_ID;
        }
        $post->voucher_policy_id = $policyId;
        $post->audit_status = Constants::STATUS_DONE;
        $post->owner_id = $this->userId();//发券只能管理员发布
        $post->saveOrFail();
        return $this->success($post);
    }
}