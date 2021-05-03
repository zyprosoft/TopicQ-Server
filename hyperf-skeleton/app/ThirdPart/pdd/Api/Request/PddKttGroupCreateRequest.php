<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKttGroupCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddKttGroupCreateRequest_GoodsListItem>, "goods_list")
	*/
	private $goodsList;

	/**
	* @JsonProperty(String, "isv_no")
	*/
	private $isvNo;

	/**
	* @JsonProperty(Integer, "is_save_preview")
	*/
	private $isSavePreview;

	/**
	* @JsonProperty(Long, "start_time")
	*/
	private $startTime;

	/**
	* @JsonProperty(String, "title")
	*/
	private $title;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "end_time", $this->endTime);
		$this->setUserParam($params, "goods_list", $this->goodsList);
		$this->setUserParam($params, "isv_no", $this->isvNo);
		$this->setUserParam($params, "is_save_preview", $this->isSavePreview);
		$this->setUserParam($params, "start_time", $this->startTime);
		$this->setUserParam($params, "title", $this->title);

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
		return "pdd.ktt.group.create";
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setGoodsList($goodsList)
	{
		$this->goodsList = $goodsList;
	}

	public function setIsvNo($isvNo)
	{
		$this->isvNo = $isvNo;
	}

	public function setIsSavePreview($isSavePreview)
	{
		$this->isSavePreview = $isSavePreview;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

	public function setTitle($title)
	{
		$this->title = $title;
	}

}

class PddKttGroupCreateRequest_GoodsListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "category_name")
	*/
	private $categoryName;

	/**
	* @JsonProperty(String, "goods_desc")
	*/
	private $goodsDesc;

	/**
	* @JsonProperty(String, "goods_name")
	*/
	private $goodsName;

	/**
	* @JsonProperty(Integer, "limit_buy")
	*/
	private $limitBuy;

	/**
	* @JsonProperty(Long, "market_price")
	*/
	private $marketPrice;

	/**
	* @JsonProperty(List<String>, "pic_url_list")
	*/
	private $picUrlList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddKttGroupCreateRequest_GoodsListItemSkuListItem>, "sku_list")
	*/
	private $skuList;

	public function setCategoryName($categoryName)
	{
		$this->categoryName = $categoryName;
	}

	public function setGoodsDesc($goodsDesc)
	{
		$this->goodsDesc = $goodsDesc;
	}

	public function setGoodsName($goodsName)
	{
		$this->goodsName = $goodsName;
	}

	public function setLimitBuy($limitBuy)
	{
		$this->limitBuy = $limitBuy;
	}

	public function setMarketPrice($marketPrice)
	{
		$this->marketPrice = $marketPrice;
	}

	public function setPicUrlList($picUrlList)
	{
		$this->picUrlList = $picUrlList;
	}

	public function setSkuList($skuList)
	{
		$this->skuList = $skuList;
	}

}

class PddKttGroupCreateRequest_GoodsListItemSkuListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "external_sku_id")
	*/
	private $externalSkuId;

	/**
	* @JsonProperty(Long, "price_in_fen")
	*/
	private $priceInFen;

	/**
	* @JsonProperty(Integer, "quantity_type")
	*/
	private $quantityType;

	/**
	* @JsonProperty(List<Long>, "spec_id_list")
	*/
	private $specIdList;

	/**
	* @JsonProperty(String, "thumb_url")
	*/
	private $thumbUrl;

	/**
	* @JsonProperty(Long, "total_quantity")
	*/
	private $totalQuantity;

	public function setExternalSkuId($externalSkuId)
	{
		$this->externalSkuId = $externalSkuId;
	}

	public function setPriceInFen($priceInFen)
	{
		$this->priceInFen = $priceInFen;
	}

	public function setQuantityType($quantityType)
	{
		$this->quantityType = $quantityType;
	}

	public function setSpecIdList($specIdList)
	{
		$this->specIdList = $specIdList;
	}

	public function setThumbUrl($thumbUrl)
	{
		$this->thumbUrl = $thumbUrl;
	}

	public function setTotalQuantity($totalQuantity)
	{
		$this->totalQuantity = $totalQuantity;
	}

}
