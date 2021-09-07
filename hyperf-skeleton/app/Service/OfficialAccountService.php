<?php


namespace App\Service;
use App\Model\User;
use phpDocumentor\Reflection\Types\Self_;
use Psr\Container\ContainerInterface;
use ZYProSoft\Facade\Auth;
use ZYProSoft\Log\Log;
use ZYProSoft\Service\AbstractService;
use EasyWeChat\Factory;
use EasyWeChat\OfficialAccount\Application as OfficialAccountApplication;
use Symfony\Component\HttpFoundation\Request;
use Hyperf\Guzzle\CoroutineHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

class OfficialAccountService extends AbstractService
{
    const WX_SUBSCRIBE_EVENT = 'subscribe';

    const WX_UNSUBSCRIBE_EVENT = 'unsubscribe';

    private $allConfig;

    /**
     * @var OfficialAccountApplication
     */
    private OfficialAccountApplication $officialAccount;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->allConfig = config("weixin");
        Log::info("all config:".json_encode($this->allConfig));
        $this->initSubService();
    }

    private function initSubService()
    {
        $this->officialAccount = Factory::officialAccount($this->allConfig["official_account"]);
        $handler = new CoroutineHandler();

        // 设置 HttpClient，部分接口直接使用了 http_client。
        $config = $this->officialAccount['config']->get('http', []);
        $config['handler'] = $stack = HandlerStack::create($handler);
        $this->officialAccount->rebind('http_client', new Client($config));

        // 部分接口在请求数据时，会根据 guzzle_handler 重置 Handler
        $this->officialAccount['guzzle_handler'] = $handler;

        // 如果使用的是 OfficialAccount，则还需要设置以下参数
        $this->officialAccount->oauth->setGuzzleOptions([
            'http_errors' => false,
            'handler' => $stack,
        ]);

        //处理微信消息
        $this->officialAccount->server->push(function ($message) {
            Log::info("微信消息:".json_encode($message));
            switch ($message['MsgType']) {
                case 'event':
                    {
                        $fromUserId = $message['FromUserName'];
                        $event = $message['event'];
                        if($event == self::WX_SUBSCRIBE_EVENT) {

                        }elseif ($event == self::WX_UNSUBSCRIBE_EVENT) {

                        }
                    }
                    break;
            }
            return "你好，欢迎关注庐陵说!";
        });
    }

    public function dealSubscribeEvent(string $openId, int $isSubscribe)
    {

    }

    public function queryUserInfo($openId)
    {
        $result = $this->officialAccount->access_token->getToken();
        Log::info("get token result:".json_encode($result));
        $result = $this->officialAccount->user->get($openId);
        Log::info("get user info:".json_encode($result));
        //存储信息
    }

    public function checkResponse(string $echostr)
    {
        return $echostr;
    }

    public function receiveMessage(Request $request)
    {
        $this->officialAccount->rebind("request", $request);
        return $this->officialAccount->server->serve();
    }
}