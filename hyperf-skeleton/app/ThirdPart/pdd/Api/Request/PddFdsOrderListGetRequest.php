<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFdsOrderListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFdsOrderListGetRequest_ParamFdsOrderListGetRequest, "param_fds_order_list_get_request")
	*/
	private $paramFdsOrderListGetRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "param_fds_order_list_get_request", $this->paramFdsOrderListGetRequest);

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
		return "pdd.fds.order.list.get";
	}

	public function setParamFdsOrderListGetRequest($paramFdsOrderListGetRequest)
	{
		$this->paramFdsOrderListGetRequest = $paramFdsOrderListGetRequest;
	}

}

class PddFdsOrderListGetRequest_ParamFdsOrderListGetRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "end_updated_time")
	*/
	private $endUpdatedTime;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Long, "start_updated_time")
	*/
	private $startUpdatedTime;

	public function setEndUpdatedTime($endUpdatedTime)
	{
		$this->endUpdatedTime = $endUpdatedTime;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setStartUpdatedTime($startUpdatedTime)
	{
		$this->startUpdatedTime = $startUpdatedTime;
	}

}
