<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddEinvoiceOutboundRuihongQueryTaxDiskStatusRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceOutboundRuihongQueryTaxDiskStatusRequest_Request, "request")
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
		return "pdd.einvoice.outbound.ruihong.query.tax.disk.status";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddEinvoiceOutboundRuihongQueryTaxDiskStatusRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "appCode")
	*/
	private $appCode;

	/**
	* @JsonProperty(String, "cmdName")
	*/
	private $cmdName;

	/**
	* @JsonProperty(String, "sign")
	*/
	private $sign;

	/**
	* @JsonProperty(String, "serialNo")
	*/
	private $serialNo;

	/**
	* @JsonProperty(String, "postTime")
	*/
	private $postTime;

	/**
	* @JsonProperty(String, "taxpayerCode")
	*/
	private $taxpayerCode;

	/**
	* @JsonProperty(String, "taxDiskNo")
	*/
	private $taxDiskNo;

	public function setAppCode($appCode)
	{
		$this->appCode = $appCode;
	}

	public function setCmdName($cmdName)
	{
		$this->cmdName = $cmdName;
	}

	public function setSign($sign)
	{
		$this->sign = $sign;
	}

	public function setSerialNo($serialNo)
	{
		$this->serialNo = $serialNo;
	}

	public function setPostTime($postTime)
	{
		$this->postTime = $postTime;
	}

	public function setTaxpayerCode($taxpayerCode)
	{
		$this->taxpayerCode = $taxpayerCode;
	}

	public function setTaxDiskNo($taxDiskNo)
	{
		$this->taxDiskNo = $taxDiskNo;
	}

}
