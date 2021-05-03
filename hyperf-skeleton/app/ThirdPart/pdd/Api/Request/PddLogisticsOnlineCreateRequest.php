<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddLogisticsOnlineCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "delivery_address")
	*/
	private $deliveryAddress;

	/**
	* @JsonProperty(String, "delivery_id")
	*/
	private $deliveryId;

	/**
	* @JsonProperty(String, "delivery_name")
	*/
	private $deliveryName;

	/**
	* @JsonProperty(String, "delivery_phone")
	*/
	private $deliveryPhone;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "return_id")
	*/
	private $returnId;

	/**
	* @JsonProperty(Integer, "shipping_id")
	*/
	private $shippingId;

	/**
	* @JsonProperty(String, "tracking_number")
	*/
	private $trackingNumber;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "delivery_address", $this->deliveryAddress);
		$this->setUserParam($params, "delivery_id", $this->deliveryId);
		$this->setUserParam($params, "delivery_name", $this->deliveryName);
		$this->setUserParam($params, "delivery_phone", $this->deliveryPhone);
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "return_id", $this->returnId);
		$this->setUserParam($params, "shipping_id", $this->shippingId);
		$this->setUserParam($params, "tracking_number", $this->trackingNumber);

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
		return "pdd.logistics.online.create";
	}

	public function setDeliveryAddress($deliveryAddress)
	{
		$this->deliveryAddress = $deliveryAddress;
	}

	public function setDeliveryId($deliveryId)
	{
		$this->deliveryId = $deliveryId;
	}

	public function setDeliveryName($deliveryName)
	{
		$this->deliveryName = $deliveryName;
	}

	public function setDeliveryPhone($deliveryPhone)
	{
		$this->deliveryPhone = $deliveryPhone;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setReturnId($returnId)
	{
		$this->returnId = $returnId;
	}

	public function setShippingId($shippingId)
	{
		$this->shippingId = $shippingId;
	}

	public function setTrackingNumber($trackingNumber)
	{
		$this->trackingNumber = $trackingNumber;
	}

}
