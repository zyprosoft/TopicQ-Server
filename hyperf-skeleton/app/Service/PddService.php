<?php


namespace App\Service;

use App\Constants\ErrorCode;
use Com\Pdd\Pop\Sdk\Api\Request\PddPopAuthTokenCreateRequest;
use Psr\Container\ContainerInterface;
use ZYProSoft\Exception\HyperfCommonException;
use ZYProSoft\Facade\Cache;
use ZYProSoft\Log\Log;
use ZYProSoft\Service\AbstractService;
use Com\Pdd\Pop\Sdk\PopAccessTokenClient;
use Com\Pdd\Pop\Sdk\PopHttpClient;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkGoodsPidGenerateRequest;
use Com\Pdd\Pop\Sdk\PopHttpException;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkRpPromUrlGenerateRequest;
use Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthMemberAuthorityQueryRequest;

class PddService extends AbstractService
{
    const PDD_ACCESS_TOKEN_CODE = 'lulingshuo';

    const PDD_ACCESS_TOKEN_CACHE_KEY = 'pdd:ac:tk';

    private string $clientId;

    private string $clientSecret;

    private string $authCode;

    private array $pidList;

    private string $accessToken;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->clientId = config('mall.pdd.client_id');
        $this->clientSecret = config('mall.pdd.client_secret');
        $this->pidList = [config('mall.pdd.pid')];
        $this->authCode = config('mall.pdd.auth_code');
        //缓存获取accessToken
//        $accessToken = Cache::get(self::PDD_ACCESS_TOKEN_CACHE_KEY);
//        if (!isset($accessToken)) {
//            $accessToken = $this->generateAccessToken();
//        }
        $this->accessToken = '';
    }

    public function notify()
    {

    }

    public function generateAccessToken()
    {
        $client = new PopHttpClient($this->clientId,$this->clientSecret);
        $request = new PddPopAuthTokenCreateRequest();
        $request->setCode(self::PDD_ACCESS_TOKEN_CODE);
        try {
            $response = $client->syncInvoke($request);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new HyperfCommonException($e->getCode(),$e->getMessage());
        }
        Log::info($response->getBody());
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            $errMsg = data_get($content,'error_response.error_msg');
            throw new HyperfCommonException(ErrorCode::CALL_PDD_ERROR,$errMsg);
        }
        $expiresIn = data_get($content,'expires_in');
        $expiresIn -= 60; //提前60秒过期
        $accessToken = data_get($content,'access_token');
        Cache::set(self::PDD_ACCESS_TOKEN_CACHE_KEY,$accessToken,$expiresIn);
        Log::info("获取拼多多Token成功!$accessToken;($expiresIn)秒后过期");
        return $accessToken;
    }

    public function generatePid()
    {
        $client = new PopHttpClient($this->clientId, $this->clientSecret);

        $request = new PddDdkGoodsPidGenerateRequest();

        $request->setNumber(1);
        $request->setPIdNameList($this->pidList);
        try {
            $response = $client->syncInvoke($request, $this->accessToken);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new HyperfCommonException($e->getCode(),$e->getMessage());
        }
        Log::info($response->getBody());
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            $errMsg = data_get($content,'error_response.error_msg');
            throw new HyperfCommonException(ErrorCode::CALL_PDD_ERROR,$errMsg);
        }
        return $content;
    }

    public function generatePidAuthUrl()
    {
        $client = new PopHttpClient($this->clientId, $this->clientSecret);

        $request = new PddDdkRpPromUrlGenerateRequest();

        $request->setChannelType(10);
        $request->setGenerateWeApp(true);
        $request->setPIdList($this->pidList);
        try{
            $response = $client->syncInvoke($request);
        } catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new HyperfCommonException($e->getCode(),$e->getMessage());
        }
        Log::info($response->getBody());
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            $errMsg = data_get($content,'error_response.error_msg');
            throw new HyperfCommonException(ErrorCode::CALL_PDD_ERROR,$errMsg);
        }
        Log::info($response->getBody());
        return data_get($content,'rp_promotion_url_generate_response');
    }

    public function queryPidAuthStatus()
    {
        $client = new PopHttpClient($this->clientId, $this->clientSecret);

        $request = new PddDdkOauthMemberAuthorityQueryRequest();

        $request->setPid($this->pidList[0]);
        try{
            $response = $client->syncInvoke($request);
        } catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new HyperfCommonException($e->getCode(),$e->getMessage());
        }
        Log::info($response->getBody());
        $content = $response->getContent();
        if (isset($content['error_response'])) {
            $errMsg = data_get($content,'error_response.error_msg');
            throw new HyperfCommonException(ErrorCode::CALL_PDD_ERROR,$errMsg);
        }
        Log::info($response->getBody());
        return $content;
    }
}