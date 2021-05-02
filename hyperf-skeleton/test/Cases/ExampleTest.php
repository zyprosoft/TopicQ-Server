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
use App\Task\PostRecommendCalculateTask;
use Hyperf\Utils\ApplicationContext;
use HyperfTest\HttpTestCase;
use Qbhy\HyperfTesting\Client;

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
                'name' => '吉安市人才资源开发服务部',
                'shortName' => '吉安人才',
                'icon' => '',
                'appId' => 'wxde2a897ae5e78ac6',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安市图书馆一网读尽',
                'shortName' => '吉安市图书馆',
                'icon' => '',
                'appId' => 'wxdbc858d8bb1722f4',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安政务服务投诉与建议',
                'shortName' => '吉安政务服务投诉与建议',
                'icon' => '',
                'appId' => 'wx65c2b54eae3f4352',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安县人民检查院',
                'shortName' => '庐陵检查',
                'icon' => '',
                'appId' => 'wx7d7017091dd36795',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安市检察院公益诉讼一键举报',
                'shortName' => '吉安检查',
                'icon' => '',
                'appId' => 'wxb63d90af7aec096e',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安电话本',
                'shortName' => '吉安电话本',
                'icon' => '',
                'appId' => 'wx0a97577ab0776dea',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '生活缴费',
                'shortName' => '生活缴费',
                'icon' => '',
                'appId' => 'wxd2ade0f25a874ee2',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安市阳光鲜奶',
                'shortName' => '吉安市阳光鲜奶',
                'icon' => '',
                'appId' => 'wx03cb68077b405b82',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安县中医院发热门诊线上咨询',
                'shortName' => '吉安县中医院',
                'icon' => '',
                'appId' => 'wx75e1dd168e31ef1a',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安市中心人民医院互联网医院',
                'shortName' => '吉安市中心人民医院',
                'icon' => '',
                'appId' => 'wx831c8c5230340075',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '春雨医生',
                'shortName' => '春雨医生',
                'icon' => '',
                'appId' => 'wx2e72ecb9760b913c',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安市青少年宫',
                'shortName' => '吉安市青少年宫',
                'icon' => '',
                'appId' => 'wx45681c86c8e43258',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安职业技术学院图书馆数字阅读',
                'shortName' => '吉安职业技术学院图书馆',
                'icon' => '',
                'appId' => 'wx5b40553c6509d357',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安县图书馆',
                'shortName' => '吉安县图书馆',
                'icon' => '',
                'appId' => 'wx71201b2eafc05a60',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '云游吉安',
                'shortName' => '云游吉安',
                'icon' => '',
                'appId' => 'wx7827424d4fb6f317',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安房信网',
                'shortName' => '吉安房信网',
                'icon' => '',
                'appId' => 'wxcb88a6253f606adc',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安孕婴之家',
                'shortName' => '吉安孕婴之家',
                'icon' => '',
                'appId' => 'wx1b26645627d70ae3',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安靓典造型发屋',
                'shortName' => '吉安靓典',
                'icon' => '',
                'appId' => 'wxad5b1f5a153d3413',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安芒果巨幕影院',
                'shortName' => '吉安芒果巨幕影院',
                'icon' => '',
                'appId' => 'wx56db74fb6a006093',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
            [
                'name' => '吉安县纯粮烧酒坊',
                'shortName' => '吉安县纯粮烧酒坊',
                'icon' => '',
                'appId' => 'wx713a37b3aa0a9edd',
                'categoryId' => 1,
                'introduce' => '简介待更新'
            ],
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
}