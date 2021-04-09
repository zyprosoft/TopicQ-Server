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
    }
}