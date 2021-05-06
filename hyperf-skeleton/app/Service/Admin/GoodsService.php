<?php


namespace App\Service\Admin;
use App\Constants\ErrorCode;
use App\Model\Good;
use App\Model\Unit;
use App\Service\BaseService;
use App\Service\UserService;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;

class GoodsService extends BaseService
{
    public function allUnit()
    {
        return Unit::all()->pluck('name');
    }

    public function create(array $params)
    {
        //用户是不是已经被拉黑
        UserService::checkUserStatusOrFail();

        //先检查店铺ID是否属于用户
        $shopId = $params['shopId'];
        ShopService::checkOwnOrFail($shopId);

        $goods = new Good();
        $goods->name = $params['name'];
        $goods->category_id = $params['categoryId'];
        $goods->stock = $params['stock'];
        $goods->shop_id = $shopId;
        $goods->price = $params['price'];
        $goods->unit = $params['unit'];
        $goods->image = $params['image'];
        $goods->desc = $params['desc'];
        $goods->owner_id = $this->userId();
        //从图片里面得到image_id
        $imageID = collect(explode('/',$goods->image))->last();
        $goods->image_id = $imageID;
        $goods->saveOrFail();

        return $goods;
    }

    public function updateInfo(array $params)
    {
        $goodsId = $params['goodsId'];
        $goods = GoodsService::checkOwnOrFail($goodsId);
        $updateKeys = collect([
            'name',
            'stock',
            'price',
            'unit',
            'image',
        ]);
        $updateKeys->map(function ($key) use ($params, &$goods) {
            if (isset($params[$key])) {
                $goods->$key = $params[$key];
            }
        });
        $goods->saveOrFail();
        return $goods;
    }

    /**
     * 检查操作者是否有权限
     * @param $goodsId
     */
    public static function checkOwnOrFail(int $goodsId)
    {
        $goods = Good::findOrFail($goodsId);
        if (!$goods instanceof Good) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        if (Auth::isAdmin()) {
            return $goods;
        }
        if ($goods->owner_id != Auth::userId()) {
            throw new HyperfCommonException(ErrorCode::STAFF_NOT_BELONG_CURRENT_USER);
        }
        return  $goods;
    }

    public function delete(int $goodsId)
    {
        $goods = GoodsService::checkOwnOrFail($goodsId);
        $goods->delete();
        return $this->success();
    }
}