<?php


namespace App\Component;
use EasyWeChat\Factory;
use Psr\Container\ContainerInterface;
use ZYProSoft\Component\BaseComponent;
use EasyWeChat\MiniProgram\Application;
use ZYProSoft\Log\Log;

class WeChatComponent extends BaseComponent
{
    protected array $options = [
        'base_uri' => 'https://api.weixin.qq.com'
    ];
    protected Application $app;

    protected string $accessToken;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $miniProgramConfig = config('weixin.miniProgram');
        $this->app = Factory::miniProgram($miniProgramConfig);
        $this->accessToken = $this->app->access_token->getToken()['access_token'];
    }

    public function checkText(string $text)
    {
        $params = [
            'access_token' => $this->accessToken,
            'content' => $text
        ];
        $path = '/wxa/msg_sec_check?access_token='.$this->accessToken;
        $response = $this->client->post($path,[
            'headers' => ['Content-Type:application/json'],
            'body' => json_encode($params,JSON_UNESCAPED_UNICODE)
        ]);
        Log::info("微信文本审核结果:".json_encode($response));
    }
}