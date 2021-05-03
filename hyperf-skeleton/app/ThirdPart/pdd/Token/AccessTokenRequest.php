<?php
namespace Com\Pdd\Pop\Sdk\Token;

use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

/**
 * AccessToken request类
 */

class AccessTokenRequest extends PopBaseJsonEntity
{

    /**
     * @JsonProperty(String, "client_id")
     */
    private $clientId;

    /**
     * @JsonProperty(String, "client_secret")
     */
    private $clientSecret;

    /**
     * @JsonProperty(String, "grant_type")
     */
    private $grantType;

    /**
     * @JsonProperty(String, "code")
     */
    private $code;

    /**
     * @JsonProperty(String, "redirect_uri")
     */
    private $redirectUri = "http://www.baidu.com";


    public function __construct()
    {

    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    public function getGrantType()
    {
        return $this->grantType;
    }

    public function setGrantType($grantType)
    {
        $this->grantType = $grantType;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }
}
