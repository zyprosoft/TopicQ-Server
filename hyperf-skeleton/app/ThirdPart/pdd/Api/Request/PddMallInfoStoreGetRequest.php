<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddMallInfoStoreGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "city")
	*/
	private $city;

	/**
	* @JsonProperty(String, "district")
	*/
	private $district;

	/**
	* @JsonProperty(Integer, "page_number")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(String, "province")
	*/
	private $province;

	/**
	* @JsonProperty(Long, "store_id")
	*/
	private $storeId;

	/**
	* @JsonProperty(String, "store_name")
	*/
	private $storeName;

	/**
	* @JsonProperty(String, "store_number")
	*/
	private $storeNumber;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "city", $this->city);
		$this->setUserParam($params, "district", $this->district);
		$this->setUserParam($params, "page_number", $this->pageNumber);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "province", $this->province);
		$this->setUserParam($params, "store_id", $this->storeId);
		$this->setUserParam($params, "store_name", $this->storeName);
		$this->setUserParam($params, "store_number", $this->storeNumber);

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
		return "pdd.mall.info.store.get";
	}

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function setDistrict($district)
	{
		$this->district = $district;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setProvince($province)
	{
		$this->province = $province;
	}

	public function setStoreId($storeId)
	{
		$this->storeId = $storeId;
	}

	public function setStoreName($storeName)
	{
		$this->storeName = $storeName;
	}

	public function setStoreNumber($storeNumber)
	{
		$this->storeNumber = $storeNumber;
	}

}
