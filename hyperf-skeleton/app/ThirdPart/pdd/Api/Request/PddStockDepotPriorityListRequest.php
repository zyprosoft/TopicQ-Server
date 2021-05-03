<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddStockDepotPriorityListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "province_id")
	*/
	private $provinceId;

	/**
	* @JsonProperty(Integer, "city_id")
	*/
	private $cityId;

	/**
	* @JsonProperty(Integer, "district_id")
	*/
	private $districtId;

	/**
	* @JsonProperty(String, "depot_code")
	*/
	private $depotCode;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "page_num")
	*/
	private $pageNum;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "province_id", $this->provinceId);
		$this->setUserParam($params, "city_id", $this->cityId);
		$this->setUserParam($params, "district_id", $this->districtId);
		$this->setUserParam($params, "depot_code", $this->depotCode);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "page_num", $this->pageNum);

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
		return "pdd.stock.depot.priority.list";
	}

	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
	}

	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
	}

	public function setDistrictId($districtId)
	{
		$this->districtId = $districtId;
	}

	public function setDepotCode($depotCode)
	{
		$this->depotCode = $depotCode;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setPageNum($pageNum)
	{
		$this->pageNum = $pageNum;
	}

}
