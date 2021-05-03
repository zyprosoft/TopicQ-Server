<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCallbackRefundConfirmRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "card_no")
	*/
	private $cardNo;

	/**
	* @JsonProperty(Integer, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "msg")
	*/
	private $msg;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

	/**
	* @JsonProperty(Long, "refund_money")
	*/
	private $refundMoney;

	/**
	* @JsonProperty(Integer, "refund_type")
	*/
	private $refundType;

	/**
	* @JsonProperty(String, "request_id")
	*/
	private $requestId;

	/**
	* @JsonProperty(String, "sub_order_id")
	*/
	private $subOrderId;

	/**
	* @JsonProperty(String, "sub_pdd_order_id")
	*/
	private $subPddOrderId;

	/**
	* @JsonProperty(String, "vendor_time")
	*/
	private $vendorTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "card_no", $this->cardNo);
		$this->setUserParam($params, "code", $this->code);
		$this->setUserParam($params, "msg", $this->msg);
		$this->setUserParam($params, "name", $this->name);
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "refund_money", $this->refundMoney);
		$this->setUserParam($params, "refund_type", $this->refundType);
		$this->setUserParam($params, "request_id", $this->requestId);
		$this->setUserParam($params, "sub_order_id", $this->subOrderId);
		$this->setUserParam($params, "sub_pdd_order_id", $this->subPddOrderId);
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
		return "pdd.train.callback.refund.confirm";
	}

	public function setCardNo($cardNo)
	{
		$this->cardNo = $cardNo;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setMsg($msg)
	{
		$this->msg = $msg;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setRefundMoney($refundMoney)
	{
		$this->refundMoney = $refundMoney;
	}

	public function setRefundType($refundType)
	{
		$this->refundType = $refundType;
	}

	public function setRequestId($requestId)
	{
		$this->requestId = $requestId;
	}

	public function setSubOrderId($subOrderId)
	{
		$this->subOrderId = $subOrderId;
	}

	public function setSubPddOrderId($subPddOrderId)
	{
		$this->subPddOrderId = $subPddOrderId;
	}

	public function setVendorTime($vendorTime)
	{
		$this->vendorTime = $vendorTime;
	}

}
