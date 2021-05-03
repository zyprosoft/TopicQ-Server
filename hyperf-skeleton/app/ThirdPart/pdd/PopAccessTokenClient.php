<?php
namespace Com\Pdd\Pop\Sdk;

use Com\Pdd\Pop\Sdk\Token\AccessTokenRequest;
use Com\Pdd\Pop\Sdk\Token\RefreshAccessTokenRequest;

/**
 * Pop接口调用的客户端类
 */
class PopAccessTokenClient
{
    /**
     * SDK版本号
     */
    public static $VERSION = "0.0.2";

    /**
     * 接口超时时间
     */
    private static $SECONDS = "30";

    private static $OAUTH_SERVER_URL = "https://open-api.pinduoduo.com/oauth/token";
    private $clientSecret;
    private $clientId;

    /**
     * 构造函数
     * @param $clientId 开放平台分配的clientId
     * @param $clientSecret 开放平台分配的clientSecret
     */
    public function  __construct($clientId, $clientSecret){
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * @param $code 授权获取到的code
     * @return  返回AccessTokenResponse对象
     */
    public function generate($code){
        if(empty($code)){
            throw new PopHttpException("Code不能为空");
        }
        $request = new AccessTokenRequest();
        $request->setClientId($this->clientId);
        $request->setClientSecret($this->clientSecret);
        $request->setCode($code);
        $request->setGrantType("authorization_code");

        $response = $this->postCurl($request);

        return $response;
    }

    /**
     * @param $refreshToken generate接口获取到的refresh_token，refresh_token有效期是30天
     * @return 返回刷新后的access_token
     */
    public function refresh($refreshToken){
        if(empty($refreshToken)){
            throw new PopHttpException("Refresh token 不能为空");
        }

        $request = new RefreshAccessTokenRequest();
        $request->setClientId($this->clientId);
        $request->setClientSecret($this->clientSecret);
        $request->setRefreshToken($refreshToken);
        $request->setGrantType("refresh_token");

        $response = $this->postCurl($request);

        return $response;
    }

    private function postCurl($request){
        $ch = curl_init();
        $curlVersion = curl_version();
        $ua = "PopSDK/".self::$VERSION." (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version']." "
            .$this->clientId;

        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, self::$SECONDS);

        curl_setopt($ch,CURLOPT_URL, self::$OAUTH_SERVER_URL);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);//严格校验
        curl_setopt($ch,CURLOPT_USERAGENT, $ua);
        //设置header
        $headers = array(
            "Content-type: application/json;charset='utf-8'",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Pdd-Sdk-Version: ".self::$VERSION,
            "Pdd-Sdk-Type: PHP"
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);

        $param = json_encode($request);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        //运行curl
        $raw_response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        //返回结果
        if($raw_response){
            curl_close($ch);

            $response = new PopHttpResponse();
            $response->setStatusCode($status_code);
            $response->setBody($raw_response);

            return $response;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new PopHttpException("curl出错，错误码:$error");
        }
    }

}