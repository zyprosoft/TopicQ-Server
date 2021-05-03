<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKttGoodsIncrQuantityRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Integer, "modify_quantity_type")
	*/
	private $modifyQuantityType;

	/**
	* @JsonProperty(Integer, "quantity_delta")
	*/
	private $quantityDelta;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "modify_quantity_type", $this->modifyQuantityType);
		$this->setUserParam($params, "quantity_delta", $this->quantityDelta);
		$this->setUserParam($params, "sku_id", $this->skuId);

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
		return "pdd.ktt.goods.incr.quantity";
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setModifyQuantityType($modifyQuantityType)
	{
		$this->modifyQuantityType = $modifyQuantityType;
	}

	public function setQuantityDelta($quantityDelta)
	{
		$this->quantityDelta = $quantityDelta;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

}
