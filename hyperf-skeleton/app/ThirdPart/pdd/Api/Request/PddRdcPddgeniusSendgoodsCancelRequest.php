<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddRdcPddgeniusSendgoodsCancelRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddRdcPddgeniusSendgoodsCancelRequest_Param, "param")
	*/
	private $param;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "param", $this->param);

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
		return "pdd.rdc.pddgenius.sendgoods.cancel";
	}

	public function setParam($param)
	{
		$this->param = $param;
	}

}

class PddRdcPddgeniusSendgoodsCancelRequest_Param extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "fail_reason_code")
	*/
	private $failReasonCode;

	/**
	* @JsonProperty(String, "msg")
	*/
	private $msg;

	/**
	* @JsonProperty(Long, "operate_time")
	*/
	private $operateTime;

	/**
	* @JsonProperty(Integer, "refund_fee")
	*/
	private $refundFee;

	/**
	* @JsonProperty(Long, "refund_id")
	*/
	private $refundId;

	/**
	* @JsonProperty(String, "status")
	*/
	private $status;

	/**
	* @JsonProperty(String, "tid")
	*/
	private $tid;

	public function setFailReasonCode($failReasonCode)
	{
		$this->failReasonCode = $failReasonCode;
	}

	public function setMsg($msg)
	{
		$this->msg = $msg;
	}

	public function setOperateTime($operateTime)
	{
		$this->operateTime = $operateTime;
	}

	public function setRefundFee($refundFee)
	{
		$this->refundFee = $refundFee;
	}

	public function setRefundId($refundId)
	{
		$this->refundId = $refundId;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setTid($tid)
	{
		$this->tid = $tid;
	}

}
