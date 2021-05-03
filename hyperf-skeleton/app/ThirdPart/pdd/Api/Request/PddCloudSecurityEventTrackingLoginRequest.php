<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudSecurityEventTrackingLoginRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "loginMessage")
	*/
	private $loginMessage;

	/**
	* @JsonProperty(Boolean, "loginResult")
	*/
	private $loginResult;

	/**
	* @JsonProperty(List<Long>, "mallIdList")
	*/
	private $mallIdList;

	/**
	* @JsonProperty(String, "pati")
	*/
	private $pati;

	/**
	* @JsonProperty(Long, "timestamp")
	*/
	private $timestamp;

	/**
	* @JsonProperty(String, "userId")
	*/
	private $userId;

	/**
	* @JsonProperty(String, "userIp")
	*/
	private $userIp;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "loginMessage", $this->loginMessage);
		$this->setUserParam($params, "loginResult", $this->loginResult);
		$this->setUserParam($params, "mallIdList", $this->mallIdList);
		$this->setUserParam($params, "pati", $this->pati);
		$this->setUserParam($params, "timestamp", $this->timestamp);
		$this->setUserParam($params, "userId", $this->userId);
		$this->setUserParam($params, "userIp", $this->userIp);

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
		return "pdd.cloud.security.event.tracking.login";
	}

	public function setLoginMessage($loginMessage)
	{
		$this->loginMessage = $loginMessage;
	}

	public function setLoginResult($loginResult)
	{
		$this->loginResult = $loginResult;
	}

	public function setMallIdList($mallIdList)
	{
		$this->mallIdList = $mallIdList;
	}

	public function setPati($pati)
	{
		$this->pati = $pati;
	}

	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function setUserIp($userIp)
	{
		$this->userIp = $userIp;
	}

}
