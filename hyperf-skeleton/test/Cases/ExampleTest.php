<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace HyperfTest\Cases;

use App\Service\Admin\ForumService;
use App\Service\Admin\ThirdPartService;
use App\Service\PddService;
use App\Task\PostRecommendCalculateTask;
use EasyWeChat\Factory;
use Hyperf\Utils\ApplicationContext;
use HyperfTest\HttpTestCase;
use Qbhy\HyperfTesting\Client;
use ZYProSoft\Log\Log;

/**
 * @internal
 * @coversNothing
 */
class ExampleTest extends HttpTestCase
{
    /**
     * @var Client
     */
    protected $client;

    private string $appId = "devjianghu";

    private string $appSecret = "jianghunow";

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = make(Client::class);
    }

    private function sign($param, $interfaceName, $timestamp, $nonce)
    {
        $testAppId = $this->appId;
        $testAppSecret = $this->appSecret;

        $param["interfaceName"] = $interfaceName;
        ksort($param);
        $paramString = md5(json_encode($param, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));

        $base = "appId=$testAppId&appSecret=$testAppSecret&nonce=$nonce&timestamp=$timestamp&$paramString";
        return hash_hmac("sha256", $base, $testAppSecret);
    }

    public function safeRequest(string $interfaceName, array $params, string $token = null)
    {
        $timestamp = time();
        $nonce = rand();
        $params = [
            "token" => $token,
            "version" => "1.0",
            "seqId" => strval($timestamp),
            "spanId" => strval($timestamp),
            "timestamp" => $timestamp,
            "eventId" => time(),
            "caller" => "test",
            "interface" => [
                "name" => $interfaceName,
                "param" => $params,
            ]
        ];
        $sign = $this->sign($params["interface"]["param"], $params["interface"]["name"], $timestamp, $nonce);
        $params["auth"] = [
            "timestamp" => $timestamp,
            "signature" => $sign,
            "nonce" => $nonce,
            "appId" => $this->appId
        ];
        $response = $this->client->json("/", $params)->assertOk();
        echo $response->getContent().PHP_EOL;
        return $response;
    }

    public function testLogin()
    {
        $result = $this->safeRequest('admin.user.login',[
            'username' => 'admin',
            'password' => 'admin123'
        ]);
        return $result['data']['token'];
    }

    public function testCreatePost()
    {
        $token = $this->testLogin();
        $params = [
            'title'=> '发布的第一个帖子',
            'content' => '发布帖子的内容，小牛牛',
            'link' => 'http://www.baidu.com',
            'imageList' => [
                'https://gimg2.baidu.com/image_search/src=http%3A%2F%2F01.minipic.eastday.com%2F20170313%2F20170313143139_614b883e9c49c0d0f146f41da9a3967c_3.jpeg&refer=http%3A%2F%2F01.minipic.eastday.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1619929919&t=8eb3b61502f7902aade8eec64defc3cc'
            ],
            'vote' => [
                'subject' => '牛牛是不是小帅哥',
                'items' => [
                    ['content'=>'牛牛有点小帅'],
                    ['content'=>'牛牛很可爱'],
                    ['content'=>'牛牛卡哇伊']
                ],
            ],
        ];
        $this->safeRequest('common.post.create',$params,$token);
    }

    public function testPostDetail()
    {
        $params = [
            'postId'=>1,
        ];
        $this->safeRequest('common.post.detail',$params);
    }

    public function testCreateComment()
    {
        $token = $this->testLogin();
        $params = [
            'postId' => 1,
            'content' => '我评论的第一条内容',
            'link' => 'http://www.baidu.com',
            'imageList' => [
                'https://gimg2.baidu.com/image_search/src=http%3A%2F%2F01.minipic.eastday.com%2F20170313%2F20170313143139_614b883e9c49c0d0f146f41da9a3967c_3.jpeg&refer=http%3A%2F%2F01.minipic.eastday.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1619929919&t=8eb3b61502f7902aade8eec64defc3cc'
            ],
        ];
        $this->safeRequest('common.comment.create',$params,$token);
    }

    public function testReply()
    {
        $token = $this->testLogin();
        $params = [
            'commentId' => 1,
            'content' => '我回复的第一条内容',
            'link' => 'http://www.baidu.com',
            'imageList' => [
                'https://gimg2.baidu.com/image_search/src=http%3A%2F%2F01.minipic.eastday.com%2F20170313%2F20170313143139_614b883e9c49c0d0f146f41da9a3967c_3.jpeg&refer=http%3A%2F%2F01.minipic.eastday.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1619929919&t=8eb3b61502f7902aade8eec64defc3cc'
            ],
        ];
        $this->safeRequest('common.comment.reply',$params,$token);
    }

    public function testPostList()
    {
        $params = [
            'pageIndex' => 0,
            'pageSize' => 10,
            'type' => 1,
        ];
        $this->safeRequest('common.post.list',$params);

        $params = [
            'pageIndex' => 0,
            'pageSize' => 10,
            'type' => 2,
        ];
        $this->safeRequest('common.post.list',$params);

        $params = [
            'pageIndex' => 0,
            'pageSize' => 10,
            'type' => 3,
        ];
        $this->safeRequest('common.post.list',$params);
    }

    public function testUserPostList()
    {
        $token = $this->testLogin();
        $params = [
            'pageIndex' => 0,
            'pageSize' => 10,
        ];
        $this->safeRequest('common.post.listByUser', $params, $token);
    }

    public function testCommentList()
    {
        $params = [
            'postId' => 1,
            'pageIndex' => 0,
            'pageSize' => 10,
            'type' => 1,
        ];
        $this->safeRequest('common.comment.list',$params);
    }

    public function testUserCommentList()
    {
        $token = $this->testLogin();
        $params = [
            'pageIndex' => 0,
            'pageSize' => 10,
        ];
        $this->safeRequest('common.comment.listByUser', $params, $token);
    }

    public function testCreateCategory()
    {
        $service = ApplicationContext::getContainer()->get(ThirdPartService::class);
        $nameList = [
            '推荐',
            '政务',
            '民生',
            '医疗',
            '教育',
            '美食',
            '娱乐',
            '阅读',
            '户外',
            '购物',
            '休闲',
            '汽车',
        ];
        foreach ($nameList as $name) {
            $service->createMiniProgramCategory($name);
        }
        foreach ($nameList as $name) {
            $service->createOfficialAccountCategory($name);
        }
    }

    public function createMiniProgram(int $categoryId, string $appId,string $shortName, string $name, string $icon, string $introduce)
    {
        $service = ApplicationContext::getContainer()->get(ThirdPartService::class);
        $service->addMiniProgram($categoryId,$appId,$shortName,$name,$icon,$introduce);
    }

    public function createOfficialAccount(int $categoryId, string $wechatId, string $name, string $icon, string $introduce)
    {
        $service = ApplicationContext::getContainer()->get(ThirdPartService::class);
        $service->addOfficialAccount($categoryId,$wechatId,$name,$icon,$introduce);
    }

    public function testCreateMiniProgram()
    {
        $miniList = [
            [
                'categoryId' => 1,
                'appId' => 'wxdbc858d8bb1722f4',
                'shortName' => '吉安市图书馆',
                'name' => '吉安市图书馆',
                'icon' => 'https://static.lulingshuo.icodefuture.com/1618916654716',
                'introduce' =>'吉安市图书馆数字阅读平台为广大读者提供丰富、优质的数字资源。平台拥有精读图书资源，听书，电子书，视频等'
            ]
        ];
        $officialList = [
            [
                'categoryId' => 1,
                'wechatId' => 'iCodeLeadsTheFuture',
                'name' => '码动未来信息科技',
                'icon' => 'https://static.lulingshuo.icodefuture.com/1618916654716',
                'introduce' =>'码动未来信息科技专注于社区生活服务平台开发'
            ]
        ];
        foreach ($miniList as $item) {
            $this->createMiniProgram($item['categoryId'],$item['appId'],$item['shortName'],$item['name'],$item['icon'],$item['introduce']);
        }
        foreach ($officialList as $item) {
            $this->createOfficialAccount($item['categoryId'],$item['wechatId'],$item['name'],$item['icon'],$item['introduce']);
        }
    }

    public function testCreateForum()
    {
        $formList = [
            [
                'name' => '房屋租售',
                'icon' => 'https://static.lulingshuo.icodefuture.com/1618912738538'
            ],
            [
                'name' => '求职招聘',
                'icon' => 'https://static.lulingshuo.icodefuture.com/1618912738538'
            ],
            [
                'name' => '亲子乐园',
                'icon' => 'https://static.lulingshuo.icodefuture.com/1618912738538'
            ]
        ];
        $service = ApplicationContext::getContainer()->get(ForumService::class);
        foreach ($formList as $item)
        {
            $service->createForum($item['name'],$item['icon']);
        }
    }

    public function testImportMiniProgram()
    {
        $miniProgramList = [
            [
                'name' => '制作器',
                'shortName' => '制作器',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM4eDBzz8icPXs66HVlJTzh4U77GJQoRMIMXzjayWgDgaWA/0/0',
                'appId' => 'wxab0b8413a26e53cf',
                'categoryId' => 2,
                'index_path' => 'pages/zhuangx/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '闪萌表情',
                'shortName' => '闪萌表情',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM43BjsJSIWLYLyEE97hAic8dSH8eAoaIFOTGjc3oBnC8IA/0/0',
                'appId' => 'wx73b5c9319faa223d',
                'categoryId' => 3,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '亲戚关系',
                'shortName' => '亲戚关系',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6oibaCb1uQV4MDNL8kfjpT8d4UmibMjMwhmBVL2SwBuPZQ/0/0',
                'appId' => 'wx804ba197dbed27a3',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '下厨房',
                'shortName' => '下厨房',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6KkQ7iciaXoHZEPE9XSKm4ZE7RKNGibPJk8NgzDgs0R4gpg/0/0',
                'appId' => 'wxb11f14b08a38ba44',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '腾讯投票',
                'shortName' => '腾讯投票',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6Slp5wiakvkG7lgDibiby0fxXC9V0Sr6KL9ibSayBibrlgBnw/0/0',
                'appId' => 'wxa2ad902d74975650',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '车来了',
                'shortName' => '车来了',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6aMwuwmfX7uu4rJ7rS9l2htQY6rFVkBRwZQaXFsoRT8A/0/0',
                'appId' => 'wx71d589ea01ce3321',
                'categoryId' => 2,
                'index_path' => 'pages/main/main',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '爱壁纸',
                'shortName' => '爱壁纸',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6NJARv6TcdDfbiacBRG6V2k1snQoibM1liaqfBygx5ILsqw/0/0',
                'appId' => 'wx321d616246769829',
                'categoryId' => 2,
                'index_path' => 'pages/home/home',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '任务记分',
                'shortName' => '任务记分',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM4zBvmuGYhRicWv66ricKPoVOFjzcP08dEzSmHPjDia0lLJQ/0/0',
                'appId' => 'wx03cb68077b405b82',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '嗨翻群伴侣',
                'shortName' => '嗨翻群伴侣',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM70QiarFmjNx2jFrRaSJthjyuVgDEXBGPP2GXC7Oiax3Yyw/0/0',
                'appId' => 'wxd0b064896a65d8c1',
                'categoryId' => 3,
                'index_path' => 'pages/store/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '问卷调查',
                'shortName' => '问卷调查',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM4SWbECVaNAJxR163RTHgDWaw4kUkeyjfXEq7bS7tG6bg/0/0',
                'appId' => 'wx5ecfb47245f056fe',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '云鹦',
                'shortName' => '云鹦',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6y2iadibmEE5zfOvKyjTA4X0LriauIxy0PKPwBP4HYCejMw/0/0',
                'appId' => 'wx1d2327ff6b4a51c6',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '表情包',
                'shortName' => '表情包',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM42EgxnAcSpWXAJy97giabQf3wIV3ToVA477TcQBKOCKcQ/0/0',
                'appId' => 'wx2472740e19bf0e3f',
                'categoryId' => 3,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '抓阄分组',
                'shortName' => '抓阄分组',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM7zVjwA6wOYj7bJyoDR1UDgTjFW5ucaZ6EFic7xUiazV4Bg/0/0',
                'appId' => 'wx95dad29882768205',
                'categoryId' => 3,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '配音助手',
                'shortName' => '配音助手',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM7w0yWNWOuU705f4kFhEheVSuOxa7w9IrF9tZE2VK9bVw/0/0',
                'appId' => 'wx60a9d772d9e8dcb7',
                'categoryId' => 3,
                'index_path' => 'pages/tts/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '证件照生成器',
                'shortName' => '证件照生成器',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM4Z0MzFXFHIxCvzPmN4Fa7fC7niczRKuKWV0Cc6Bxna6RA/0/0',
                'appId' => 'wxdd09c9500614c89a',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '氢记账',
                'shortName' => '氢记账',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6V34jsVee4VWJqJhkVLqJrmoPLnKYU1JhiarqGDcOmxaQ/0/0',
                'appId' => 'wxcb88a6253f606adc',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '木兮诗词',
                'shortName' => '木兮诗词',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM7bzWPJHxpsnxulerPEQaU2bK86R5RR4re12ehQnkkpLg/0/0',
                'appId' => 'wx7891daf28cca37c8',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '彩虹屁',
                'shortName' => '彩虹屁',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM5B7fS5vibnuTibXBJsSKWVdicicDwkWDScjqk3DP04XTkn9Q/0/0',
                'appId' => 'wx3e75a118d4c93f91',
                'categoryId' => 3,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '微信记账本',
                'shortName' => '微信记账本',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6u5MS2HDZkxj2TiaicM8YPic3baUQPEDTxhPxxO2bEWlDSg/0/0',
                'appId' => 'wx7c86e0c731b9b8ef',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '游戏语音包',
                'shortName' => '游戏语音包',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6zIZiatl8vzjicq8JndlU6dhcrSZR2tbsSruPLaOniaz89g/0/0',
                'appId' => 'wx31d6f0cbf9bd101e',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '标准证件照',
                'shortName' => '标准证件照',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6RrqScLgib8M37pB4x4zDGCyZBkxajHY6icZUaWkjpuOHA/0/0',
                'appId' => 'wx666b9f5791ab2a08',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '通信行程卡',
                'shortName' => '通信行程卡',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM6ibtD7H8v23G9erK5CKAoicu8zJKjPw7w66sCm98sv2pQA/0/0',
                'appId' => 'wx8f446acf8c4a85f5',
                'categoryId' => 2,
                'index_path' => 'pages/index/index',
                'introduce' => '简介待更新'
            ],
            [
                'name' => '微井大',
                'shortName' => '微井大',
                'icon' => 'https://wx.qlogo.cn/mmhead/Q3auHgzwzM4nCpkwwndTLsU9kVHrib3e18qLlaNmx414FYJnsHgzz5w/0/0',
                'appId' => 'wx569af449b808a5b1',
                'categoryId' => 1,
                'index_path' => 'pages/home/home',
                'introduce' => '简介待更新'
            ]
        ];
        foreach ($miniProgramList as $item) {
            $this->createMiniProgram($item['categoryId'],$item['appId'],$item['shortName'],$item['name'],$item['icon'],$item['introduce']);
        }
    }

    public function testHotRecommend()
    {
        $task = make(PostRecommendCalculateTask::class);
        $task->execute();
    }

    public function testPdd()
    {
        $service = ApplicationContext::getContainer()->get(PddService::class);
//        $service->generatePid();
//        $service->generatePidAuthUrl();
        $service->queryPidAuthStatus();
    }

    public function testPushIndexPageToWeiXin()
    {
        $miniProgramConfig = config('weixin.miniProgram');
        Log::info('min program config:' . json_encode($miniProgramConfig));
        $app = Factory::miniProgram($miniProgramConfig);
        $app->search->submitPage(['pages/index/index']);
    }

    public function testParseDocUrl()
    {
        $config = [
            'base_uri' => 'https://docs.qq.com',
            'path' => '/doc/DYmFIWnZUdWx0c0N1',
            'method' => 'get'
        ];
        $client = new \GuzzleHttp\Client($config);
        $content = $client->get($config['path']);
        Log::info($content->getBody());
    }
}