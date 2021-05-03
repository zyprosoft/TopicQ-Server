<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsOuborderCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderCreateRequest_Request, "request")
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
		return "pdd.wms.ouborder.create";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsOuborderCreateRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderCreateRequest_RequestOrderLineItem>, "orderLine")
	*/
	private $orderLine;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderCreateRequest_RequestOubOrder, "oubOrder")
	*/
	private $oubOrder;

	public function setOrderLine($orderLine)
	{
		$this->orderLine = $orderLine;
	}

	public function setOubOrder($oubOrder)
	{
		$this->oubOrder = $oubOrder;
	}

}

class PddWmsOuborderCreateRequest_RequestOrderLineItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "inventoryType")
	*/
	private $inventoryType;

	/**
	* @JsonProperty(String, "planSendQuantity")
	*/
	private $planSendQuantity;

	/**
	* @JsonProperty(String, "wareSn")
	*/
	private $wareSn;

	public function setInventoryType($inventoryType)
	{
		$this->inventoryType = $inventoryType;
	}

	public function setPlanSendQuantity($planSendQuantity)
	{
		$this->planSendQuantity = $planSendQuantity;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

}

class PddWmsOuborderCreateRequest_RequestOubOrder extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "createTime")
	*/
	private $createTime;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderCreateRequest_RequestOubOrderMallContracter, "mallContracter")
	*/
	private $mallContracter;

	/**
	* @JsonProperty(String, "orderType")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "oubOrderCode")
	*/
	private $oubOrderCode;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(String, "planSendTime")
	*/
	private $planSendTime;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderCreateRequest_RequestOubOrderReceiverInfo, "receiverInfo")
	*/
	private $receiverInfo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsOuborderCreateRequest_RequestOubOrderRelatedOrdersItem>, "relatedOrders")
	*/
	private $relatedOrders;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	public function setCreateTime($createTime)
	{
		$this->createTime = $createTime;
	}

	public function setMallContracter($mallContracter)
	{
		$this->mallContracter = $mallContracter;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setOubOrderCode($oubOrderCode)
	{
		$this->oubOrderCode = $oubOrderCode;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setPlanSendTime($planSendTime)
	{
		$this->planSendTime = $planSendTime;
	}

	public function setReceiverInfo($receiverInfo)
	{
		$this->receiverInfo = $receiverInfo;
	}

	public function setRelatedOrders($relatedOrders)
	{
		$this->relatedOrders = $relatedOrders;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

}

class PddWmsOuborderCreateRequest_RequestOubOrderMallContracter extends PopBaseJsonEntity
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

class PddWmsOuborderCreateRequest_RequestOubOrderReceiverInfo extends PopBaseJsonEntity
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

class PddWmsOuborderCreateRequest_RequestOubOrderRelatedOrdersItem extends PopBaseJsonEntity
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
