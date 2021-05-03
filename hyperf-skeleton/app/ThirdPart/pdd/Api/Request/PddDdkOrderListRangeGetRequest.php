<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkOrderListRangeGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Boolean, "cash_gift_order")
	*/
	private $cashGiftOrder;

	/**
	* @JsonProperty(String, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(String, "last_order_id")
	*/
	private $lastOrderId;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "query_order_type")
	*/
	private $queryOrderType;

	/**
	* @JsonProperty(String, "start_time")
	*/
	private $startTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cash_gift_order", $this->cashGiftOrder);
		$this->setUserParam($params, "end_time", $this->endTime);
		$this->setUserParam($params, "last_order_id", $this->lastOrderId);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "query_order_type", $this->queryOrderType);
		$this->setUserParam($params, "start_time", $this->startTime);

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
		return "pdd.ddk.order.list.range.get";
	}

	public function setCashGiftOrder($cashGiftOrder)
	{
		$this->cashGiftOrder = $cashGiftOrder;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setLastOrderId($lastOrderId)
	{
		$this->lastOrderId = $lastOrderId;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setQueryOrderType($queryOrderType)
	{
		$this->queryOrderType = $queryOrderType;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

}
