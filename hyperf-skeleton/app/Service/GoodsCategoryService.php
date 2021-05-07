<?php


namespace App\Service;


use App\Constants\Constants;
use App\Model\GoodsCategory;

class GoodsCategoryService extends BaseService
{
    public function getAllWithShopId(int $shopId)
    {
        $systemCreateList = $this->getAllSystem();
        $userCreateList = GoodsCategory::query()->where('create_user',$this->userId())
            ->where('shop_id', $shopId)
            ->latest()
            ->get();

        return $userCreateList->merge($systemCreateList);
    }

    public function getAllSystem()
    {
        return GoodsCategory::query()->where('shop_id', Constants::CATEGORY_SHOP_ID_SYSTEM_USE)
            ->get();
    }
}