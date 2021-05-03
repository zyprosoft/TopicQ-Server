<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddLogisticsCsSessionStartRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "session_id")
	*/
	private $sessionId;

	/**
	* @JsonProperty(String, "wp_session_id")
	*/
	private $wpSessionId;

	/**
	* @JsonProperty(String, "action_time")
	*/
	private $actionTime;

	/**
	* @JsonProperty(Integer, "biz_type")
	*/
	private $bizType;

	/**
	* @JsonProperty(String, "dealer_id")
	*/
	private $dealerId;

	/**
	* @JsonProperty(String, "queue_id")
	*/
	private $queueId;

	/**
	* @JsonProperty(String, "queue_name")
	*/
	private $queueName;

	/**
	* @JsonProperty(Integer, "queue_index")
	*/
	private $queueIndex;

	/**
	* @JsonProperty(Integer, "exception_code")
	*/
	private $exceptionCode;

	/**
	* @JsonProperty(String, "exception_msg")
	*/
	private $exceptionMsg;

	/**
	* @JsonProperty(String, "queue_address")
	*/
	private $queueAddress;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "session_id", $this->sessionId);
		$this->setUserParam($params, "wp_session_id", $this->wpSessionId);
		$this->setUserParam($params, "action_time", $this->actionTime);
		$this->setUserParam($params, "biz_type", $this->bizType);
		$this->setUserParam($params, "dealer_id", $this->dealerId);
		$this->setUserParam($params, "queue_id", $this->queueId);
		$this->setUserParam($params, "queue_name", $this->queueName);
		$this->setUserParam($params, "queue_index", $this->queueIndex);
		$this->setUserParam($params, "exception_code", $this->exceptionCode);
		$this->setUserParam($params, "exception_msg", $this->exceptionMsg);
		$this->setUserParam($params, "queue_address", $this->queueAddress);

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
		return "pdd.logistics.cs.session.start";
	}

	public function setSessionId($sessionId)
	{
		$this->sessionId = $sessionId;
	}

	public function setWpSessionId($wpSessionId)
	{
		$this->wpSessionId = $wpSessionId;
	}

	public function setActionTime($actionTime)
	{
		$this->actionTime = $actionTime;
	}

	public function setBizType($bizType)
	{
		$this->bizType = $bizType;
	}

	public function setDealerId($dealerId)
	{
		$this->dealerId = $dealerId;
	}

	public function setQueueId($queueId)
	{
		$this->queueId = $queueId;
	}

	public function setQueueName($queueName)
	{
		$this->queueName = $queueName;
	}

	public function setQueueIndex($queueIndex)
	{
		$this->queueIndex = $queueIndex;
	}

	public function setExceptionCode($exceptionCode)
	{
		$this->exceptionCode = $exceptionCode;
	}

	public function setExceptionMsg($exceptionMsg)
	{
		$this->exceptionMsg = $exceptionMsg;
	}

	public function setQueueAddress($queueAddress)
	{
		$this->queueAddress = $queueAddress;
	}

}
