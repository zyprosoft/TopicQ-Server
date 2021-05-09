<?php


namespace App\Service\Admin;
use App\Model\VoucherActivity;
use App\Model\VoucherPolicy;
use App\Model\VoucherPolicyBlackGood;
use App\Model\VoucherPolicyGood;
use App\Service\BaseService;
use Hyperf\DbConnection\Db;
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

    public function checkAcceptGoodsAndBlackGoods(array $acceptGoods, array $blackGoods)
    {
        if (empty($acceptGoods) && empty($blackGoods)) {
            return true;
        }
        if (empty($acceptGoods) && !empty($blackGoods)) {
            return true;
        }
        if (!empty($acceptGoods) && empty($blackGoods)) {
            return true;
        }

        $acceptCategoryIds = data_get($acceptGoods,'categoryIds', []);
        $acceptGoodsIds = data_get($acceptGoods,'goodsIds', []);

        $blackCategoryIds = data_get($blackGoods,'categoryIds', []);
        $blackGoodsIds = data_get($blackGoods,'goodsIds', []);

        //检查分类是否有交集
        $isValidate = collect($acceptCategoryIds)->intersect($blackCategoryIds)->count() > 0? false:true;
        if (!$isValidate) {
            throw new HyperfCommonException(\App\Constants\ErrorCode::VOUCHER_POLICY_CREATE_CATEGORY_CONFLICT);
        }

        //检查商品是否有交集
        $isValidate = collect($acceptGoodsIds)->intersect($blackGoodsIds)->count() > 0? false:true;
        if (!$isValidate) {
            throw new HyperfCommonException(\App\Constants\ErrorCode::VOUCHER_POLICY_CREATE_GOODS_CONFLICT);
        }

        return true;
    }

    public function createPolicy(array $params)
    {
        Db::transaction(function () use ($params){

            $policy = new VoucherPolicy();
            $policy->activity_id = $params['activityId'];
            $acceptGoods = data_get($params,'acceptGoods', []);
            $blackGoods = data_get($params,'blackGoods', []);
            //检查黑白冲突
            $this->checkAcceptGoodsAndBlackGoods($acceptGoods,$blackGoods);
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
            }


        });
    }

    public function createVoucher(array $params)
    {

    }
}