<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddLogisticsIsvTraceNotifySubRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "ship_code")
	*/
	private $shipCode;

	/**
	* @JsonProperty(String, "tel")
	*/
	private $tel;

	/**
	* @JsonProperty(String, "track_no")
	*/
	private $trackNo;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "ship_code", $this->shipCode);
		$this->setUserParam($params, "tel", $this->tel);
		$this->setUserParam($params, "track_no", $this->trackNo);

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
		return "pdd.logistics.isv.trace.notify.sub";
	}

	public function setShipCode($shipCode)
	{
		$this->shipCode = $shipCode;
	}

	public function setTel($tel)
	{
		$this->tel = $tel;
	}

	public function setTrackNo($trackNo)
	{
		$this->trackNo = $trackNo;
	}

}
