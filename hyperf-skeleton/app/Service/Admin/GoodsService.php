<?php


namespace App\Service\Admin;
use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Good;
use App\Model\Post;
use App\Model\Shop;
use App\Model\Unit;
use App\Model\User;
use App\Service\BaseService;
use App\Service\UserService;
use Carbon\Carbon;
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
            $post->image_list = data_get($goodsInfo,'image');
        }else{
            //增加商品图片
            $imageList[] = data_get($goodsInfo,'image');
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
        $post->last_active_time = Carbon::now()->toDateTimeString();
        $buyInfo = [];
        $post->mall_goods_buy_info = json_encode($buyInfo);
        $post->mall_type = Constants::MALL_TYPE_SELF;
        $post->audit_status = Constants::STATUS_DONE;
        $post->owner_id = $this->userId();//自营店铺只能管理员发布
        $post->saveOrFail();
        return $this->success($post);
    }

    /**
     * 获取所有虚拟产品
     */
    public function getSubscribeGoodsList()
    {
        $shop = Shop::firstOrFail();
        
        $allGoods = Good::query()->where('shop_id', $shop->shop_id)
            ->where('category_id',Constants::SUBSCRIBE_GOODS_CATEGORY_ID)
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
}