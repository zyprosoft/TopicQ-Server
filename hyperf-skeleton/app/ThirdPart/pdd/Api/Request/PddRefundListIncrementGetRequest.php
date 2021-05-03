<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddRefundListIncrementGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "after_sales_status")
	*/
	private $afterSalesStatus;

	/**
	* @JsonProperty(Integer, "after_sales_type")
	*/
	private $afterSalesType;

	/**
	* @JsonProperty(Long, "end_updated_at")
	*/
	private $endUpdatedAt;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Long, "start_updated_at")
	*/
	private $startUpdatedAt;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "after_sales_status", $this->afterSalesStatus);
		$this->setUserParam($params, "after_sales_type", $this->afterSalesType);
		$this->setUserParam($params, "end_updated_at", $this->endUpdatedAt);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "start_updated_at", $this->startUpdatedAt);

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
		return "pdd.refund.list.increment.get";
	}

	public function setAfterSalesStatus($afterSalesStatus)
	{
		$this->afterSalesStatus = $afterSalesStatus;
	}

	public function setAfterSalesType($afterSalesType)
	{
		$this->afterSalesType = $afterSalesType;
	}

	public function setEndUpdatedAt($endUpdatedAt)
	{
		$this->endUpdatedAt = $endUpdatedAt;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setStartUpdatedAt($startUpdatedAt)
	{
		$this->startUpdatedAt = $startUpdatedAt;
	}

}
