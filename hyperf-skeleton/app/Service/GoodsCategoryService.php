<?php


namespace App\Service;


use App\Model\GoodsCategory;

class GoodsCategoryService extends BaseService
{
    public function getAllWithShopId(int $shopId)
    {
        return GoodsCategory::query()->where('create_user',$this->userId())
            ->where('shop_id', $shopId)
            ->latest()
            ->get();
    }
}