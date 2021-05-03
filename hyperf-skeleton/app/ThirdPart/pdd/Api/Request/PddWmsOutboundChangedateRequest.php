<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsOutboundChangedateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOutboundChangedateRequest_Request, "request")
	*/
	private $request;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "request", $this->request);

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
		return "pdd.wms.outbound.changedate";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsOutboundChangedateRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "deliveryOrderCode")
	*/
	private $deliveryOrderCode;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	/**
	* @JsonProperty(String, "scheduleStart")
	*/
	private $scheduleStart;

	/**
	* @JsonProperty(String, "scheduleEnd")
	*/
	private $scheduleEnd;

	public function setDeliveryOrderCode($deliveryOrderCode)
	{
		$this->deliveryOrderCode = $deliveryOrderCode;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

	public function setScheduleStart($scheduleStart)
	{
		$this->scheduleStart = $scheduleStart;
	}

	public function setScheduleEnd($scheduleEnd)
	{
		$this->scheduleEnd = $scheduleEnd;
	}

}
