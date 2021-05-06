<?php


namespace App\Service\Admin;

use App\Constants\Constants;
use App\Constants\ErrorCode;
use App\Model\Post;
use App\Model\User;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsPromotionUrlGenerateRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsRecommendGetRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsSearchRequest;
use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Psr\Container\ContainerInterface;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Log\Log;
use ZYProSoft\Service\AbstractService;
use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkRpPromUrlGenerateRequest;

class PddService extends AbstractService
{
    const MALL_TYPE_PDD = 0;

    const BUY_FORUM_ID = 9;

    const PDD_ACCESS_TOKEN_CODE = 'lulingshuo';

    const PDD_ACCESS_TOKEN_CACHE_KEY = 'pdd:ac:tk';

    private string $clientId;

    private string $clientSecret;

    private string $authCode;

    private array $pidList;

    private string $accessToken;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->clientId = config('mall.pdd.client_id');
        $this->clientSecret = config('mall.pdd.client_secret');
        $this->pidList = [config('mall.pdd.pid')];
        $this->authCode = config('mall.pdd.auth_code');
    }

    public function searchCondition()
    {
        return [
            //活动商品标记数组，例：[4,7]，4-秒杀，7-百亿补贴，10851-千万补贴，
            //31-品牌黑标，10564-精选爆品-官方直推爆款，10584-精选爆品-团长推荐，24-品牌高佣，其他的值请忽略
            'activity_tags' => [7,10851,31,10564,10854,24],
           //屏蔽商品类目包：1-拼多多小程序屏蔽的类目&关键词;2-虚拟类目;3-医疗器械;4-处方药;5-非处方药
            'block_cat_packages' => [1,2,3,4,5],
            //筛选范围列表 样例：[{"range_id":0,"range_from":1,"range_to":1500},
            //{"range_id":1,"range_from":1,"range_to":1500}]
            'range_list' => [[
                'range_from' => 1,
                'range_id' => 2,
                'sort_type' => 2,
                'with_coupon' => true,
            ]],
        ];
    }

    public function notify()
    {

    }

    public function generatePidAuthUrl()
    {
        $request = new PddDdkRpPromUrlGenerateRequest();
        $request->setChannelType(10);
        $request->setGenerateWeApp(true);
        $request->setPIdList($this->pidList);
        $content = $this->commonRequest($request);
        return data_get($content,'rp_promotion_url_generate_response');
    }

    public function commonRequest(PopBaseHttpRequest $request)
    {
        $client = new PopHttpClient($this->clientId, $this->clientSecret);
        try {
            $response = $client->syncInvoke($request);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new HyperfCommonException($e->getCode(),$e->getMessage());
        }
        Log::info($response->getBody());
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            $errMsg = data_get($content,'error_response.error_msg');
            throw new HyperfCommonException(ErrorCode::CALL_PDD_ERROR,$errMsg);
        }
        return $content;
    }

    public function search(string $keyword, int $pageIndex, int $pageSize, string $listId = null, int $optId = null)
    {
        $request = new PddDdkGoodsSearchRequest();
        $condition = $this->searchCondition();
        $request->setActivityTags($condition['activity_tags']);
        $request->setBlockCatPackages($condition['block_cat_packages']);
        $request->setRangeList($condition['range_list']);
        $request->setKeyword($keyword);
        $request->setPage($pageIndex);
        $request->setPageSize($pageSize);
        $request->setPid($this->pidList[0]);
        if (isset($listId)) {
            $request->setListId($listId);
        }
        if (isset($optId)) {
            $request->setOptId($optId);
        }
        $content = $this->commonRequest($request);
        return data_get($content,'goods_search_response');
    }

    public function recommendList(int $pageIndex, int $pageSize, string $listId = null)
    {
        $request = new PddDdkGoodsRecommendGetRequest();
        $request->setOffset($pageIndex*$pageSize);
        if(isset($listId)) {
            $request->setListId($listId);
        }
        $request->setLimit($pageSize);
        $content = $this->commonRequest($request);
        return data_get($content,'goods_basic_detail_response');
    }

    public function generateBuyInfo(string $goodsSign, string $searchId = null)
    {
        $request = new PddDdkGoodsPromotionUrlGenerateRequest();
        $request->setPId($this->pidList[0]);
        $request->setGoodsSignList([$goodsSign]);
        $request->setGenerateWeApp(true);
        if (isset($searchId)) {
            $request->setSearchId($searchId);
        }
        $content = $this->commonRequest($request);
        return data_get($content,'goods_promotion_url_generate_response.goods_promotion_url_list')[0];
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
            $post->forum_id = self::BUY_FORUM_ID;
        }
        //获取跳转信息
        $searchId = data_get($goodsInfo,'search_id');
        $goodsSign = data_get($goodsInfo,'goods_sign');
        $buyInfo = $this->generateBuyInfo($goodsSign,$searchId);
        $post->mall_goods_buy_info = json_encode($buyInfo);
        $post->mall_type = self::MALL_TYPE_PDD;
        $post->audit_status = Constants::STATUS_DONE;
        //允许使用化身来发布
        $userId = $this->userId();
        $user = User::find($userId);
        if ($user->role_id == Constants::USER_ROLE_ADMIN) {
            //检查是不是在使用化身
            if ($user->avatar_user_id > 0) {
                Log::info("使用化身($user->avatar_user_id)");
                $userId = $user->avatar_user_id;
            }
        }
        $post->owner_id = $userId;
        $post->saveOrFail();
        return $this->success($post);
    }
}