<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddMallInfoStoreUpdatePostNopoiRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "business_status")
	*/
	private $businessStatus;

	/**
	* @JsonProperty(List<Integer>, "business_week_list")
	*/
	private $businessWeekList;

	/**
	* @JsonProperty(String, "city")
	*/
	private $city;

	/**
	* @JsonProperty(String, "district")
	*/
	private $district;

	/**
	* @JsonProperty(String, "end_business_hour")
	*/
	private $endBusinessHour;

	/**
	* @JsonProperty(Double, "poi_latitude")
	*/
	private $poiLatitude;

	/**
	* @JsonProperty(Double, "poi_longitude")
	*/
	private $poiLongitude;

	/**
	* @JsonProperty(String, "province")
	*/
	private $province;

	/**
	* @JsonProperty(String, "start_business_hour")
	*/
	private $startBusinessHour;

	/**
	* @JsonProperty(String, "store_address")
	*/
	private $storeAddress;

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

	/**
	* @JsonProperty(String, "store_phone")
	*/
	private $storePhone;

	/**
	* @JsonProperty(Integer, "trade_type")
	*/
	private $tradeType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "business_status", $this->businessStatus);
		$this->setUserParam($params, "business_week_list", $this->businessWeekList);
		$this->setUserParam($params, "city", $this->city);
		$this->setUserParam($params, "district", $this->district);
		$this->setUserParam($params, "end_business_hour", $this->endBusinessHour);
		$this->setUserParam($params, "poi_latitude", $this->poiLatitude);
		$this->setUserParam($params, "poi_longitude", $this->poiLongitude);
		$this->setUserParam($params, "province", $this->province);
		$this->setUserParam($params, "start_business_hour", $this->startBusinessHour);
		$this->setUserParam($params, "store_address", $this->storeAddress);
		$this->setUserParam($params, "store_id", $this->storeId);
		$this->setUserParam($params, "store_name", $this->storeName);
		$this->setUserParam($params, "store_number", $this->storeNumber);
		$this->setUserParam($params, "store_phone", $this->storePhone);
		$this->setUserParam($params, "trade_type", $this->tradeType);

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
		return "pdd.mall.info.store.update.post.nopoi";
	}

	public function setBusinessStatus($businessStatus)
	{
		$this->businessStatus = $businessStatus;
	}

	public function setBusinessWeekList($businessWeekList)
	{
		$this->businessWeekList = $businessWeekList;
	}

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function setDistrict($district)
	{
		$this->district = $district;
	}

	public function setEndBusinessHour($endBusinessHour)
	{
		$this->endBusinessHour = $endBusinessHour;
	}

	public function setPoiLatitude($poiLatitude)
	{
		$this->poiLatitude = $poiLatitude;
	}

	public function setPoiLongitude($poiLongitude)
	{
		$this->poiLongitude = $poiLongitude;
	}

	public function setProvince($province)
	{
		$this->province = $province;
	}

	public function setStartBusinessHour($startBusinessHour)
	{
		$this->startBusinessHour = $startBusinessHour;
	}

	public function setStoreAddress($storeAddress)
	{
		$this->storeAddress = $storeAddress;
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

	public function setStorePhone($storePhone)
	{
		$this->storePhone = $storePhone;
	}

	public function setTradeType($tradeType)
	{
		$this->tradeType = $tradeType;
	}

}
