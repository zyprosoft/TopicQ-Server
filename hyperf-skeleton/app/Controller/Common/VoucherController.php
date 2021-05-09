<?php


namespace App\Controller\Common;
use App\Service\VoucherService;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use ZYProSoft\Http\AuthedRequest;

/**
 * @AutoController (prefix="/common/voucher")
 * Class VoucherController
 * @package App\Controller\Common
 */
class VoucherController extends AbstractController
{
    /**
     * @Inject
     * @var VoucherService
     */
    protected VoucherService $service;

    public function createVoucher(AuthedRequest $request)
    {
        $this->validate([
            'policyId' => 'integer|required|exists:voucher_policy,policy_id',
        ]);
        $policyId = $request->param('policyId');
        $result = $this->service->createVoucher($policyId);
        return $this->success($result);
    }

    public function getMyVoucherList(AuthedRequest $request)
    {
        $this->validate([
            'status' => 'integer|required|0,1',
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $status = $request->param('status');
        $result = $this->service->getMyVoucherList($pageIndex,$pageSize,$status);
        return $this->success($result);
    }

    public function getMyVoucherUseHistory(AuthedRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getMyVoucherUseHistoryList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function getOrderGoodsMatchedVoucherList(AuthedRequest $request)
    {
        $this->validate([
            'goodsList.*.goodsId' => 'required|integer|exists:goods,goods_id',
            'goodsList.*.count' => 'required|integer|min:1|max:999',
        ]);
        $orderGoods = $request->param('goodsList');
        $result = $this->service->getVoucherListByGoodsIds($orderGoods);
        return $this->success($result);
    }
}