<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddEinvoiceMallRegisterResultRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceMallRegisterResultRequest_Data, "data")
	*/
	private $data;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "data", $this->data);

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
		return "pdd.einvoice.mall.register.result";
	}

	public function setData($data)
	{
		$this->data = $data;
	}

}

class PddEinvoiceMallRegisterResultRequest_Data extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "einvoiceApiVersion")
	*/
	private $einvoiceApiVersion;

	/**
	* @JsonProperty(String, "eventSerialNo")
	*/
	private $eventSerialNo;

	/**
	* @JsonProperty(String, "mallId")
	*/
	private $mallId;

	/**
	* @JsonProperty(String, "refuseReason")
	*/
	private $refuseReason;

	/**
	* @JsonProperty(String, "registerId")
	*/
	private $registerId;

	/**
	* @JsonProperty(Integer, "registerStatus")
	*/
	private $registerStatus;

	/**
	* @JsonProperty(String, "taxNo")
	*/
	private $taxNo;

	public function setEinvoiceApiVersion($einvoiceApiVersion)
	{
		$this->einvoiceApiVersion = $einvoiceApiVersion;
	}

	public function setEventSerialNo($eventSerialNo)
	{
		$this->eventSerialNo = $eventSerialNo;
	}

	public function setMallId($mallId)
	{
		$this->mallId = $mallId;
	}

	public function setRefuseReason($refuseReason)
	{
		$this->refuseReason = $refuseReason;
	}

	public function setRegisterId($registerId)
	{
		$this->registerId = $registerId;
	}

	public function setRegisterStatus($registerStatus)
	{
		$this->registerStatus = $registerStatus;
	}

	public function setTaxNo($taxNo)
	{
		$this->taxNo = $taxNo;
	}

}
