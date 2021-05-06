<?php


namespace App\Service;


use App\Model\Category;
use App\Model\Good;
use App\Model\GoodsCategory;
use ZYProSoft\Log\Log;

class GoodsService extends BaseService
{
    public function getGoodsListByShopId(int $shopId)
    {
        $allGoods = Good::query()->where('shop_id', $shopId)
            ->with(['category'])
            ->get();

        $categoryList = $allGoods->pluck('category')->unique();
        Log::info('category list:'.json_encode($categoryList));
        $categoryGoodsList = [];
        foreach ($allGoods as $goods) {
            $categoryId = $goods->category_id;
            $categoryGoodsList[$categoryId][] = $goods;
        }
        Log::info('category goods list:'.json_encode($categoryGoodsList));

        $resultList = [];
        $categoryList->map(function ($category) use ($categoryGoodsList, &$resultList) {
            Log::info('category item:'.json_encode($category));
            Log::info('goodsList:'.json_encode($categoryGoodsList[$category->category_id]));
            $categoryItem = $category->toArray();
            $categoryItem['goods_list'] = $categoryGoodsList[$category->category_id];
            Log::info('category item after:'.json_encode($categoryItem));
            $resultList[]=$categoryItem;
        });
        Log::info('category final list:'.json_encode($resultList));
        return $resultList;
    }

    public function getGoodsListByCategoryId(int $categoryId, int $shopId)
    {
        return Good::query()->where('category_id', $categoryId)
            ->where('shop_id', $shopId)
            ->get();
    }
}