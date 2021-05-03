<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddServicemarketTradelistGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "begin_time")
	*/
	private $beginTime;

	/**
	* @JsonProperty(Integer, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(Integer, "group_type")
	*/
	private $groupType;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(String, "service_order_sn")
	*/
	private $serviceOrderSn;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "begin_time", $this->beginTime);
		$this->setUserParam($params, "end_time", $this->endTime);
		$this->setUserParam($params, "group_type", $this->groupType);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "service_order_sn", $this->serviceOrderSn);

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
		return "pdd.servicemarket.tradelist.get";
	}

	public function setBeginTime($beginTime)
	{
		$this->beginTime = $beginTime;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setGroupType($groupType)
	{
		$this->groupType = $groupType;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setServiceOrderSn($serviceOrderSn)
	{
		$this->serviceOrderSn = $serviceOrderSn;
	}

}
