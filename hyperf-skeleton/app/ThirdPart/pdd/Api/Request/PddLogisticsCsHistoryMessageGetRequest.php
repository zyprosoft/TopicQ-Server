<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddLogisticsCsHistoryMessageGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "session_id")
	*/
	private $sessionId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "session_id", $this->sessionId);

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
		return "pdd.logistics.cs.history.message.get";
	}

	public function setSessionId($sessionId)
	{
		$this->sessionId = $sessionId;
	}

}
