<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOrderBasicListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "end_confirm_at")
	*/
	private $endConfirmAt;

	/**
	* @JsonProperty(Integer, "order_status")
	*/
	private $orderStatus;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "refund_status")
	*/
	private $refundStatus;

	/**
	* @JsonProperty(Integer, "start_confirm_at")
	*/
	private $startConfirmAt;

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
		$this->setUserParam($params, "end_confirm_at", $this->endConfirmAt);
		$this->setUserParam($params, "order_status", $this->orderStatus);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "refund_status", $this->refundStatus);
		$this->setUserParam($params, "start_confirm_at", $this->startConfirmAt);
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
		return "pdd.order.basic.list.get";
	}

	public function setEndConfirmAt($endConfirmAt)
	{
		$this->endConfirmAt = $endConfirmAt;
	}

	public function setOrderStatus($orderStatus)
	{
		$this->orderStatus = $orderStatus;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setRefundStatus($refundStatus)
	{
		$this->refundStatus = $refundStatus;
	}

	public function setStartConfirmAt($startConfirmAt)
	{
		$this->startConfirmAt = $startConfirmAt;
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
