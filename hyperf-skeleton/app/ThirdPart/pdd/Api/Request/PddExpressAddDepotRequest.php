<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddExpressAddDepotRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "contact_name")
	*/
	private $contactName;

	/**
	* @JsonProperty(String, "depot_address")
	*/
	private $depotAddress;

	/**
	* @JsonProperty(String, "depot_alias")
	*/
	private $depotAlias;

	/**
	* @JsonProperty(Integer, "depot_city_id")
	*/
	private $depotCityId;

	/**
	* @JsonProperty(String, "depot_code")
	*/
	private $depotCode;

	/**
	* @JsonProperty(Integer, "depot_district_id")
	*/
	private $depotDistrictId;

	/**
	* @JsonProperty(String, "depot_name")
	*/
	private $depotName;

	/**
	* @JsonProperty(Integer, "depot_province_id")
	*/
	private $depotProvinceId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddExpressAddDepotRequest_tring, Map<String, List<String>>>, "depot_region")
	*/
	private $depotRegion;

	/**
	* @JsonProperty(String, "telephone")
	*/
	private $telephone;

	/**
	* @JsonProperty(String, "zip_code")
	*/
	private $zipCode;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "contact_name", $this->contactName);
		$this->setUserParam($params, "depot_address", $this->depotAddress);
		$this->setUserParam($params, "depot_alias", $this->depotAlias);
		$this->setUserParam($params, "depot_city_id", $this->depotCityId);
		$this->setUserParam($params, "depot_code", $this->depotCode);
		$this->setUserParam($params, "depot_district_id", $this->depotDistrictId);
		$this->setUserParam($params, "depot_name", $this->depotName);
		$this->setUserParam($params, "depot_province_id", $this->depotProvinceId);
		$this->setUserParam($params, "depot_region", $this->depotRegion);
		$this->setUserParam($params, "telephone", $this->telephone);
		$this->setUserParam($params, "zip_code", $this->zipCode);

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
		return "pdd.express.add.depot";
	}

	public function setContactName($contactName)
	{
		$this->contactName = $contactName;
	}

	public function setDepotAddress($depotAddress)
	{
		$this->depotAddress = $depotAddress;
	}

	public function setDepotAlias($depotAlias)
	{
		$this->depotAlias = $depotAlias;
	}

	public function setDepotCityId($depotCityId)
	{
		$this->depotCityId = $depotCityId;
	}

	public function setDepotCode($depotCode)
	{
		$this->depotCode = $depotCode;
	}

	public function setDepotDistrictId($depotDistrictId)
	{
		$this->depotDistrictId = $depotDistrictId;
	}

	public function setDepotName($depotName)
	{
		$this->depotName = $depotName;
	}

	public function setDepotProvinceId($depotProvinceId)
	{
		$this->depotProvinceId = $depotProvinceId;
	}

	public function setDepotRegion($depotRegion)
	{
		$this->depotRegion = $depotRegion;
	}

	public function setTelephone($telephone)
	{
		$this->telephone = $telephone;
	}

	public function setZipCode($zipCode)
	{
		$this->zipCode = $zipCode;
	}

}
