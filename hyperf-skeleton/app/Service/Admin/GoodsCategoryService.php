<?php


namespace App\Service\Admin;
use App\Model\GoodsCategory;
use App\Model\Good;
use App\Service\BaseService;
use Hyperf\DbConnection\Db;
use ZYProSoft\Exception\HyperfCommonException;

class GoodsCategoryService extends BaseService
{
    public function create(string $name, string $image = null)
    {
        $category = new GoodsCategory();
        $category->name = $name;
        if (isset($image)) {
            $category->image = $image;
        }
        $category->create_user = $this->userId();
        $category->saveOrFail();
        return $this->success($category);
    }

    public function userCreate(string $name, int $shopId, string $image = null)
    {
        //先检查shopId有效性
        ShopService::checkOwnOrFail($shopId);

        //一个店铺最大的自定义分类数目
        $category = new GoodsCategory();
        $category->name = $name;
        $category->shop_id = $shopId;
        if (isset($image)) {
            $category->image = $image;
        }
        $category->create_user = $this->userId();
        $category->saveOrFail();
        return $this->success($category);
    }

    public function userUpdate(string $name, int $categoryId, int $shopId, string $image = null)
    {
        //先检查shopId有效性
        ShopService::checkOwnOrFail($shopId);

        $category = GoodsCategory::find($categoryId);
        if (!$category instanceof GoodsCategory) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        $category->name = $name;
        if (isset($image)) {
            $category->image = $image;
        }
        $category->saveOrFail();
        return $this->success($category);
    }

    public function userDelete(int $categoryId, int $shopId)
    {
        //先检查shopId有效性
        ShopService::checkOwnOrFail($shopId);
        Db::transaction(function () use($categoryId, $shopId) {
            $category = GoodsCategory::query()->where('category_id', $categoryId)
                ->where('shop_id', $shopId)
                ->where('create_user', $this->userId())
                ->firstOrFail();
            $category->delete();

            //同时删除分类下面的商品
            Good::query()->where('category_id', $categoryId)
                ->delete();
        });
        return $this->success();
    }
}