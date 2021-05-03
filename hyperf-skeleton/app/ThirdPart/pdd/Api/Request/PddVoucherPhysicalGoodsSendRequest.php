<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherPhysicalGoodsSendRequest extends PopBaseHttpRequest
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherPhysicalGoodsSendRequest_VoucherListItem>, "voucher_list")
	*/
	private $voucherList;

	/**
	* @JsonProperty(Integer, "logistics_type")
	*/
	private $logisticsType;

	/**
	* @JsonProperty(String, "recipient")
	*/
	private $recipient;

	/**
	* @JsonProperty(String, "recipient_mobile")
	*/
	private $recipientMobile;

	/**
	* @JsonProperty(String, "recipient_address")
	*/
	private $recipientAddress;

	/**
	* @JsonProperty(String, "logistics_no")
	*/
	private $logisticsNo;

	/**
	* @JsonProperty(String, "logistics_company_id")
	*/
	private $logisticsCompanyId;

	/**
	* @JsonProperty(String, "logistics_company")
	*/
	private $logisticsCompany;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "out_biz_no", $this->outBizNo);
		$this->setUserParam($params, "voucher_list", $this->voucherList);
		$this->setUserParam($params, "logistics_type", $this->logisticsType);
		$this->setUserParam($params, "recipient", $this->recipient);
		$this->setUserParam($params, "recipient_mobile", $this->recipientMobile);
		$this->setUserParam($params, "recipient_address", $this->recipientAddress);
		$this->setUserParam($params, "logistics_no", $this->logisticsNo);
		$this->setUserParam($params, "logistics_company_id", $this->logisticsCompanyId);
		$this->setUserParam($params, "logistics_company", $this->logisticsCompany);

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
		return "pdd.voucher.physical.goods.send";
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

	public function setRecipient($recipient)
	{
		$this->recipient = $recipient;
	}

	public function setRecipientMobile($recipientMobile)
	{
		$this->recipientMobile = $recipientMobile;
	}

	public function setRecipientAddress($recipientAddress)
	{
		$this->recipientAddress = $recipientAddress;
	}

	public function setLogisticsNo($logisticsNo)
	{
		$this->logisticsNo = $logisticsNo;
	}

	public function setLogisticsCompanyId($logisticsCompanyId)
	{
		$this->logisticsCompanyId = $logisticsCompanyId;
	}

	public function setLogisticsCompany($logisticsCompany)
	{
		$this->logisticsCompany = $logisticsCompany;
	}

}

class PddVoucherPhysicalGoodsSendRequest_VoucherListItem extends PopBaseJsonEntity
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
