<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOrderUpdateAddressRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "address")
	*/
	private $address;

	/**
	* @JsonProperty(String, "city")
	*/
	private $city;

	/**
	* @JsonProperty(Integer, "city_id")
	*/
	private $cityId;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "province")
	*/
	private $province;

	/**
	* @JsonProperty(Integer, "province_id")
	*/
	private $provinceId;

	/**
	* @JsonProperty(String, "receiver_name")
	*/
	private $receiverName;

	/**
	* @JsonProperty(String, "receiver_phone")
	*/
	private $receiverPhone;

	/**
	* @JsonProperty(String, "town")
	*/
	private $town;

	/**
	* @JsonProperty(Integer, "town_id")
	*/
	private $townId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "address", $this->address);
		$this->setUserParam($params, "city", $this->city);
		$this->setUserParam($params, "city_id", $this->cityId);
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "province", $this->province);
		$this->setUserParam($params, "province_id", $this->provinceId);
		$this->setUserParam($params, "receiver_name", $this->receiverName);
		$this->setUserParam($params, "receiver_phone", $this->receiverPhone);
		$this->setUserParam($params, "town", $this->town);
		$this->setUserParam($params, "town_id", $this->townId);

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
		return "pdd.order.update.address";
	}

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setProvince($province)
	{
		$this->province = $province;
	}

	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
	}

	public function setReceiverName($receiverName)
	{
		$this->receiverName = $receiverName;
	}

	public function setReceiverPhone($receiverPhone)
	{
		$this->receiverPhone = $receiverPhone;
	}

	public function setTown($town)
	{
		$this->town = $town;
	}

	public function setTownId($townId)
	{
		$this->townId = $townId;
	}

}
