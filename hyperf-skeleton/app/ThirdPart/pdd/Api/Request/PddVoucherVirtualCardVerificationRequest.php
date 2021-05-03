<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherVirtualCardVerificationRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherVirtualCardVerificationRequest_VoucherDataListItem>, "voucher_data_list")
	*/
	private $voucherDataList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "voucher_data_list", $this->voucherDataList);

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
		return "pdd.voucher.virtual.card.verification";
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setVoucherDataList($voucherDataList)
	{
		$this->voucherDataList = $voucherDataList;
	}

}

class PddVoucherVirtualCardVerificationRequest_VoucherDataListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "out_trans_no")
	*/
	private $outTransNo;

	/**
	* @JsonProperty(Long, "voucher_time")
	*/
	private $voucherTime;

	/**
	* @JsonProperty(Integer, "voucher_status")
	*/
	private $voucherStatus;

	/**
	* @JsonProperty(String, "voucher_no")
	*/
	private $voucherNo;

	public function setOutTransNo($outTransNo)
	{
		$this->outTransNo = $outTransNo;
	}

	public function setVoucherTime($voucherTime)
	{
		$this->voucherTime = $voucherTime;
	}

	public function setVoucherStatus($voucherStatus)
	{
		$this->voucherStatus = $voucherStatus;
	}

	public function setVoucherNo($voucherNo)
	{
		$this->voucherNo = $voucherNo;
	}

}
