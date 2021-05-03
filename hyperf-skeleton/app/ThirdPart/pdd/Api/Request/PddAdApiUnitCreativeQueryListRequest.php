<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreativeQueryListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

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
	* @JsonProperty(Integer, "sortBy")
	*/
	private $sortBy;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adId", $this->adId);
		$this->setUserParam($params, "beginDate", $this->beginDate);
		$this->setUserParam($params, "endDate", $this->endDate);
		$this->setUserParam($params, "orderBy", $this->orderBy);
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
		return "pdd.ad.api.unit.creative.query.list";
	}

	public function setAdId($adId)
	{
		$this->adId = $adId;
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

	public function setSortBy($sortBy)
	{
		$this->sortBy = $sortBy;
	}

}
