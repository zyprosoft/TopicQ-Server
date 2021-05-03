<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiReportDailyReportQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "endDateString")
	*/
	private $endDateString;

	/**
	* @JsonProperty(Long, "entityId")
	*/
	private $entityId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiReportDailyReportQueryRequest_tring, String>, "externalParamMap")
	*/
	private $externalParamMap;

	/**
	* @JsonProperty(Integer, "queryDimensionType")
	*/
	private $queryDimensionType;

	/**
	* @JsonProperty(Integer, "scenesType")
	*/
	private $scenesType;

	/**
	* @JsonProperty(String, "startDateString")
	*/
	private $startDateString;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "endDateString", $this->endDateString);
		$this->setUserParam($params, "entityId", $this->entityId);
		$this->setUserParam($params, "externalParamMap", $this->externalParamMap);
		$this->setUserParam($params, "queryDimensionType", $this->queryDimensionType);
		$this->setUserParam($params, "scenesType", $this->scenesType);
		$this->setUserParam($params, "startDateString", $this->startDateString);

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
		return "pdd.ad.api.report.daily.report.query";
	}

	public function setEndDateString($endDateString)
	{
		$this->endDateString = $endDateString;
	}

	public function setEntityId($entityId)
	{
		$this->entityId = $entityId;
	}

	public function setExternalParamMap($externalParamMap)
	{
		$this->externalParamMap = $externalParamMap;
	}

	public function setQueryDimensionType($queryDimensionType)
	{
		$this->queryDimensionType = $queryDimensionType;
	}

	public function setScenesType($scenesType)
	{
		$this->scenesType = $scenesType;
	}

	public function setStartDateString($startDateString)
	{
		$this->startDateString = $startDateString;
	}

}
