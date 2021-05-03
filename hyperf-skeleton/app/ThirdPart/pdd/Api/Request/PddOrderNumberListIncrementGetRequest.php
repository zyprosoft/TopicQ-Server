<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOrderNumberListIncrementGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "is_lucky_flag")
	*/
	private $isLuckyFlag;

	/**
	* @JsonProperty(Integer, "order_status")
	*/
	private $orderStatus;

	/**
	* @JsonProperty(Long, "start_updated_at")
	*/
	private $startUpdatedAt;

	/**
	* @JsonProperty(Long, "end_updated_at")
	*/
	private $endUpdatedAt;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "refund_status")
	*/
	private $refundStatus;

	/**
	* @JsonProperty(Integer, "trade_type")
	*/
	private $tradeType;

	/**
	* @JsonProperty(Boolean, "use_has_next")
	*/
	private $useHasNext;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "is_lucky_flag", $this->isLuckyFlag);
		$this->setUserParam($params, "order_status", $this->orderStatus);
		$this->setUserParam($params, "start_updated_at", $this->startUpdatedAt);
		$this->setUserParam($params, "end_updated_at", $this->endUpdatedAt);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "refund_status", $this->refundStatus);
		$this->setUserParam($params, "trade_type", $this->tradeType);
		$this->setUserParam($params, "use_has_next", $this->useHasNext);

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
		return "pdd.order.number.list.increment.get";
	}

	public function setIsLuckyFlag($isLuckyFlag)
	{
		$this->isLuckyFlag = $isLuckyFlag;
	}

	public function setOrderStatus($orderStatus)
	{
		$this->orderStatus = $orderStatus;
	}

	public function setStartUpdatedAt($startUpdatedAt)
	{
		$this->startUpdatedAt = $startUpdatedAt;
	}

	public function setEndUpdatedAt($endUpdatedAt)
	{
		$this->endUpdatedAt = $endUpdatedAt;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setRefundStatus($refundStatus)
	{
		$this->refundStatus = $refundStatus;
	}

	public function setTradeType($tradeType)
	{
		$this->tradeType = $tradeType;
	}

	public function setUseHasNext($useHasNext)
	{
		$this->useHasNext = $useHasNext;
	}

}
