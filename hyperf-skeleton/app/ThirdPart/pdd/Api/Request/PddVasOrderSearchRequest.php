<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVasOrderSearchRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "create_time_end")
	*/
	private $createTimeEnd;

	/**
	* @JsonProperty(Long, "create_time_start")
	*/
	private $createTimeStart;

	/**
	* @JsonProperty(Long, "mall_id")
	*/
	private $mallId;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

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
	* @JsonProperty(Long, "pay_time_end")
	*/
	private $payTimeEnd;

	/**
	* @JsonProperty(Long, "pay_time_start")
	*/
	private $payTimeStart;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	/**
	* @JsonProperty(Integer, "refund_status")
	*/
	private $refundStatus;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "create_time_end", $this->createTimeEnd);
		$this->setUserParam($params, "create_time_start", $this->createTimeStart);
		$this->setUserParam($params, "mall_id", $this->mallId);
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "order_status", $this->orderStatus);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "pay_time_end", $this->payTimeEnd);
		$this->setUserParam($params, "pay_time_start", $this->payTimeStart);
		$this->setUserParam($params, "sku_id", $this->skuId);
		$this->setUserParam($params, "refund_status", $this->refundStatus);

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
		return "pdd.vas.order.search";
	}

	public function setCreateTimeEnd($createTimeEnd)
	{
		$this->createTimeEnd = $createTimeEnd;
	}

	public function setCreateTimeStart($createTimeStart)
	{
		$this->createTimeStart = $createTimeStart;
	}

	public function setMallId($mallId)
	{
		$this->mallId = $mallId;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
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

	public function setPayTimeEnd($payTimeEnd)
	{
		$this->payTimeEnd = $payTimeEnd;
	}

	public function setPayTimeStart($payTimeStart)
	{
		$this->payTimeStart = $payTimeStart;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

	public function setRefundStatus($refundStatus)
	{
		$this->refundStatus = $refundStatus;
	}

}
