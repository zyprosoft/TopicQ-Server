<?php
namespace Com\Pdd\Pop\Sdk\Token;

use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

/**
 * RefreshAccessToken request类
 */

class RefreshAccessTokenRequest extends PopBaseJsonEntity
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
     * @JsonProperty(String, "refresh_token")
     */
    private $refreshToken;

    public function __construct()
    {

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

    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
    }
}