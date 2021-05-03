<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddEinvoiceQueryMallRegisterOrderRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceQueryMallRegisterOrderRequest_Data, "data")
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
		return "pdd.einvoice.query.mall.register.order";
	}

	public function setData($data)
	{
		$this->data = $data;
	}

}

class PddEinvoiceQueryMallRegisterOrderRequest_Data extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "pageSize")
	*/
	private $pageSize;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceQueryMallRegisterOrderRequest_DataRequest, "request")
	*/
	private $request;

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddEinvoiceQueryMallRegisterOrderRequest_DataRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "einvoiceApiVersion")
	*/
	private $einvoiceApiVersion;

	/**
	* @JsonProperty(Long, "endTime")
	*/
	private $endTime;

	/**
	* @JsonProperty(List<Integer>, "registerStatusList")
	*/
	private $registerStatusList;

	/**
	* @JsonProperty(Long, "startTime")
	*/
	private $startTime;

	public function setEinvoiceApiVersion($einvoiceApiVersion)
	{
		$this->einvoiceApiVersion = $einvoiceApiVersion;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setRegisterStatusList($registerStatusList)
	{
		$this->registerStatusList = $registerStatusList;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

}
