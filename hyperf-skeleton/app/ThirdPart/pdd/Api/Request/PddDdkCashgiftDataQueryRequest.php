<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkCashgiftDataQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "cash_gift_id")
	*/
	private $cashGiftId;

	/**
	* @JsonProperty(Long, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Long, "start_time")
	*/
	private $startTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cash_gift_id", $this->cashGiftId);
		$this->setUserParam($params, "end_time", $this->endTime);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
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
		return "pdd.ddk.cashgift.data.query";
	}

	public function setCashGiftId($cashGiftId)
	{
		$this->cashGiftId = $cashGiftId;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

}
