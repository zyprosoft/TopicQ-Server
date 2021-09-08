<?php


namespace App\Service;
use App\Constants\Constants;
use App\Job\QueryOfficialAccountUserInfoJob;
use App\Model\OfficialAccountUser;
use App\Model\User;
use Hyperf\DbConnection\Db;
use Psr\Container\ContainerInterface;
use ZYProSoft\Facade\Auth;
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
                        $event = $message['Event'];
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
        //获取token
        $this->officialAccount->access_token->getToken();
    }

    public function dealSubscribeEvent(string $openId, int $isSubscribe)
    {
        $user = User::query()->where('wx_fa_open_id',$openId)->first();
        $officialUser = OfficialAccountUser::query()->where('open_id',$openId)->first();
        if($isSubscribe == Constants::STATUS_NOT) {
            if (!$user instanceof User && !$officialUser instanceof OfficialAccountUser) {
                return;
            }
            if($user instanceof User) {
                $user->wx_fa_is_subscribe = $isSubscribe;
                $user->save();
                if(!isset($user->wx_union_id)) {
                    $this->push(new QueryOfficialAccountUserInfoJob($openId));
                }
            }
            if($officialUser instanceof OfficialAccountUser) {
                $officialUser->is_subscribe = $isSubscribe;
                $officialUser->save();
                if(!isset($officialUser->union_id)) {
                    $this->push(new QueryOfficialAccountUserInfoJob($openId));
                }
            }
            return;
        }
        if (!$user instanceof User) {
            //创建公众号用户
            if (!$officialUser instanceof OfficialAccountUser) {
                $officialUser = new OfficialAccountUser();
            }else{
                if (isset($officialUser->union_id)){
                    $user = User::query()->where('wx_union_id',$officialUser->union_id)->first();
                }
            }
            $officialUser->open_id = $openId;
            $officialUser->is_subscribe = $isSubscribe;
            $officialUser->save();
            //保存公众号信息到用户
            if ($user instanceof User) {
                $user->wx_fa_open_id = $openId;
                $user->wx_fa_is_subscribe = $isSubscribe;
                $user->save();
            }
            if(!isset($officialUser->union_id)) {
                $this->push(new QueryOfficialAccountUserInfoJob($openId));
            }
        }else{
            $user->wx_fa_open_id = $openId;
            $user->wx_fa_is_subscribe = $isSubscribe;
            $user->save();
            if(!isset($user->wx_union_id)) {
                $this->push(new QueryOfficialAccountUserInfoJob($openId));
            }
        }
    }

    public function getUserAttentionOfficialAccountStatus()
    {
        if(Auth::isGuest() == false) {
            $user = $this->user();
            if(!$user instanceof User) {
                return Constants::STATUS_NOT;
            }
            if(!isset($user->wx_union_id)) {
                Log::info('查询用户没有微信UnionID,无需检查状态');
                return Constants::STATUS_NOT;
            }
            return $user->wx_fa_is_subscribe;
        }
        return Constants::STATUS_NOT;
    }

    public function queryUserInfo($openId)
    {
        $result = $this->officialAccount->user->get($openId);
        Log::info("get user info:".json_encode($result));
        Db::transaction(function () use ($result,$openId) {
            //存储信息
            $user = User::query()->where('wx_fa_open_id',$openId)->lockForUpdate()->first();
            $officialUser = OfficialAccountUser::query()->where('open_id',$openId)->lockForUpdate()->first();
            if (!$user instanceof User && !$officialUser instanceof OfficialAccountUser) {
                Log::info("没有用户和公众号用户信息($openId)");
                return;
            }
            if(isset($user)) {
                $user->wx_union_id = $result['unionid'];
                $user->wx_fa_subscribe_time = $result['subscribe_time'];
                $user->wx_fa_subscribe_scene = $result['subscribe_scene'];
                $user->save();
            }
            if (isset($officialUser)) {
                $officialUser->union_id = $result['unionid'];
                $officialUser->attention_time = $result['subscribe_time'];
                $officialUser->attention_scene = $result['subscribe_scene'];
                $officialUser->save();
            }
        });
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