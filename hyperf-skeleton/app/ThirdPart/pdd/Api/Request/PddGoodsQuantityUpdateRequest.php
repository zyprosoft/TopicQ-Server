<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsQuantityUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Long, "quantity")
	*/
	private $quantity;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	/**
	* @JsonProperty(String, "outer_id")
	*/
	private $outerId;

	/**
	* @JsonProperty(Integer, "update_type")
	*/
	private $updateType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "quantity", $this->quantity);
		$this->setUserParam($params, "sku_id", $this->skuId);
		$this->setUserParam($params, "outer_id", $this->outerId);
		$this->setUserParam($params, "update_type", $this->updateType);

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
		return "pdd.goods.quantity.update";
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

	public function setOuterId($outerId)
	{
		$this->outerId = $outerId;
	}

	public function setUpdateType($updateType)
	{
		$this->updateType = $updateType;
	}

}
