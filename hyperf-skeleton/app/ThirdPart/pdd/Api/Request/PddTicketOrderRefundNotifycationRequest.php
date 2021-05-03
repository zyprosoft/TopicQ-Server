<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTicketOrderRefundNotifycationRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "order_no")
	*/
	private $orderNo;

	/**
	* @JsonProperty(Long, "refund_amount")
	*/
	private $refundAmount;

	/**
	* @JsonProperty(String, "reject_reason")
	*/
	private $rejectReason;

	/**
	* @JsonProperty(String, "serial_no")
	*/
	private $serialNo;

	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_no", $this->orderNo);
		$this->setUserParam($params, "refund_amount", $this->refundAmount);
		$this->setUserParam($params, "reject_reason", $this->rejectReason);
		$this->setUserParam($params, "serial_no", $this->serialNo);
		$this->setUserParam($params, "status", $this->status);

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
		return "pdd.ticket.order.refund.notifycation";
	}

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
	}

	public function setRefundAmount($refundAmount)
	{
		$this->refundAmount = $refundAmount;
	}

	public function setRejectReason($rejectReason)
	{
		$this->rejectReason = $rejectReason;
	}

	public function setSerialNo($serialNo)
	{
		$this->serialNo = $serialNo;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

}
