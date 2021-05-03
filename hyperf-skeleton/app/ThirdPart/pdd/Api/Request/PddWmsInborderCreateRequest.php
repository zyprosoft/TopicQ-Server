<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsInborderCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderCreateRequest_Request, "request")
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
		return "pdd.wms.inborder.create";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsInborderCreateRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderCreateRequest_RequestInbOrder, "inbOrder")
	*/
	private $inbOrder;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderCreateRequest_RequestOrderLineItem>, "orderLine")
	*/
	private $orderLine;

	public function setInbOrder($inbOrder)
	{
		$this->inbOrder = $inbOrder;
	}

	public function setOrderLine($orderLine)
	{
		$this->orderLine = $orderLine;
	}

}

class PddWmsInborderCreateRequest_RequestInbOrder extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "createTime")
	*/
	private $createTime;

	/**
	* @JsonProperty(String, "inbOrderCode")
	*/
	private $inbOrderCode;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderCreateRequest_RequestInbOrderMallContracter, "mallContracter")
	*/
	private $mallContracter;

	/**
	* @JsonProperty(String, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(String, "planReceiveTime")
	*/
	private $planReceiveTime;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderCreateRequest_RequestInbOrderRelatedOrdersItem>, "relatedOrders")
	*/
	private $relatedOrders;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsInborderCreateRequest_RequestInbOrderSenderInfo, "senderInfo")
	*/
	private $senderInfo;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	public function setCreateTime($createTime)
	{
		$this->createTime = $createTime;
	}

	public function setInbOrderCode($inbOrderCode)
	{
		$this->inbOrderCode = $inbOrderCode;
	}

	public function setMallContracter($mallContracter)
	{
		$this->mallContracter = $mallContracter;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setPlanReceiveTime($planReceiveTime)
	{
		$this->planReceiveTime = $planReceiveTime;
	}

	public function setRelatedOrders($relatedOrders)
	{
		$this->relatedOrders = $relatedOrders;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	public function setSenderInfo($senderInfo)
	{
		$this->senderInfo = $senderInfo;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

}

class PddWmsInborderCreateRequest_RequestInbOrderMallContracter extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

}

class PddWmsInborderCreateRequest_RequestInbOrderRelatedOrdersItem extends PopBaseJsonEntity
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

	public function setOrderCode($orderCode)
	{
		$this->orderCode = $orderCode;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

}

class PddWmsInborderCreateRequest_RequestInbOrderSenderInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "address")
	*/
	private $address;

	/**
	* @JsonProperty(String, "area")
	*/
	private $area;

	/**
	* @JsonProperty(String, "city")
	*/
	private $city;

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "province")
	*/
	private $province;

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function setArea($area)
	{
		$this->area = $area;
	}

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setProvince($province)
	{
		$this->province = $province;
	}

}

class PddWmsInborderCreateRequest_RequestOrderLineItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "inventoryType")
	*/
	private $inventoryType;

	/**
	* @JsonProperty(String, "planReceiveQuantity")
	*/
	private $planReceiveQuantity;

	/**
	* @JsonProperty(String, "wareSn")
	*/
	private $wareSn;

	public function setInventoryType($inventoryType)
	{
		$this->inventoryType = $inventoryType;
	}

	public function setPlanReceiveQuantity($planReceiveQuantity)
	{
		$this->planReceiveQuantity = $planReceiveQuantity;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

}
