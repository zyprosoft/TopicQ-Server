<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitQueryListRequest extends PopBaseHttpRequest
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
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

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
		$this->setUserParam($params, "planId", $this->planId);
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
		return "pdd.ad.api.unit.query.list";
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

	public function setPlanId($planId)
	{
		$this->planId = $planId;
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
