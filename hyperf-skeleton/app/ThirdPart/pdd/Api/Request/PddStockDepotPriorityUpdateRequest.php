<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddStockDepotPriorityUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddStockDepotPriorityUpdateRequest_PriorityListItem>, "priority_list")
	*/
	private $priorityList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "priority_list", $this->priorityList);

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
		return "pdd.stock.depot.priority.update";
	}

	public function setPriorityList($priorityList)
	{
		$this->priorityList = $priorityList;
	}

}

class PddStockDepotPriorityUpdateRequest_PriorityListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "priority")
	*/
	private $priority;

	/**
	* @JsonProperty(Integer, "district_id")
	*/
	private $districtId;

	/**
	* @JsonProperty(Integer, "city_id")
	*/
	private $cityId;

	/**
	* @JsonProperty(Integer, "province_id")
	*/
	private $provinceId;

	/**
	* @JsonProperty(Long, "depot_id")
	*/
	private $depotId;

	public function setPriority($priority)
	{
		$this->priority = $priority;
	}

	public function setDistrictId($districtId)
	{
		$this->districtId = $districtId;
	}

	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
	}

	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
	}

	public function setDepotId($depotId)
	{
		$this->depotId = $depotId;
	}

}
