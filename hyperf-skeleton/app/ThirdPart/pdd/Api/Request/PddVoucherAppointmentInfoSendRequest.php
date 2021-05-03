<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherAppointmentInfoSendRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "out_biz_no")
	*/
	private $outBizNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherAppointmentInfoSendRequest_VoucherListItem>, "voucher_list")
	*/
	private $voucherList;

	/**
	* @JsonProperty(Integer, "logistics_type")
	*/
	private $logisticsType;

	/**
	* @JsonProperty(Long, "appointment_time")
	*/
	private $appointmentTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "out_biz_no", $this->outBizNo);
		$this->setUserParam($params, "voucher_list", $this->voucherList);
		$this->setUserParam($params, "logistics_type", $this->logisticsType);
		$this->setUserParam($params, "appointment_time", $this->appointmentTime);

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
		return "pdd.voucher.appointment.info.send";
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setOutBizNo($outBizNo)
	{
		$this->outBizNo = $outBizNo;
	}

	public function setVoucherList($voucherList)
	{
		$this->voucherList = $voucherList;
	}

	public function setLogisticsType($logisticsType)
	{
		$this->logisticsType = $logisticsType;
	}

	public function setAppointmentTime($appointmentTime)
	{
		$this->appointmentTime = $appointmentTime;
	}

}

class PddVoucherAppointmentInfoSendRequest_VoucherListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "voucher_id")
	*/
	private $voucherId;

	/**
	* @JsonProperty(String, "voucher_no")
	*/
	private $voucherNo;

	public function setVoucherId($voucherId)
	{
		$this->voucherId = $voucherId;
	}

	public function setVoucherNo($voucherNo)
	{
		$this->voucherNo = $voucherNo;
	}

}
