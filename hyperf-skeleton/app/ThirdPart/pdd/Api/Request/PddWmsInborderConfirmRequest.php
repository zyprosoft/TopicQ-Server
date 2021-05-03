<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsInborderConfirmRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderConfirmRequest_Request, "request")
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
		return "pdd.wms.inborder.confirm";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsInborderConfirmRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderConfirmRequest_RequestInbOrder, "inbOrder")
	*/
	private $inbOrder;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderConfirmRequest_RequestOrderLinesItem>, "orderLines")
	*/
	private $orderLines;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	public function setInbOrder($inbOrder)
	{
		$this->inbOrder = $inbOrder;
	}

	public function setOrderLines($orderLines)
	{
		$this->orderLines = $orderLines;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

}

class PddWmsInborderConfirmRequest_RequestInbOrder extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "inbOrderCode")
	*/
	private $inbOrderCode;

	/**
	* @JsonProperty(String, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "outBizCode")
	*/
	private $outBizCode;

	/**
	* @JsonProperty(String, "status")
	*/
	private $status;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	/**
	* @JsonProperty(Long, "warehouseId")
	*/
	private $warehouseId;

	public function setInbOrderCode($inbOrderCode)
	{
		$this->inbOrderCode = $inbOrderCode;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setOutBizCode($outBizCode)
	{
		$this->outBizCode = $outBizCode;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

	public function setWarehouseId($warehouseId)
	{
		$this->warehouseId = $warehouseId;
	}

}

class PddWmsInborderConfirmRequest_RequestOrderLinesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "actualReceiveQuantity")
	*/
	private $actualReceiveQuantity;

	/**
	* @JsonProperty(String, "inventoryType")
	*/
	private $inventoryType;

	/**
	* @JsonProperty(String, "wareSn")
	*/
	private $wareSn;

	public function setActualReceiveQuantity($actualReceiveQuantity)
	{
		$this->actualReceiveQuantity = $actualReceiveQuantity;
	}

	public function setInventoryType($inventoryType)
	{
		$this->inventoryType = $inventoryType;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

}
