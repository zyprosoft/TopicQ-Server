<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsOuborderConfirmRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderConfirmRequest_Request, "request")
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
		return "pdd.wms.ouborder.confirm";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsOuborderConfirmRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderConfirmRequest_RequestOrderLinesItem>, "orderLines")
	*/
	private $orderLines;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderConfirmRequest_RequestOubOrder, "oubOrder")
	*/
	private $oubOrder;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	public function setOrderLines($orderLines)
	{
		$this->orderLines = $orderLines;
	}

	public function setOubOrder($oubOrder)
	{
		$this->oubOrder = $oubOrder;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

}

class PddWmsOuborderConfirmRequest_RequestOrderLinesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "actualSendQuantity")
	*/
	private $actualSendQuantity;

	/**
	* @JsonProperty(String, "inventoryType")
	*/
	private $inventoryType;

	/**
	* @JsonProperty(String, "wareSn")
	*/
	private $wareSn;

	public function setActualSendQuantity($actualSendQuantity)
	{
		$this->actualSendQuantity = $actualSendQuantity;
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

class PddWmsOuborderConfirmRequest_RequestOubOrder extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "oubOrderCode")
	*/
	private $oubOrderCode;

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

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setOubOrderCode($oubOrderCode)
	{
		$this->oubOrderCode = $oubOrderCode;
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

}
