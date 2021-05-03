<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTicketScenicGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "city_code")
	*/
	private $cityCode;

	/**
	* @JsonProperty(Integer, "location_type")
	*/
	private $locationType;

	/**
	* @JsonProperty(Long, "scenic_id")
	*/
	private $scenicId;

	/**
	* @JsonProperty(String, "scenic_name")
	*/
	private $scenicName;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "city_code", $this->cityCode);
		$this->setUserParam($params, "location_type", $this->locationType);
		$this->setUserParam($params, "scenic_id", $this->scenicId);
		$this->setUserParam($params, "scenic_name", $this->scenicName);

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
		return "pdd.ticket.scenic.get";
	}

	public function setCityCode($cityCode)
	{
		$this->cityCode = $cityCode;
	}

	public function setLocationType($locationType)
	{
		$this->locationType = $locationType;
	}

	public function setScenicId($scenicId)
	{
		$this->scenicId = $scenicId;
	}

	public function setScenicName($scenicName)
	{
		$this->scenicName = $scenicName;
	}

}
