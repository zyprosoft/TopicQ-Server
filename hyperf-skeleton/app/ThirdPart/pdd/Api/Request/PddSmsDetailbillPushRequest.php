<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsDetailbillPushRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "account")
	*/
	private $account;

	/**
	* @JsonProperty(Long, "batch_version")
	*/
	private $batchVersion;

	/**
	* @JsonProperty(String, "date")
	*/
	private $date;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddSmsDetailbillPushRequest_DetailsItem>, "details")
	*/
	private $details;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "account", $this->account);
		$this->setUserParam($params, "batch_version", $this->batchVersion);
		$this->setUserParam($params, "date", $this->date);
		$this->setUserParam($params, "details", $this->details);

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
		return "pdd.sms.detailbill.push";
	}

	public function setAccount($account)
	{
		$this->account = $account;
	}

	public function setBatchVersion($batchVersion)
	{
		$this->batchVersion = $batchVersion;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function setDetails($details)
	{
		$this->details = $details;
	}

}

class PddSmsDetailbillPushRequest_DetailsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "deliver_time")
	*/
	private $deliverTime;

	/**
	* @JsonProperty(String, "error_code")
	*/
	private $errorCode;

	/**
	* @JsonProperty(Long, "msg_id")
	*/
	private $msgId;

	/**
	* @JsonProperty(String, "submit_time")
	*/
	private $submitTime;

	public function setDeliverTime($deliverTime)
	{
		$this->deliverTime = $deliverTime;
	}

	public function setErrorCode($errorCode)
	{
		$this->errorCode = $errorCode;
	}

	public function setMsgId($msgId)
	{
		$this->msgId = $msgId;
	}

	public function setSubmitTime($submitTime)
	{
		$this->submitTime = $submitTime;
	}

}
