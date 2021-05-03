<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsSkuPriceUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Long, "market_price")
	*/
	private $marketPrice;

	/**
	* @JsonProperty(String, "market_price_in_yuan")
	*/
	private $marketPriceInYuan;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSkuPriceUpdateRequest_SkuPriceListItem>, "sku_price_list")
	*/
	private $skuPriceList;

	/**
	* @JsonProperty(Integer, "sync_goods_operate")
	*/
	private $syncGoodsOperate;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "market_price", $this->marketPrice);
		$this->setUserParam($params, "market_price_in_yuan", $this->marketPriceInYuan);
		$this->setUserParam($params, "sku_price_list", $this->skuPriceList);
		$this->setUserParam($params, "sync_goods_operate", $this->syncGoodsOperate);

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
		return "pdd.goods.sku.price.update";
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setMarketPrice($marketPrice)
	{
		$this->marketPrice = $marketPrice;
	}

	public function setMarketPriceInYuan($marketPriceInYuan)
	{
		$this->marketPriceInYuan = $marketPriceInYuan;
	}

	public function setSkuPriceList($skuPriceList)
	{
		$this->skuPriceList = $skuPriceList;
	}

	public function setSyncGoodsOperate($syncGoodsOperate)
	{
		$this->syncGoodsOperate = $syncGoodsOperate;
	}

}

class PddGoodsSkuPriceUpdateRequest_SkuPriceListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "group_price")
	*/
	private $groupPrice;

	/**
	* @JsonProperty(Integer, "is_onsale")
	*/
	private $isOnsale;

	/**
	* @JsonProperty(Long, "single_price")
	*/
	private $singlePrice;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	public function setGroupPrice($groupPrice)
	{
		$this->groupPrice = $groupPrice;
	}

	public function setIsOnsale($isOnsale)
	{
		$this->isOnsale = $isOnsale;
	}

	public function setSinglePrice($singlePrice)
	{
		$this->singlePrice = $singlePrice;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

}
