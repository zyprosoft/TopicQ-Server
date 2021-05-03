<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudSecurityEventTrackingBatchOrderRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "eventType")
	*/
	private $eventType;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddCloudSecurityEventTrackingBatchOrderRequest_OrderEventsItem>, "orderEvents")
	*/
	private $orderEvents;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "eventType", $this->eventType);
		$this->setUserParam($params, "orderEvents", $this->orderEvents);

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
		return "pdd.cloud.security.event.tracking.batch.order";
	}

	public function setEventType($eventType)
	{
		$this->eventType = $eventType;
	}

	public function setOrderEvents($orderEvents)
	{
		$this->orderEvents = $orderEvents;
	}

}

class PddCloudSecurityEventTrackingBatchOrderRequest_OrderEventsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<Long>, "mallIdList")
	*/
	private $mallIdList;

	/**
	* @JsonProperty(String, "operation")
	*/
	private $operation;

	/**
	* @JsonProperty(List<String>, "orderList")
	*/
	private $orderList;

	/**
	* @JsonProperty(String, "pati")
	*/
	private $pati;

	/**
	* @JsonProperty(String, "sendTo")
	*/
	private $sendTo;

	/**
	* @JsonProperty(Long, "timestamp")
	*/
	private $timestamp;

	/**
	* @JsonProperty(String, "url")
	*/
	private $url;

	/**
	* @JsonProperty(String, "userId")
	*/
	private $userId;

	/**
	* @JsonProperty(String, "userIp")
	*/
	private $userIp;

	/**
	* @JsonProperty(List<Integer>, "sensitiveFieldEnumList")
	*/
	private $sensitiveFieldEnumList;

	/**
	* @JsonProperty(Boolean, "isEncrypt")
	*/
	private $isEncrypt;

	public function setMallIdList($mallIdList)
	{
		$this->mallIdList = $mallIdList;
	}

	public function setOperation($operation)
	{
		$this->operation = $operation;
	}

	public function setOrderList($orderList)
	{
		$this->orderList = $orderList;
	}

	public function setPati($pati)
	{
		$this->pati = $pati;
	}

	public function setSendTo($sendTo)
	{
		$this->sendTo = $sendTo;
	}

	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function setUserIp($userIp)
	{
		$this->userIp = $userIp;
	}

	public function setSensitiveFieldEnumList($sensitiveFieldEnumList)
	{
		$this->sensitiveFieldEnumList = $sensitiveFieldEnumList;
	}

	public function setIsEncrypt($isEncrypt)
	{
		$this->isEncrypt = $isEncrypt;
	}

}
