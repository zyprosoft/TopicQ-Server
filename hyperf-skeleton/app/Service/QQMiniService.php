<?php


namespace App\Service;


use App\Constants\Constants;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use ZYProSoft\Log\Log;

class QQMiniService extends BaseService
{
    protected string $appId;

    protected string $secret;

    protected string $qqServer = "https://api.q.qq.com";

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->appId = config('qq.appid');
        $this->secret = config('qq.secret');
    }

    public function code2Session(string $code)
    {
        $config = [
            'base_uri' => $this->qqServer,
            'method' => 'GET'
        ];
        $option = [
            'data' => [
                'appid' => $this->appId,
                'secret' => $this->secret,
                'js_code' => $code,
                'grant_type' => 'authorization_code'
            ]
        ];
        $client = new Client($config);
        $response = $client->get('/sns/jscode2session', $option);
        Log::info("qq request result:".$response->getBody());
        $status = $response->getStatusCode();
        if ($status !== 200) {
            return [
                'code' => Constants::STATUS_INVALIDATE,
                'msg' => '请求QQ服务器失败'
            ];
        }
        $businessData = json_decode($response->getBody(),true);
        if ($businessData['errcode'] == 0) {
            return [
                'code' => 0,
                'msg' => 'ok',
                'data' => $businessData
            ];
        } else {
            return [
                'code' => $businessData['errcode'],
                'msg' => $businessData['errmsg'],
                'data' => []
            ];
        }

    }
}