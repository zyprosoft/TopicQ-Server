<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsChildSkuEditRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "goods_commit_id")
	*/
	private $goodsCommitId;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsChildSkuEditRequest_SkusItem>, "skus")
	*/
	private $skus;

	/**
	* @JsonProperty(Integer, "sync_goods_operate")
	*/
	private $syncGoodsOperate;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_commit_id", $this->goodsCommitId);
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "skus", $this->skus);
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
		return "pdd.goods.child.sku.edit";
	}

	public function setGoodsCommitId($goodsCommitId)
	{
		$this->goodsCommitId = $goodsCommitId;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setSkus($skus)
	{
		$this->skus = $skus;
	}

	public function setSyncGoodsOperate($syncGoodsOperate)
	{
		$this->syncGoodsOperate = $syncGoodsOperate;
	}

}

class PddGoodsChildSkuEditRequest_SkusItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsChildSkuEditRequest_SkusItemChildSkusItem>, "child_skus")
	*/
	private $childSkus;

	/**
	* @JsonProperty(Integer, "is_onsale")
	*/
	private $isOnsale;

	/**
	* @JsonProperty(String, "out_sku_sn")
	*/
	private $outSkuSn;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	public function setChildSkus($childSkus)
	{
		$this->childSkus = $childSkus;
	}

	public function setIsOnsale($isOnsale)
	{
		$this->isOnsale = $isOnsale;
	}

	public function setOutSkuSn($outSkuSn)
	{
		$this->outSkuSn = $outSkuSn;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

}

class PddGoodsChildSkuEditRequest_SkusItemChildSkusItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "date")
	*/
	private $date;

	/**
	* @JsonProperty(Long, "group_price")
	*/
	private $groupPrice;

	/**
	* @JsonProperty(Long, "quantity_delta")
	*/
	private $quantityDelta;

	/**
	* @JsonProperty(Long, "single_price")
	*/
	private $singlePrice;

	public function setDate($date)
	{
		$this->date = $date;
	}

	public function setGroupPrice($groupPrice)
	{
		$this->groupPrice = $groupPrice;
	}

	public function setQuantityDelta($quantityDelta)
	{
		$this->quantityDelta = $quantityDelta;
	}

	public function setSinglePrice($singlePrice)
	{
		$this->singlePrice = $singlePrice;
	}

}
