<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiReportHourlyReportQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "dateString")
	*/
	private $dateString;

	/**
	* @JsonProperty(Long, "entityId")
	*/
	private $entityId;

	/**
	* @JsonProperty(Integer, "queryDimensionType")
	*/
	private $queryDimensionType;

	/**
	* @JsonProperty(Integer, "scenesType")
	*/
	private $scenesType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "dateString", $this->dateString);
		$this->setUserParam($params, "entityId", $this->entityId);
		$this->setUserParam($params, "queryDimensionType", $this->queryDimensionType);
		$this->setUserParam($params, "scenesType", $this->scenesType);

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
		return "pdd.ad.api.report.hourly.report.query";
	}

	public function setDateString($dateString)
	{
		$this->dateString = $dateString;
	}

	public function setEntityId($entityId)
	{
		$this->entityId = $entityId;
	}

	public function setQueryDimensionType($queryDimensionType)
	{
		$this->queryDimensionType = $queryDimensionType;
	}

	public function setScenesType($scenesType)
	{
		$this->scenesType = $scenesType;
	}

}
