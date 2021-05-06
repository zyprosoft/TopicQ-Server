<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Shop;
use App\Service\BaseService;
use App\Service\UserService;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;

class ShopService extends BaseService
{
    /**
     * 检查店铺发布状态
     * @param int $shopId
     */
    public static function checkShopPublishOrFail(int $shopId)
    {
        $shop = Shop::find($shopId);
        if (!$shop instanceof Shop) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }
        if ($shop->status == Constants::STATUS_WAIT) {
            throw new HyperfCommonException(ErrorCode::SHOP_PAUSED_PUBLISH);
        }
        return $shop;
    }

    /**
     * 检查所操作店铺是否属于当前用户
     * @param $shopId
     */
    public static function checkOwnOrFail(int $shopId)
    {
        //先检查店铺ID是否属于用户
        $shop = Shop::findOrFail($shopId);

        if (!$shop instanceof Shop) {
            throw new HyperfCommonException(\ZYProSoft\Constants\ErrorCode::RECORD_NOT_EXIST);
        }

        //如果是管理员直接成功
        if (Auth::isAdmin()) {
            return $shop;
        }

        if ($shop->owner_id != Auth::userId()) {
            throw new HyperfCommonException(ErrorCode::SHOP_NOT_BELONG_CURRENT_USER);
        }

        return $shop;
    }

    public static function checkOwnByUserId(int $userId, int $shopId)
    {
        //先检查店铺ID是否属于用户
        $shop = Shop::findOrFail($shopId);

        if (!$shop instanceof Shop) {
            return false;
        }

        if ($shop->owner_id != $userId) {
            return  false;
        }

        return  true;
    }

    public static function checkOwn(int $shopId)
    {
        //先检查店铺ID是否属于用户
        $shop = Shop::findOrFail($shopId);

        if (!$shop instanceof Shop) {
            return false;
        }

        if ($shop->owner_id != Auth::userId()) {
            return  false;
        }

        return  true;
    }

    public function create(array $params)
    {
        //用户是不是已经被拉黑
        UserService::checkUserStatusOrFail();

        $shop = new Shop();
        $shop->name = $params['name'];
        $shop->address = $params['address'];
        $shop->image = $params['image'];
        $shop->introduce = $params['introduce'];
        $shop->phone_number = $params['phone'];
        if (isset($params['basePrice'])) {
            $shop->base_deliver_price = $params['basePrice'];
        }
        if (isset($params['openTime'])) {
            $shop->open_time = $params['openTime'];
        }
        if (isset($params['closeTime'])) {
            $shop->close_time = $params['closeTime'];
        }
        $shop->owner_id = $this->userId();
        //从图片里面得到image_id
        $imageID = collect(explode('/',$shop->image))->last();
        $shop->image_id = $imageID;

        $shop->saveOrFail();

        return $shop;
    }

    public function delete(int $shopId)
    {
        //判定所有者关系
        $shop = ShopService::checkOwnOrFail($shopId);
        $shop->delete();
        return $this->success();
    }

    public function changeStatus(int $status, int $shopId)
    {
        $shop = ShopService::checkOwnOrFail($shopId);
        if ($shop->status == $status) {
            return $this->success();
        }
        $shop->status = $status;
        $shop->saveOrFail();
        return $this->success();
    }

    public function updateInfo(array $params, int $shopId)
    {
        $shop = ShopService::checkOwnOrFail($shopId);
        $updateKeys = collect([
            'name',
            'address',
            'image',
            'introduce'
        ]);
        $updateKeys->map(function ($key) use ($params,&$shop) {
            if (isset($params[$key])) {
                $shop->$key = $params[$key];
            }
        });
        if (isset($params['phone'])) {
            $shop->phone_number = $params['phone'];
        }
        if (isset($params['basePrice'])) {
            $shop->base_deliver_price = $params['basePrice'];
        }
        if (isset($params['openTime'])) {
            $shop->open_time = $params['openTime'];
        }
        if (isset($params['closeTime'])) {
            $shop->close_time = $params['closeTime'];
        }
        $shop->saveOrFail();

        return $shop;
    }
}