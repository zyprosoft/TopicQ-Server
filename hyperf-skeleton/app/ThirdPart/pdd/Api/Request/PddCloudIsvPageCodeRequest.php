<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudIsvPageCodeRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<String>, "mallIdList")
	*/
	private $mallIdList;

	/**
	* @JsonProperty(String, "httpReferer")
	*/
	private $httpReferer;

	/**
	* @JsonProperty(String, "userId")
	*/
	private $userId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "mallIdList", $this->mallIdList);
		$this->setUserParam($params, "httpReferer", $this->httpReferer);
		$this->setUserParam($params, "userId", $this->userId);

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
		return "pdd.cloud.isv.page.code";
	}

	public function setMallIdList($mallIdList)
	{
		$this->mallIdList = $mallIdList;
	}

	public function setHttpReferer($httpReferer)
	{
		$this->httpReferer = $httpReferer;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

}
