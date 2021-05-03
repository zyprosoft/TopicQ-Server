<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTicketVerificationNotifycationRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "order_no")
	*/
	private $orderNo;

	/**
	* @JsonProperty(Long, "verify_time")
	*/
	private $verifyTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_no", $this->orderNo);
		$this->setUserParam($params, "verify_time", $this->verifyTime);

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
		return "pdd.ticket.verification.notifycation";
	}

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
	}

	public function setVerifyTime($verifyTime)
	{
		$this->verifyTime = $verifyTime;
	}

}
