<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddServicemarketSettlementbillGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
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

	/**
	* @JsonProperty(String, "settle_month")
	*/
	private $settleMonth;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "service_order_sn", $this->serviceOrderSn);
		$this->setUserParam($params, "settle_month", $this->settleMonth);

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
		return "pdd.servicemarket.settlementbill.get";
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

	public function setSettleMonth($settleMonth)
	{
		$this->settleMonth = $settleMonth;
	}

}
