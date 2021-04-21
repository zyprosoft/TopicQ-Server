<?php


namespace App\Component;
use EasyWeChat\Factory;
use Psr\Container\ContainerInterface;
use ZYProSoft\Component\BaseComponent;
use EasyWeChat\MiniProgram\Application;

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
        $response = $this->post($path,[
            'headers' => 'Content-Type:application/json',
            'json' => $params
        ]);
    }
}