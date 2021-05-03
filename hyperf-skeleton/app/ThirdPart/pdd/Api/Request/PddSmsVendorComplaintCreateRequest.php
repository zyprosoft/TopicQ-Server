<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddSmsVendorComplaintCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "account")
	*/
	private $account;

	/**
	* @JsonProperty(String, "complaint_time")
	*/
	private $complaintTime;

	/**
	* @JsonProperty(Integer, "count")
	*/
	private $count;

	/**
	* @JsonProperty(String, "deliver_time")
	*/
	private $deliverTime;

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "operator")
	*/
	private $operator;

	/**
	* @JsonProperty(String, "province")
	*/
	private $province;

	/**
	* @JsonProperty(String, "sms_content")
	*/
	private $smsContent;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "account", $this->account);
		$this->setUserParam($params, "complaint_time", $this->complaintTime);
		$this->setUserParam($params, "count", $this->count);
		$this->setUserParam($params, "deliver_time", $this->deliverTime);
		$this->setUserParam($params, "mobile", $this->mobile);
		$this->setUserParam($params, "operator", $this->operator);
		$this->setUserParam($params, "province", $this->province);
		$this->setUserParam($params, "sms_content", $this->smsContent);

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
		return "pdd.sms.vendor.complaint.create";
	}

	public function setAccount($account)
	{
		$this->account = $account;
	}

	public function setComplaintTime($complaintTime)
	{
		$this->complaintTime = $complaintTime;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function setDeliverTime($deliverTime)
	{
		$this->deliverTime = $deliverTime;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setOperator($operator)
	{
		$this->operator = $operator;
	}

	public function setProvince($province)
	{
		$this->province = $province;
	}

	public function setSmsContent($smsContent)
	{
		$this->smsContent = $smsContent;
	}

}
