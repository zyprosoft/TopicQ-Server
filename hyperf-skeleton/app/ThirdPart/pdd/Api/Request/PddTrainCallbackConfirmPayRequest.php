<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCallbackConfirmPayRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "crh_order_id")
	*/
	private $crhOrderId;

	/**
	* @JsonProperty(String, "gate_no")
	*/
	private $gateNo;

	/**
	* @JsonProperty(String, "msg")
	*/
	private $msg;

	/**
	* @JsonProperty(String, "order_id")
	*/
	private $orderId;

	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

	/**
	* @JsonProperty(String, "request_id")
	*/
	private $requestId;

	/**
	* @JsonProperty(String, "vendor_time")
	*/
	private $vendorTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "code", $this->code);
		$this->setUserParam($params, "crh_order_id", $this->crhOrderId);
		$this->setUserParam($params, "gate_no", $this->gateNo);
		$this->setUserParam($params, "msg", $this->msg);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "request_id", $this->requestId);
		$this->setUserParam($params, "vendor_time", $this->vendorTime);

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
		return "pdd.train.callback.confirm.pay";
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setCrhOrderId($crhOrderId)
	{
		$this->crhOrderId = $crhOrderId;
	}

	public function setGateNo($gateNo)
	{
		$this->gateNo = $gateNo;
	}

	public function setMsg($msg)
	{
		$this->msg = $msg;
	}

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setRequestId($requestId)
	{
		$this->requestId = $requestId;
	}

	public function setVendorTime($vendorTime)
	{
		$this->vendorTime = $vendorTime;
	}

}
