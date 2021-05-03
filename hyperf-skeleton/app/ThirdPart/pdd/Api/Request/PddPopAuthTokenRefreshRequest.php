<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPopAuthTokenRefreshRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "refresh_token")
	*/
	private $refreshToken;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "refresh_token", $this->refreshToken);

	}

	public function getVersion()
	{
		return "V1";
	}

	public function getDataType()
	{
		return "JSON";
	}

	public function getType()
	{
		return "pdd.pop.auth.token.refresh";
	}

	public function setRefreshToken($refreshToken)
	{
		$this->refreshToken = $refreshToken;
	}

}
