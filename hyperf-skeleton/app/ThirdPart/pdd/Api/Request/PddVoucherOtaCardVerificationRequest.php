<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherOtaCardVerificationRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "card_no")
	*/
	private $cardNo;

	/**
	* @JsonProperty(Long, "store_id")
	*/
	private $storeId;

	/**
	* @JsonProperty(String, "store_name")
	*/
	private $storeName;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "card_no", $this->cardNo);
		$this->setUserParam($params, "store_id", $this->storeId);
		$this->setUserParam($params, "store_name", $this->storeName);
		$this->setUserParam($params, "order_sn", $this->orderSn);

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
		return "pdd.voucher.ota.card.verification";
	}

	public function setCardNo($cardNo)
	{
		$this->cardNo = $cardNo;
	}

	public function setStoreId($storeId)
	{
		$this->storeId = $storeId;
	}

	public function setStoreName($storeName)
	{
		$this->storeName = $storeName;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

}
