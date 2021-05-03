<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOpenVirtualNumberCheckRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "identify_number")
	*/
	private $identifyNumber;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "virtual_number")
	*/
	private $virtualNumber;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "identify_number", $this->identifyNumber);
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "virtual_number", $this->virtualNumber);

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
		return "pdd.open.virtual.number.check";
	}

	public function setIdentifyNumber($identifyNumber)
	{
		$this->identifyNumber = $identifyNumber;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setVirtualNumber($virtualNumber)
	{
		$this->virtualNumber = $virtualNumber;
	}

}
