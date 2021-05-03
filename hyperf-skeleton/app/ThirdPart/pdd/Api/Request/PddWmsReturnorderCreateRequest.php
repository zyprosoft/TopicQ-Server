<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsReturnorderCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsReturnorderCreateRequest_Request, "request")
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
		return "pdd.wms.returnorder.create";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsReturnorderCreateRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "deliveryOrderCode")
	*/
	private $deliveryOrderCode;

	/**
	* @JsonProperty(String, "orderFlag")
	*/
	private $orderFlag;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsReturnorderCreateRequest_RequestOrderLinesItem>, "orderLines")
	*/
	private $orderLines;

	/**
	* @JsonProperty(String, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(String, "returnOrderCode")
	*/
	private $returnOrderCode;

	/**
	* @JsonProperty(String, "returnReason")
	*/
	private $returnReason;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	public function setDeliveryOrderCode($deliveryOrderCode)
	{
		$this->deliveryOrderCode = $deliveryOrderCode;
	}

	public function setOrderFlag($orderFlag)
	{
		$this->orderFlag = $orderFlag;
	}

	public function setOrderLines($orderLines)
	{
		$this->orderLines = $orderLines;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setReturnOrderCode($returnOrderCode)
	{
		$this->returnOrderCode = $returnOrderCode;
	}

	public function setReturnReason($returnReason)
	{
		$this->returnReason = $returnReason;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

}

class PddWmsReturnorderCreateRequest_RequestOrderLinesItem extends PopBaseJsonEntity
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
