<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOrderListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "order_status")
	*/
	private $orderStatus;

	/**
	* @JsonProperty(Integer, "refund_status")
	*/
	private $refundStatus;

	/**
	* @JsonProperty(Long, "start_confirm_at")
	*/
	private $startConfirmAt;

	/**
	* @JsonProperty(Long, "end_confirm_at")
	*/
	private $endConfirmAt;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

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
		$this->setUserParam($params, "order_status", $this->orderStatus);
		$this->setUserParam($params, "refund_status", $this->refundStatus);
		$this->setUserParam($params, "start_confirm_at", $this->startConfirmAt);
		$this->setUserParam($params, "end_confirm_at", $this->endConfirmAt);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
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
		return "pdd.order.list.get";
	}

	public function setOrderStatus($orderStatus)
	{
		$this->orderStatus = $orderStatus;
	}

	public function setRefundStatus($refundStatus)
	{
		$this->refundStatus = $refundStatus;
	}

	public function setStartConfirmAt($startConfirmAt)
	{
		$this->startConfirmAt = $startConfirmAt;
	}

	public function setEndConfirmAt($endConfirmAt)
	{
		$this->endConfirmAt = $endConfirmAt;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
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
