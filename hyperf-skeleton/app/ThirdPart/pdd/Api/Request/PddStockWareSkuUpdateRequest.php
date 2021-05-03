<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddStockWareSkuUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "ware_id")
	*/
	private $wareId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddStockWareSkuUpdateRequest_WareSkusItem>, "ware_skus")
	*/
	private $wareSkus;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "ware_id", $this->wareId);
		$this->setUserParam($params, "ware_skus", $this->wareSkus);

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
		return "pdd.stock.ware.sku.update";
	}

	public function setWareId($wareId)
	{
		$this->wareId = $wareId;
	}

	public function setWareSkus($wareSkus)
	{
		$this->wareSkus = $wareSkus;
	}

}

class PddStockWareSkuUpdateRequest_WareSkusItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

}
