<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Good;
use App\Model\Post;
use App\Model\Unit;
use App\Model\User;
use App\Service\BaseService;
use App\Service\UserService;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;

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
        if(isset($params['desc'])) {
            $goods->desc = $params['desc'];
        }
        $goods->owner_id = $this->userId();
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

    public function createPost(string $title, string $content, array $goodsInfo, string $link = null, array $imageList = null, int $forumId = null)
    {
        $post = new Post();
        $post->title = $title;
        $post->content = $content;
        if (mb_strlen($content) < 40) {
            $post->summary = $content;
        } else {
            $post->summary = mb_substr($content, 0, 40);
        }
        $post->mall_goods = json_encode($goodsInfo);
        //商品图片作为图片使用
        if (!isset($imageList)) {
            $post->image_list = data_get($goodsInfo,'goods_image_url');
        }else{
            //增加商品图片
            $imageList[] = data_get($goodsInfo,'goods_image_url');
            $post->image_list = implode(';',$imageList);
        }

        if (isset($link)) {
            $post->link = $link;
        }
        //固定板块
        if (isset($forumId)) {
            $post->forum_id = $forumId;
        }else{
            $post->forum_id = Constants::BUY_FORUM_ID;
        }
        $buyInfo = [];
        $post->mall_goods_buy_info = json_encode($buyInfo);
        $post->mall_type = Constants::MALL_TYPE_SELF;
        $post->audit_status = Constants::STATUS_DONE;
        $post->owner_id = $this->userId();//自营店铺只能管理员发布
        $post->saveOrFail();
        return $this->success($post);
    }
}