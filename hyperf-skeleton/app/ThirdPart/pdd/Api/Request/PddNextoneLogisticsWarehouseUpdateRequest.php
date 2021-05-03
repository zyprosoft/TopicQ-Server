<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddNextoneLogisticsWarehouseUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddNextoneLogisticsWarehouseUpdateRequest_Request, "request")
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
		return "pdd.nextone.logistics.warehouse.update";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddNextoneLogisticsWarehouseUpdateRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "after_sales_id")
	*/
	private $afterSalesId;

	/**
	* @JsonProperty(Long, "operate_time")
	*/
	private $operateTime;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(Integer, "reverse_logistics_id")
	*/
	private $reverseLogisticsId;

	/**
	* @JsonProperty(String, "reverse_tracking_number")
	*/
	private $reverseTrackingNumber;

	/**
	* @JsonProperty(Integer, "warehouse_status")
	*/
	private $warehouseStatus;

	public function setAfterSalesId($afterSalesId)
	{
		$this->afterSalesId = $afterSalesId;
	}

	public function setOperateTime($operateTime)
	{
		$this->operateTime = $operateTime;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setReverseLogisticsId($reverseLogisticsId)
	{
		$this->reverseLogisticsId = $reverseLogisticsId;
	}

	public function setReverseTrackingNumber($reverseTrackingNumber)
	{
		$this->reverseTrackingNumber = $reverseTrackingNumber;
	}

	public function setWarehouseStatus($warehouseStatus)
	{
		$this->warehouseStatus = $warehouseStatus;
	}

}
