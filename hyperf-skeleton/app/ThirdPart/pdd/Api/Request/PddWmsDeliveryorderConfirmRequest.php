<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsDeliveryorderConfirmRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsDeliveryorderConfirmRequest_Request, "request")
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
		return "pdd.wms.deliveryorder.confirm";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsDeliveryorderConfirmRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "deliveryOrderCode")
	*/
	private $deliveryOrderCode;

	/**
	* @JsonProperty(String, "expressCode")
	*/
	private $expressCode;

	/**
	* @JsonProperty(String, "logisticsCode")
	*/
	private $logisticsCode;

	/**
	* @JsonProperty(String, "logisticsName")
	*/
	private $logisticsName;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsDeliveryorderConfirmRequest_RequestOrderLinesItem>, "orderLines")
	*/
	private $orderLines;

	/**
	* @JsonProperty(String, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "outBizCode")
	*/
	private $outBizCode;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(String, "status")
	*/
	private $status;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	public function setDeliveryOrderCode($deliveryOrderCode)
	{
		$this->deliveryOrderCode = $deliveryOrderCode;
	}

	public function setExpressCode($expressCode)
	{
		$this->expressCode = $expressCode;
	}

	public function setLogisticsCode($logisticsCode)
	{
		$this->logisticsCode = $logisticsCode;
	}

	public function setLogisticsName($logisticsName)
	{
		$this->logisticsName = $logisticsName;
	}

	public function setOrderLines($orderLines)
	{
		$this->orderLines = $orderLines;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setOutBizCode($outBizCode)
	{
		$this->outBizCode = $outBizCode;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

}

class PddWmsDeliveryorderConfirmRequest_RequestOrderLinesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "inventoryType")
	*/
	private $inventoryType;

	/**
	* @JsonProperty(String, "parentWareSn")
	*/
	private $parentWareSn;

	/**
	* @JsonProperty(String, "quantity")
	*/
	private $quantity;

	/**
	* @JsonProperty(String, "wareSn")
	*/
	private $wareSn;

	public function setInventoryType($inventoryType)
	{
		$this->inventoryType = $inventoryType;
	}

	public function setParentWareSn($parentWareSn)
	{
		$this->parentWareSn = $parentWareSn;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

}
