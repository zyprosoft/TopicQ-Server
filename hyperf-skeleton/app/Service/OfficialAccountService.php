<?php


namespace App\Service;
use App\Constants\Constants;
use App\Job\QueryOfficialAccountUserInfoJob;
use App\Model\User;
use Psr\Container\ContainerInterface;
use ZYProSoft\Log\Log;
use EasyWeChat\Factory;
use EasyWeChat\OfficialAccount\Application as OfficialAccountApplication;
use Symfony\Component\HttpFoundation\Request;
use Hyperf\Guzzle\CoroutineHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

class OfficialAccountService extends BaseService
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
                            $this->dealSubscribeEvent($fromUserId,Constants::STATUS_OK);
                        }elseif ($event == self::WX_UNSUBSCRIBE_EVENT) {
                            $this->dealSubscribeEvent($fromUserId,Constants::STATUS_NOT);
                        }
                    }
                    break;
            }
            return "";
        });
    }

    public function dealSubscribeEvent(string $openId, int $isSubscribe)
    {
        if($isSubscribe == Constants::STATUS_NOT) {
            $user = User::query()->where('wx_fa_open_id',$openId)->first();
            if (!$user instanceof User) {
                return;
            }
            $user->wx_fa_is_subscribe = $isSubscribe;
            $user->save();
            return;
        }
        $user = User::query()->where('wx_fa_open_id',$openId)->first();
        if (!$user instanceof User) {
            $user = new User();
        }
        $user->wx_fa_open_id = $openId;
        $user->wx_fa_is_subscribe = $isSubscribe;
        $user->save();
        if(!isset($user->wx_union_id)) {
            $this->push(new QueryOfficialAccountUserInfoJob($openId));
        }
    }

    public function queryUserInfo($openId)
    {
        $result = $this->officialAccount->access_token->getToken();
        Log::info("get token result:".json_encode($result));
        $result = $this->officialAccount->user->get($openId);
        Log::info("get user info:".json_encode($result));
        //存储信息
        $user = User::query()->where('wx_fa_open_id',$openId)->first();
        if (!$user instanceof User) {
            return;
        }
        $user->wx_union_id = $result['unionid'];
        $user->wx_fa_subscribe_time = $result['subscribe_time'];
        $user->wx_fa_subscribe_scene = $result['subscribe_scene'];
        $user->save();
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