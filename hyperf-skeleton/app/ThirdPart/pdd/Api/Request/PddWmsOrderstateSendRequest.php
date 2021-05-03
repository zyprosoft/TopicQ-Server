<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsOrderstateSendRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOrderstateSendRequest_Request, "request")
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
		return "pdd.wms.orderstate.send";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsOrderstateSendRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOrderstateSendRequest_RequestOrder, "order")
	*/
	private $order;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOrderstateSendRequest_RequestOrderLinesItem>, "orderLines")
	*/
	private $orderLines;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOrderstateSendRequest_RequestProcess, "process")
	*/
	private $process;

	public function setOrder($order)
	{
		$this->order = $order;
	}

	public function setOrderLines($orderLines)
	{
		$this->orderLines = $orderLines;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setProcess($process)
	{
		$this->process = $process;
	}

}

class PddWmsOrderstateSendRequest_RequestOrder extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "orderCode")
	*/
	private $orderCode;

	/**
	* @JsonProperty(String, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	public function setOrderCode($orderCode)
	{
		$this->orderCode = $orderCode;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

}

class PddWmsOrderstateSendRequest_RequestOrderLinesItem extends PopBaseJsonEntity
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

class PddWmsOrderstateSendRequest_RequestProcess extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "operateInfo")
	*/
	private $operateInfo;

	/**
	* @JsonProperty(String, "operateTime")
	*/
	private $operateTime;

	/**
	* @JsonProperty(String, "processStatus")
	*/
	private $processStatus;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	public function setOperateInfo($operateInfo)
	{
		$this->operateInfo = $operateInfo;
	}

	public function setOperateTime($operateTime)
	{
		$this->operateTime = $operateTime;
	}

	public function setProcessStatus($processStatus)
	{
		$this->processStatus = $processStatus;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

}
