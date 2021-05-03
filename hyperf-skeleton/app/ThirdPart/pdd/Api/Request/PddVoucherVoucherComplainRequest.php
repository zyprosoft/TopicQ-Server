<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherVoucherComplainRequest extends PopBaseHttpRequest
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherVoucherComplainRequest_VoucherListItem>, "voucher_list")
	*/
	private $voucherList;

	/**
	* @JsonProperty(String, "complain_user")
	*/
	private $complainUser;

	/**
	* @JsonProperty(String, "complain_user_mobile")
	*/
	private $complainUserMobile;

	/**
	* @JsonProperty(String, "complain_content")
	*/
	private $complainContent;

	/**
	* @JsonProperty(List<String>, "complain_attachment_list")
	*/
	private $complainAttachmentList;

	/**
	* @JsonProperty(Integer, "complain_type")
	*/
	private $complainType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "out_biz_no", $this->outBizNo);
		$this->setUserParam($params, "voucher_list", $this->voucherList);
		$this->setUserParam($params, "complain_user", $this->complainUser);
		$this->setUserParam($params, "complain_user_mobile", $this->complainUserMobile);
		$this->setUserParam($params, "complain_content", $this->complainContent);
		$this->setUserParam($params, "complain_attachment_list", $this->complainAttachmentList);
		$this->setUserParam($params, "complain_type", $this->complainType);

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
		return "pdd.voucher.voucher.complain";
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

	public function setComplainUser($complainUser)
	{
		$this->complainUser = $complainUser;
	}

	public function setComplainUserMobile($complainUserMobile)
	{
		$this->complainUserMobile = $complainUserMobile;
	}

	public function setComplainContent($complainContent)
	{
		$this->complainContent = $complainContent;
	}

	public function setComplainAttachmentList($complainAttachmentList)
	{
		$this->complainAttachmentList = $complainAttachmentList;
	}

	public function setComplainType($complainType)
	{
		$this->complainType = $complainType;
	}

}

class PddVoucherVoucherComplainRequest_VoucherListItem extends PopBaseJsonEntity
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
