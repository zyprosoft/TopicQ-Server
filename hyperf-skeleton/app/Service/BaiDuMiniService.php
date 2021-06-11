<?php


namespace App\Service;

use App\Constants\Constants;
use GuzzleHttp\Client;
use Psr\Container\ContainerInterface;
use ZYProSoft\Log\Log;

class BaiDuMiniService extends BaseService
{
    protected string $clientId;

    protected string $secret;

    protected string $server = "https://spapi.baidu.com";

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->clientId = config('baidu.client_id');
        $this->secret = config('baidu.secret');
    }

    public function code2Session(string $code)
    {
        $config = [
            'base_uri' => $this->server,
            'method' => 'POST'
        ];
        $option = [
            'headers'=>['content-type'=>'application/x-www-form-urlencoded'],
            'form_params' => [
                'sk' => $this->secret,
                'client_id' => $this->clientId,
                'code' => $code
            ]
        ];
        $client = new Client($config);
        $path = '/oauth/jscode2sessionkey';
        Log::info($path);
        $response = $client->post($path,$option);
        Log::info("baidu request result:".$response->getBody());
        $status = $response->getStatusCode();
        if ($status !== 200) {
            return [
                'code' => Constants::STATUS_INVALIDATE,
                'msg' => '请求百度服务器失败'
            ];
        }
        $businessData = json_decode($response->getBody(),true);
        if (isset($businessData['errno'])) {
            return [
                'code' => $businessData['errno'],
                'msg' => $businessData['error'],
                'data' => []
            ];
        } else {
            return [
                'code' => 0,
                'msg' => 'ok',
                'data' => $businessData
            ];
        }

    }
}