<?php


namespace App\Controller\Admin;
use App\Http\AppAdminRequest;
use App\Service\Admin\VoucherService;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;

/**
 * @AutoController (prefix="/admin/voucher")
 * Class VoucherController
 * @package App\Controller\Admin
 */
class VoucherController extends AbstractController
{
    /**
     * @Inject
     * @var VoucherService
     */
    protected VoucherService $service;

    public function createActivity(AppAdminRequest $request)
    {
        $this->validate([
            'name' => 'string|required|min:1|max:32',
            'introduce' => 'string|min:1|max:500',
            'imageList' => 'string|min:1|max:500',
            'beginTime' => 'date',
            'endTime' => 'date'
        ]);
        $params = $request->getParams();
        $result = $this->service->createActivity($params);
        return $this->success($result);
    }

    public function getActivityList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getActivityList($pageIndex,$pageSize);
        return $this->success($result);
    }

    public function createPolicy(AppAdminRequest $request)
    {
        $this->validate([
            'activityId' => 'string|required|exists:voucher_activity,activity_id',
            'totalCount' => 'integer|required|min:1',
            'amount' => 'integer|required|min:1',
            'baseAmount' => 'integer|min:0',
            'multiUse' => 'integer|in:0,1',
            'timeSpan' => 'integer|required_with:timeUnit|min:1',
            'timeUnit' => 'string|required_with:timeSpan|in:p,h,d,m,y',
            'acceptGoods.categoryIds.*' => 'integer|exists:goods_category,category_id',
            'acceptGoods.goodsIds.*' => 'integer|exists:goods,goods_id',
            'blackGoods.categoryIds.*' => 'integer|exists:goods_category,category_id',
            'blackGoods.goodsIds.*' => 'integer|exists:goods,goods_id',
        ]);
        $params = $request->getParams();
        $result = $this->service->createPolicy($params);
        return $this->success($result);
    }

    public function getPolicyList(AppAdminRequest $request)
    {
        $this->validate([
            'pageIndex' => 'integer|required|min:0',
            'pageSize' => 'integer|required|min:10|max:30',
        ]);
        $pageIndex = $request->param('pageIndex');
        $pageSize = $request->param('pageSize');
        $result = $this->service->getPolicyList($pageIndex,$pageSize);
        return $this->success($result);
    }
}