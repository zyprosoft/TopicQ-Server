<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherRealtimeVerifySyncRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherRealtimeVerifySyncRequest_Request, "request")
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
		return "pdd.voucher.realtime.verify.sync";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddVoucherRealtimeVerifySyncRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	/**
	* @JsonProperty(String, "serial_no")
	*/
	private $serialNo;

	/**
	* @JsonProperty(String, "shop_name")
	*/
	private $shopName;

	/**
	* @JsonProperty(String, "shop_no")
	*/
	private $shopNo;

	/**
	* @JsonProperty(Long, "verify_time")
	*/
	private $verifyTime;

	/**
	* @JsonProperty(String, "out_voucher_id")
	*/
	private $outVoucherId;

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	public function setSerialNo($serialNo)
	{
		$this->serialNo = $serialNo;
	}

	public function setShopName($shopName)
	{
		$this->shopName = $shopName;
	}

	public function setShopNo($shopNo)
	{
		$this->shopNo = $shopNo;
	}

	public function setVerifyTime($verifyTime)
	{
		$this->verifyTime = $verifyTime;
	}

	public function setOutVoucherId($outVoucherId)
	{
		$this->outVoucherId = $outVoucherId;
	}

}
