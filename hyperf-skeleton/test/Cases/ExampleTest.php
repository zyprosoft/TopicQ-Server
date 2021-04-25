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

use App\Service\ThirdPartService;
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
            '户外',
            '购物',
            '团购',
            '女鞋',
            '休闲',
            '阅读',
            '汽车',
        ];
        foreach ($nameList as $name) {
            $service->createMiniProgramCategory($name);
        }
        foreach ($nameList as $name) {
            $service->createOfficialAccountCategory($name);
        }
    }

    public function createMiniProgram(int $categoryId, string $appId, string $name, string $icon, string $introduce)
    {
        
    }

    public function createOfficialAccount(int $categoryId, string $appId, string $name, string $icon, string $introduce)
    {

    }
}