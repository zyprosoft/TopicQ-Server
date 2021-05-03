<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionMerchantCouponListGetRequest extends PopBaseHttpRequest
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
	* @JsonProperty(Long, "batch_start_time_from")
	*/
	private $batchStartTimeFrom;

	/**
	* @JsonProperty(Long, "batch_start_time_to")
	*/
	private $batchStartTimeTo;

	/**
	* @JsonProperty(Integer, "batch_status")
	*/
	private $batchStatus;

	/**
	* @JsonProperty(Integer, "sort_by")
	*/
	private $sortBy;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "batch_start_time_from", $this->batchStartTimeFrom);
		$this->setUserParam($params, "batch_start_time_to", $this->batchStartTimeTo);
		$this->setUserParam($params, "batch_status", $this->batchStatus);
		$this->setUserParam($params, "sort_by", $this->sortBy);

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
		return "pdd.promotion.merchant.coupon.list.get";
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setBatchStartTimeFrom($batchStartTimeFrom)
	{
		$this->batchStartTimeFrom = $batchStartTimeFrom;
	}

	public function setBatchStartTimeTo($batchStartTimeTo)
	{
		$this->batchStartTimeTo = $batchStartTimeTo;
	}

	public function setBatchStatus($batchStatus)
	{
		$this->batchStatus = $batchStatus;
	}

	public function setSortBy($sortBy)
	{
		$this->sortBy = $sortBy;
	}

}
