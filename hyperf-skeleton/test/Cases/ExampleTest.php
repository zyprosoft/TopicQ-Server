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

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->client = make(Client::class);
    }

    private function sign($param, $interfaceName, $timestamp, $nonce)
    {
        $testAppId = "weshop";
        $testAppSecret = "zyprosoft";

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
            "appId" => "test"
        ];
        return $this->client->json("/", $params)->assertOk();
    }

    public function testLogin()
    {
        $result = $this->safeRequest('common.user.normalLogin',[
            'username' => 'admin',
            'password' => 'admin123'
        ]);
        return $result['data']['token'];
    }

    public function testCreateShop()
    {
        $token = $this->testLogin();
        $this->safeRequest('common.shop.create',[
            'name' => 'TestShop',
            'introduce' => 'test create shop',
            'image' => 'https://gimg2.baidu.com/image_search/src=http%3A%2F%2Fcdn0.hbimg.cn%2Fstore%2Fwm%2Fpiccommon%2F1220%2F12207%2FD525DAE38D909BE8D896CD9D16.jpg&refer=http%3A%2F%2Fcdn0.hbimg.cn&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=jpeg?sec=1617368705&t=ae267807105496d7a0e9c5059e836923',
            'address' => 'test shop address',
            'basePrice' => 10,
            'openTime' => 8,
            'closeTime' => 21,
        ], $token);
    }
}