<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiReportEntityReportQueryRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "endDateString")
	*/
	private $endDateString;

	/**
	* @JsonProperty(Integer, "entityDimensionType")
	*/
	private $entityDimensionType;

	/**
	* @JsonProperty(Long, "entityId")
	*/
	private $entityId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiReportEntityReportQueryRequest_tring, String>, "externalParamMap")
	*/
	private $externalParamMap;

	/**
	* @JsonProperty(Integer, "orderBy")
	*/
	private $orderBy;

	/**
	* @JsonProperty(Integer, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(Integer, "queryDimensionType")
	*/
	private $queryDimensionType;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiReportEntityReportQueryRequest_QueryRange, "queryRange")
	*/
	private $queryRange;

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
		$this->setUserParam($params, "entityDimensionType", $this->entityDimensionType);
		$this->setUserParam($params, "entityId", $this->entityId);
		$this->setUserParam($params, "externalParamMap", $this->externalParamMap);
		$this->setUserParam($params, "orderBy", $this->orderBy);
		$this->setUserParam($params, "orderType", $this->orderType);
		$this->setUserParam($params, "queryDimensionType", $this->queryDimensionType);
		$this->setUserParam($params, "queryRange", $this->queryRange);
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
		return "pdd.ad.api.report.entity.report.query";
	}

	public function setEndDateString($endDateString)
	{
		$this->endDateString = $endDateString;
	}

	public function setEntityDimensionType($entityDimensionType)
	{
		$this->entityDimensionType = $entityDimensionType;
	}

	public function setEntityId($entityId)
	{
		$this->entityId = $entityId;
	}

	public function setExternalParamMap($externalParamMap)
	{
		$this->externalParamMap = $externalParamMap;
	}

	public function setOrderBy($orderBy)
	{
		$this->orderBy = $orderBy;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setQueryDimensionType($queryDimensionType)
	{
		$this->queryDimensionType = $queryDimensionType;
	}

	public function setQueryRange($queryRange)
	{
		$this->queryRange = $queryRange;
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

class PddAdApiReportEntityReportQueryRequest_QueryRange extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "pageNumber")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "pageSize")
	*/
	private $pageSize;

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

}
