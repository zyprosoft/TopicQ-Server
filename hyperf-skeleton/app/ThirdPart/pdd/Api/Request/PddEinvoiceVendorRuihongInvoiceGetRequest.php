<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddEinvoiceVendorRuihongInvoiceGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongInvoiceGetRequest_Request, "request")
	*/
	private $request;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "request", $this->request);

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
		return "pdd.einvoice.vendor.ruihong.invoice.get";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddEinvoiceVendorRuihongInvoiceGetRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "serialNo")
	*/
	private $serialNo;

	/**
	* @JsonProperty(String, "postTime")
	*/
	private $postTime;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongInvoiceGetRequest_RequestCriteriaItem>, "criteria")
	*/
	private $criteria;

	/**
	* @JsonProperty(String, "cmdName")
	*/
	private $cmdName;

	/**
	* @JsonProperty(String, "appCode")
	*/
	private $appCode;

	/**
	* @JsonProperty(String, "sign")
	*/
	private $sign;

	public function setSerialNo($serialNo)
	{
		$this->serialNo = $serialNo;
	}

	public function setPostTime($postTime)
	{
		$this->postTime = $postTime;
	}

	public function setCriteria($criteria)
	{
		$this->criteria = $criteria;
	}

	public function setCmdName($cmdName)
	{
		$this->cmdName = $cmdName;
	}

	public function setAppCode($appCode)
	{
		$this->appCode = $appCode;
	}

	public function setSign($sign)
	{
		$this->sign = $sign;
	}

}

class PddEinvoiceVendorRuihongInvoiceGetRequest_RequestCriteriaItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "value")
	*/
	private $value;

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

}
