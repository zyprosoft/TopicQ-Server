<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddLogisticsCsMessageSendRequest extends PopBaseHttpRequest
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
	* @JsonProperty(Integer, "message_type")
	*/
	private $messageType;

	/**
	* @JsonProperty(String, "text")
	*/
	private $text;

	/**
	* @JsonProperty(String, "attach")
	*/
	private $attach;

	/**
	* @JsonProperty(String, "preview")
	*/
	private $preview;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "session_id", $this->sessionId);
		$this->setUserParam($params, "wp_session_id", $this->wpSessionId);
		$this->setUserParam($params, "action_time", $this->actionTime);
		$this->setUserParam($params, "message_type", $this->messageType);
		$this->setUserParam($params, "text", $this->text);
		$this->setUserParam($params, "attach", $this->attach);
		$this->setUserParam($params, "preview", $this->preview);

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
		return "pdd.logistics.cs.message.send";
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

	public function setMessageType($messageType)
	{
		$this->messageType = $messageType;
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function setAttach($attach)
	{
		$this->attach = $attach;
	}

	public function setPreview($preview)
	{
		$this->preview = $preview;
	}

}
