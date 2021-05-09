<?php


namespace App\Service\Admin;
use App\Constants\Constants;
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
        if (isset($params['image_list'])) {
            $activity->image_list = implode(';',$params['image_list']);
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

}