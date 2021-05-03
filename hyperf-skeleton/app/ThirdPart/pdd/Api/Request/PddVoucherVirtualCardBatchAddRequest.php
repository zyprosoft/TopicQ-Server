<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherVirtualCardBatchAddRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherVirtualCardBatchAddRequest_Data, "data")
	*/
	private $data;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "data", $this->data);

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
		return "pdd.voucher.virtual.card.batch.add";
	}

	public function setData($data)
	{
		$this->data = $data;
	}

}

class PddVoucherVirtualCardBatchAddRequest_Data extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "chargeAddress")
	*/
	private $chargeAddress;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherVirtualCardBatchAddRequest_DataDataListItem>, "dataList")
	*/
	private $dataList;

	/**
	* @JsonProperty(Long, "goodsId")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Long, "skuId")
	*/
	private $skuId;

	public function setChargeAddress($chargeAddress)
	{
		$this->chargeAddress = $chargeAddress;
	}

	public function setDataList($dataList)
	{
		$this->dataList = $dataList;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

}

class PddVoucherVirtualCardBatchAddRequest_DataDataListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "cardNo")
	*/
	private $cardNo;

	/**
	* @JsonProperty(String, "encryptPassword")
	*/
	private $encryptPassword;

	public function setCardNo($cardNo)
	{
		$this->cardNo = $cardNo;
	}

	public function setEncryptPassword($encryptPassword)
	{
		$this->encryptPassword = $encryptPassword;
	}

}
