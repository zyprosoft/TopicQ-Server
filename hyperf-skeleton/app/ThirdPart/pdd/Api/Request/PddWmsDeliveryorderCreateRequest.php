<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsDeliveryorderCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsDeliveryorderCreateRequest_Request, "request")
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
		return "pdd.wms.deliveryorder.create";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsDeliveryorderCreateRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "createTime")
	*/
	private $createTime;

	/**
	* @JsonProperty(String, "deliveryOrderCode")
	*/
	private $deliveryOrderCode;

	/**
	* @JsonProperty(String, "orderFlag")
	*/
	private $orderFlag;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsDeliveryorderCreateRequest_RequestOrderLinesItem>, "orderLines")
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
	* @JsonProperty(String, "placeOrderTime")
	*/
	private $placeOrderTime;

	/**
	* @JsonProperty(String, "receiverCity")
	*/
	private $receiverCity;

	/**
	* @JsonProperty(String, "receiverDetailAddress")
	*/
	private $receiverDetailAddress;

	/**
	* @JsonProperty(String, "receiverDistrict")
	*/
	private $receiverDistrict;

	/**
	* @JsonProperty(String, "receiverName")
	*/
	private $receiverName;

	/**
	* @JsonProperty(String, "receiverPhone")
	*/
	private $receiverPhone;

	/**
	* @JsonProperty(String, "receiverProvince")
	*/
	private $receiverProvince;

	/**
	* @JsonProperty(String, "shopNick")
	*/
	private $shopNick;

	/**
	* @JsonProperty(String, "warehouseCode")
	*/
	private $warehouseCode;

	public function setCreateTime($createTime)
	{
		$this->createTime = $createTime;
	}

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

	public function setPlaceOrderTime($placeOrderTime)
	{
		$this->placeOrderTime = $placeOrderTime;
	}

	public function setReceiverCity($receiverCity)
	{
		$this->receiverCity = $receiverCity;
	}

	public function setReceiverDetailAddress($receiverDetailAddress)
	{
		$this->receiverDetailAddress = $receiverDetailAddress;
	}

	public function setReceiverDistrict($receiverDistrict)
	{
		$this->receiverDistrict = $receiverDistrict;
	}

	public function setReceiverName($receiverName)
	{
		$this->receiverName = $receiverName;
	}

	public function setReceiverPhone($receiverPhone)
	{
		$this->receiverPhone = $receiverPhone;
	}

	public function setReceiverProvince($receiverProvince)
	{
		$this->receiverProvince = $receiverProvince;
	}

	public function setShopNick($shopNick)
	{
		$this->shopNick = $shopNick;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

}

class PddWmsDeliveryorderCreateRequest_RequestOrderLinesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

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
