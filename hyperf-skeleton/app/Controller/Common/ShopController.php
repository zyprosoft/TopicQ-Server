<?php

namespace App\Controller\Common;
use ZYProSoft\Controller\AbstractController;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use App\Service\ShopService;

/**
 * @AutoController (prefix="/common/shop")
 * Class ShopController
 * @package App\Controller\Common
 */
class ShopController extends AbstractController
{
    /**
     * @Inject
     * @var ShopService
     */
    protected ShopService $service;

    public function info()
    {
        $this->validate([
            'shopId' => 'required|integer|exists:shop,shop_id',
        ]);
        $shopId = $this->request->param('shopId');
        $result = $this->service->info($shopId);
        return $this->success($result);
    }
}