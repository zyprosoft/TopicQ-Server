<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanQueryListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "beginDate")
	*/
	private $beginDate;

	/**
	* @JsonProperty(String, "endDate")
	*/
	private $endDate;

	/**
	* @JsonProperty(Integer, "orderBy")
	*/
	private $orderBy;

	/**
	* @JsonProperty(Integer, "scenesType")
	*/
	private $scenesType;

	/**
	* @JsonProperty(Integer, "sortBy")
	*/
	private $sortBy;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "beginDate", $this->beginDate);
		$this->setUserParam($params, "endDate", $this->endDate);
		$this->setUserParam($params, "orderBy", $this->orderBy);
		$this->setUserParam($params, "scenesType", $this->scenesType);
		$this->setUserParam($params, "sortBy", $this->sortBy);

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
		return "pdd.ad.api.plan.query.list";
	}

	public function setBeginDate($beginDate)
	{
		$this->beginDate = $beginDate;
	}

	public function setEndDate($endDate)
	{
		$this->endDate = $endDate;
	}

	public function setOrderBy($orderBy)
	{
		$this->orderBy = $orderBy;
	}

	public function setScenesType($scenesType)
	{
		$this->scenesType = $scenesType;
	}

	public function setSortBy($sortBy)
	{
		$this->sortBy = $sortBy;
	}

}
