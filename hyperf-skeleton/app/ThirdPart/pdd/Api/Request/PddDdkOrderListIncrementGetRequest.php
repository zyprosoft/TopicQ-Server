<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkOrderListIncrementGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Boolean, "cash_gift_order")
	*/
	private $cashGiftOrder;

	/**
	* @JsonProperty(Long, "end_update_time")
	*/
	private $endUpdateTime;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "query_order_type")
	*/
	private $queryOrderType;

	/**
	* @JsonProperty(Boolean, "return_count")
	*/
	private $returnCount;

	/**
	* @JsonProperty(Long, "start_update_time")
	*/
	private $startUpdateTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cash_gift_order", $this->cashGiftOrder);
		$this->setUserParam($params, "end_update_time", $this->endUpdateTime);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "query_order_type", $this->queryOrderType);
		$this->setUserParam($params, "return_count", $this->returnCount);
		$this->setUserParam($params, "start_update_time", $this->startUpdateTime);

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
		return "pdd.ddk.order.list.increment.get";
	}

	public function setCashGiftOrder($cashGiftOrder)
	{
		$this->cashGiftOrder = $cashGiftOrder;
	}

	public function setEndUpdateTime($endUpdateTime)
	{
		$this->endUpdateTime = $endUpdateTime;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setQueryOrderType($queryOrderType)
	{
		$this->queryOrderType = $queryOrderType;
	}

	public function setReturnCount($returnCount)
	{
		$this->returnCount = $returnCount;
	}

	public function setStartUpdateTime($startUpdateTime)
	{
		$this->startUpdateTime = $startUpdateTime;
	}

}
