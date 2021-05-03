<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsAddRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "bad_fruit_claim")
	*/
	private $badFruitClaim;

	/**
	* @JsonProperty(Long, "buy_limit")
	*/
	private $buyLimit;

	/**
	* @JsonProperty(List<String>, "carousel_gallery")
	*/
	private $carouselGallery;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_CarouselVideoItem>, "carousel_video")
	*/
	private $carouselVideo;

	/**
	* @JsonProperty(String, "carousel_video_url")
	*/
	private $carouselVideoUrl;

	/**
	* @JsonProperty(Long, "cat_id")
	*/
	private $catId;

	/**
	* @JsonProperty(Long, "cost_template_id")
	*/
	private $costTemplateId;

	/**
	* @JsonProperty(Integer, "country_id")
	*/
	private $countryId;

	/**
	* @JsonProperty(Long, "customer_num")
	*/
	private $customerNum;

	/**
	* @JsonProperty(String, "customs")
	*/
	private $customs;

	/**
	* @JsonProperty(Integer, "delivery_one_day")
	*/
	private $deliveryOneDay;

	/**
	* @JsonProperty(List<String>, "detail_gallery")
	*/
	private $detailGallery;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_ElecGoodsAttributes, "elec_goods_attributes")
	*/
	private $elecGoodsAttributes;

	/**
	* @JsonProperty(String, "goods_desc")
	*/
	private $goodsDesc;

	/**
	* @JsonProperty(String, "goods_name")
	*/
	private $goodsName;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_GoodsPropertiesItem>, "goods_properties")
	*/
	private $goodsProperties;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_GoodsTradeAttr, "goods_trade_attr")
	*/
	private $goodsTradeAttr;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_GoodsTravelAttr, "goods_travel_attr")
	*/
	private $goodsTravelAttr;

	/**
	* @JsonProperty(Integer, "goods_type")
	*/
	private $goodsType;

	/**
	* @JsonProperty(String, "image_url")
	*/
	private $imageUrl;

	/**
	* @JsonProperty(Boolean, "invoice_status")
	*/
	private $invoiceStatus;

	/**
	* @JsonProperty(Boolean, "is_customs")
	*/
	private $isCustoms;

	/**
	* @JsonProperty(Boolean, "is_folt")
	*/
	private $isFolt;

	/**
	* @JsonProperty(Boolean, "is_pre_sale")
	*/
	private $isPreSale;

	/**
	* @JsonProperty(Boolean, "is_refundable")
	*/
	private $isRefundable;

	/**
	* @JsonProperty(Integer, "lack_of_weight_claim")
	*/
	private $lackOfWeightClaim;

	/**
	* @JsonProperty(String, "mai_jia_zi_ti")
	*/
	private $maiJiaZiTi;

	/**
	* @JsonProperty(Long, "market_price")
	*/
	private $marketPrice;

	/**
	* @JsonProperty(Integer, "order_limit")
	*/
	private $orderLimit;

	/**
	* @JsonProperty(Integer, "origin_country_id")
	*/
	private $originCountryId;

	/**
	* @JsonProperty(String, "out_goods_id")
	*/
	private $outGoodsId;

	/**
	* @JsonProperty(String, "out_source_goods_id")
	*/
	private $outSourceGoodsId;

	/**
	* @JsonProperty(Integer, "out_source_type")
	*/
	private $outSourceType;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_OverseaGoods, "oversea_goods")
	*/
	private $overseaGoods;

	/**
	* @JsonProperty(Integer, "oversea_type")
	*/
	private $overseaType;

	/**
	* @JsonProperty(Long, "pre_sale_time")
	*/
	private $preSaleTime;

	/**
	* @JsonProperty(Integer, "quan_guo_lian_bao")
	*/
	private $quanGuoLianBao;

	/**
	* @JsonProperty(Boolean, "second_hand")
	*/
	private $secondHand;

	/**
	* @JsonProperty(String, "shang_men_an_zhuang")
	*/
	private $shangMenAnZhuang;

	/**
	* @JsonProperty(Long, "shipment_limit_second")
	*/
	private $shipmentLimitSecond;

	/**
	* @JsonProperty(Long, "size_spec_id")
	*/
	private $sizeSpecId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_SkuListItem>, "sku_list")
	*/
	private $skuList;

	/**
	* @JsonProperty(Integer, "sku_type")
	*/
	private $skuType;

	/**
	* @JsonProperty(String, "song_huo_an_zhuang")
	*/
	private $songHuoAnZhuang;

	/**
	* @JsonProperty(String, "song_huo_ru_hu")
	*/
	private $songHuoRuHu;

	/**
	* @JsonProperty(String, "tiny_name")
	*/
	private $tinyName;

	/**
	* @JsonProperty(String, "warehouse")
	*/
	private $warehouse;

	/**
	* @JsonProperty(String, "warm_tips")
	*/
	private $warmTips;

	/**
	* @JsonProperty(Integer, "zhi_huan_bu_xiu")
	*/
	private $zhiHuanBuXiu;

	/**
	* @JsonProperty(Integer, "delivery_type")
	*/
	private $deliveryType;

	/**
	* @JsonProperty(Integer, "is_group_pre_sale")
	*/
	private $isGroupPreSale;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "bad_fruit_claim", $this->badFruitClaim);
		$this->setUserParam($params, "buy_limit", $this->buyLimit);
		$this->setUserParam($params, "carousel_gallery", $this->carouselGallery);
		$this->setUserParam($params, "carousel_video", $this->carouselVideo);
		$this->setUserParam($params, "carousel_video_url", $this->carouselVideoUrl);
		$this->setUserParam($params, "cat_id", $this->catId);
		$this->setUserParam($params, "cost_template_id", $this->costTemplateId);
		$this->setUserParam($params, "country_id", $this->countryId);
		$this->setUserParam($params, "customer_num", $this->customerNum);
		$this->setUserParam($params, "customs", $this->customs);
		$this->setUserParam($params, "delivery_one_day", $this->deliveryOneDay);
		$this->setUserParam($params, "detail_gallery", $this->detailGallery);
		$this->setUserParam($params, "elec_goods_attributes", $this->elecGoodsAttributes);
		$this->setUserParam($params, "goods_desc", $this->goodsDesc);
		$this->setUserParam($params, "goods_name", $this->goodsName);
		$this->setUserParam($params, "goods_properties", $this->goodsProperties);
		$this->setUserParam($params, "goods_trade_attr", $this->goodsTradeAttr);
		$this->setUserParam($params, "goods_travel_attr", $this->goodsTravelAttr);
		$this->setUserParam($params, "goods_type", $this->goodsType);
		$this->setUserParam($params, "image_url", $this->imageUrl);
		$this->setUserParam($params, "invoice_status", $this->invoiceStatus);
		$this->setUserParam($params, "is_customs", $this->isCustoms);
		$this->setUserParam($params, "is_folt", $this->isFolt);
		$this->setUserParam($params, "is_pre_sale", $this->isPreSale);
		$this->setUserParam($params, "is_refundable", $this->isRefundable);
		$this->setUserParam($params, "lack_of_weight_claim", $this->lackOfWeightClaim);
		$this->setUserParam($params, "mai_jia_zi_ti", $this->maiJiaZiTi);
		$this->setUserParam($params, "market_price", $this->marketPrice);
		$this->setUserParam($params, "order_limit", $this->orderLimit);
		$this->setUserParam($params, "origin_country_id", $this->originCountryId);
		$this->setUserParam($params, "out_goods_id", $this->outGoodsId);
		$this->setUserParam($params, "out_source_goods_id", $this->outSourceGoodsId);
		$this->setUserParam($params, "out_source_type", $this->outSourceType);
		$this->setUserParam($params, "oversea_goods", $this->overseaGoods);
		$this->setUserParam($params, "oversea_type", $this->overseaType);
		$this->setUserParam($params, "pre_sale_time", $this->preSaleTime);
		$this->setUserParam($params, "quan_guo_lian_bao", $this->quanGuoLianBao);
		$this->setUserParam($params, "second_hand", $this->secondHand);
		$this->setUserParam($params, "shang_men_an_zhuang", $this->shangMenAnZhuang);
		$this->setUserParam($params, "shipment_limit_second", $this->shipmentLimitSecond);
		$this->setUserParam($params, "size_spec_id", $this->sizeSpecId);
		$this->setUserParam($params, "sku_list", $this->skuList);
		$this->setUserParam($params, "sku_type", $this->skuType);
		$this->setUserParam($params, "song_huo_an_zhuang", $this->songHuoAnZhuang);
		$this->setUserParam($params, "song_huo_ru_hu", $this->songHuoRuHu);
		$this->setUserParam($params, "tiny_name", $this->tinyName);
		$this->setUserParam($params, "warehouse", $this->warehouse);
		$this->setUserParam($params, "warm_tips", $this->warmTips);
		$this->setUserParam($params, "zhi_huan_bu_xiu", $this->zhiHuanBuXiu);
		$this->setUserParam($params, "delivery_type", $this->deliveryType);
		$this->setUserParam($params, "is_group_pre_sale", $this->isGroupPreSale);

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
		return "pdd.goods.add";
	}

	public function setBadFruitClaim($badFruitClaim)
	{
		$this->badFruitClaim = $badFruitClaim;
	}

	public function setBuyLimit($buyLimit)
	{
		$this->buyLimit = $buyLimit;
	}

	public function setCarouselGallery($carouselGallery)
	{
		$this->carouselGallery = $carouselGallery;
	}

	public function setCarouselVideo($carouselVideo)
	{
		$this->carouselVideo = $carouselVideo;
	}

	public function setCarouselVideoUrl($carouselVideoUrl)
	{
		$this->carouselVideoUrl = $carouselVideoUrl;
	}

	public function setCatId($catId)
	{
		$this->catId = $catId;
	}

	public function setCostTemplateId($costTemplateId)
	{
		$this->costTemplateId = $costTemplateId;
	}

	public function setCountryId($countryId)
	{
		$this->countryId = $countryId;
	}

	public function setCustomerNum($customerNum)
	{
		$this->customerNum = $customerNum;
	}

	public function setCustoms($customs)
	{
		$this->customs = $customs;
	}

	public function setDeliveryOneDay($deliveryOneDay)
	{
		$this->deliveryOneDay = $deliveryOneDay;
	}

	public function setDetailGallery($detailGallery)
	{
		$this->detailGallery = $detailGallery;
	}

	public function setElecGoodsAttributes($elecGoodsAttributes)
	{
		$this->elecGoodsAttributes = $elecGoodsAttributes;
	}

	public function setGoodsDesc($goodsDesc)
	{
		$this->goodsDesc = $goodsDesc;
	}

	public function setGoodsName($goodsName)
	{
		$this->goodsName = $goodsName;
	}

	public function setGoodsProperties($goodsProperties)
	{
		$this->goodsProperties = $goodsProperties;
	}

	public function setGoodsTradeAttr($goodsTradeAttr)
	{
		$this->goodsTradeAttr = $goodsTradeAttr;
	}

	public function setGoodsTravelAttr($goodsTravelAttr)
	{
		$this->goodsTravelAttr = $goodsTravelAttr;
	}

	public function setGoodsType($goodsType)
	{
		$this->goodsType = $goodsType;
	}

	public function setImageUrl($imageUrl)
	{
		$this->imageUrl = $imageUrl;
	}

	public function setInvoiceStatus($invoiceStatus)
	{
		$this->invoiceStatus = $invoiceStatus;
	}

	public function setIsCustoms($isCustoms)
	{
		$this->isCustoms = $isCustoms;
	}

	public function setIsFolt($isFolt)
	{
		$this->isFolt = $isFolt;
	}

	public function setIsPreSale($isPreSale)
	{
		$this->isPreSale = $isPreSale;
	}

	public function setIsRefundable($isRefundable)
	{
		$this->isRefundable = $isRefundable;
	}

	public function setLackOfWeightClaim($lackOfWeightClaim)
	{
		$this->lackOfWeightClaim = $lackOfWeightClaim;
	}

	public function setMaiJiaZiTi($maiJiaZiTi)
	{
		$this->maiJiaZiTi = $maiJiaZiTi;
	}

	public function setMarketPrice($marketPrice)
	{
		$this->marketPrice = $marketPrice;
	}

	public function setOrderLimit($orderLimit)
	{
		$this->orderLimit = $orderLimit;
	}

	public function setOriginCountryId($originCountryId)
	{
		$this->originCountryId = $originCountryId;
	}

	public function setOutGoodsId($outGoodsId)
	{
		$this->outGoodsId = $outGoodsId;
	}

	public function setOutSourceGoodsId($outSourceGoodsId)
	{
		$this->outSourceGoodsId = $outSourceGoodsId;
	}

	public function setOutSourceType($outSourceType)
	{
		$this->outSourceType = $outSourceType;
	}

	public function setOverseaGoods($overseaGoods)
	{
		$this->overseaGoods = $overseaGoods;
	}

	public function setOverseaType($overseaType)
	{
		$this->overseaType = $overseaType;
	}

	public function setPreSaleTime($preSaleTime)
	{
		$this->preSaleTime = $preSaleTime;
	}

	public function setQuanGuoLianBao($quanGuoLianBao)
	{
		$this->quanGuoLianBao = $quanGuoLianBao;
	}

	public function setSecondHand($secondHand)
	{
		$this->secondHand = $secondHand;
	}

	public function setShangMenAnZhuang($shangMenAnZhuang)
	{
		$this->shangMenAnZhuang = $shangMenAnZhuang;
	}

	public function setShipmentLimitSecond($shipmentLimitSecond)
	{
		$this->shipmentLimitSecond = $shipmentLimitSecond;
	}

	public function setSizeSpecId($sizeSpecId)
	{
		$this->sizeSpecId = $sizeSpecId;
	}

	public function setSkuList($skuList)
	{
		$this->skuList = $skuList;
	}

	public function setSkuType($skuType)
	{
		$this->skuType = $skuType;
	}

	public function setSongHuoAnZhuang($songHuoAnZhuang)
	{
		$this->songHuoAnZhuang = $songHuoAnZhuang;
	}

	public function setSongHuoRuHu($songHuoRuHu)
	{
		$this->songHuoRuHu = $songHuoRuHu;
	}

	public function setTinyName($tinyName)
	{
		$this->tinyName = $tinyName;
	}

	public function setWarehouse($warehouse)
	{
		$this->warehouse = $warehouse;
	}

	public function setWarmTips($warmTips)
	{
		$this->warmTips = $warmTips;
	}

	public function setZhiHuanBuXiu($zhiHuanBuXiu)
	{
		$this->zhiHuanBuXiu = $zhiHuanBuXiu;
	}

	public function setDeliveryType($deliveryType)
	{
		$this->deliveryType = $deliveryType;
	}

	public function setIsGroupPreSale($isGroupPreSale)
	{
		$this->isGroupPreSale = $isGroupPreSale;
	}

}

class PddGoodsAddRequest_CarouselVideoItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "file_id")
	*/
	private $fileId;

	/**
	* @JsonProperty(String, "video_url")
	*/
	private $videoUrl;

	public function setFileId($fileId)
	{
		$this->fileId = $fileId;
	}

	public function setVideoUrl($videoUrl)
	{
		$this->videoUrl = $videoUrl;
	}

}

class PddGoodsAddRequest_ElecGoodsAttributes extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "begin_time")
	*/
	private $beginTime;

	/**
	* @JsonProperty(Integer, "days_time")
	*/
	private $daysTime;

	/**
	* @JsonProperty(Long, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(Integer, "time_type")
	*/
	private $timeType;

	public function setBeginTime($beginTime)
	{
		$this->beginTime = $beginTime;
	}

	public function setDaysTime($daysTime)
	{
		$this->daysTime = $daysTime;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setTimeType($timeType)
	{
		$this->timeType = $timeType;
	}

}

class PddGoodsAddRequest_GoodsPropertiesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "group_id")
	*/
	private $groupId;

	/**
	* @JsonProperty(String, "img_url")
	*/
	private $imgUrl;

	/**
	* @JsonProperty(String, "note")
	*/
	private $note;

	/**
	* @JsonProperty(Long, "parent_spec_id")
	*/
	private $parentSpecId;

	/**
	* @JsonProperty(Long, "ref_pid")
	*/
	private $refPid;

	/**
	* @JsonProperty(Long, "spec_id")
	*/
	private $specId;

	/**
	* @JsonProperty(Long, "template_pid")
	*/
	private $templatePid;

	/**
	* @JsonProperty(String, "value")
	*/
	private $value;

	/**
	* @JsonProperty(String, "value_unit")
	*/
	private $valueUnit;

	/**
	* @JsonProperty(Long, "vid")
	*/
	private $vid;

	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

	public function setImgUrl($imgUrl)
	{
		$this->imgUrl = $imgUrl;
	}

	public function setNote($note)
	{
		$this->note = $note;
	}

	public function setParentSpecId($parentSpecId)
	{
		$this->parentSpecId = $parentSpecId;
	}

	public function setRefPid($refPid)
	{
		$this->refPid = $refPid;
	}

	public function setSpecId($specId)
	{
		$this->specId = $specId;
	}

	public function setTemplatePid($templatePid)
	{
		$this->templatePid = $templatePid;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setValueUnit($valueUnit)
	{
		$this->valueUnit = $valueUnit;
	}

	public function setVid($vid)
	{
		$this->vid = $vid;
	}

}

class PddGoodsAddRequest_GoodsTradeAttr extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "advances_days")
	*/
	private $advancesDays;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_GoodsTradeAttrBookingNotes, "booking_notes")
	*/
	private $bookingNotes;

	/**
	* @JsonProperty(Integer, "life_span")
	*/
	private $lifeSpan;

	public function setAdvancesDays($advancesDays)
	{
		$this->advancesDays = $advancesDays;
	}

	public function setBookingNotes($bookingNotes)
	{
		$this->bookingNotes = $bookingNotes;
	}

	public function setLifeSpan($lifeSpan)
	{
		$this->lifeSpan = $lifeSpan;
	}

}

class PddGoodsAddRequest_GoodsTradeAttrBookingNotes extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "url")
	*/
	private $url;

	public function setUrl($url)
	{
		$this->url = $url;
	}

}

class PddGoodsAddRequest_GoodsTravelAttr extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Boolean, "need_tourist")
	*/
	private $needTourist;

	/**
	* @JsonProperty(Integer, "type")
	*/
	private $type;

	public function setNeedTourist($needTourist)
	{
		$this->needTourist = $needTourist;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

}

class PddGoodsAddRequest_OverseaGoods extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "bonded_warehouse_key")
	*/
	private $bondedWarehouseKey;

	/**
	* @JsonProperty(Integer, "consumption_tax_rate")
	*/
	private $consumptionTaxRate;

	/**
	* @JsonProperty(String, "customs_broker")
	*/
	private $customsBroker;

	/**
	* @JsonProperty(String, "hs_code")
	*/
	private $hsCode;

	/**
	* @JsonProperty(Integer, "value_added_tax_rate")
	*/
	private $valueAddedTaxRate;

	public function setBondedWarehouseKey($bondedWarehouseKey)
	{
		$this->bondedWarehouseKey = $bondedWarehouseKey;
	}

	public function setConsumptionTaxRate($consumptionTaxRate)
	{
		$this->consumptionTaxRate = $consumptionTaxRate;
	}

	public function setCustomsBroker($customsBroker)
	{
		$this->customsBroker = $customsBroker;
	}

	public function setHsCode($hsCode)
	{
		$this->hsCode = $hsCode;
	}

	public function setValueAddedTaxRate($valueAddedTaxRate)
	{
		$this->valueAddedTaxRate = $valueAddedTaxRate;
	}

}

class PddGoodsAddRequest_SkuListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "is_onsale")
	*/
	private $isOnsale;

	/**
	* @JsonProperty(Long, "length")
	*/
	private $length;

	/**
	* @JsonProperty(Long, "limit_quantity")
	*/
	private $limitQuantity;

	/**
	* @JsonProperty(Long, "multi_price")
	*/
	private $multiPrice;

	/**
	* @JsonProperty(String, "out_sku_sn")
	*/
	private $outSkuSn;

	/**
	* @JsonProperty(String, "out_source_sku_id")
	*/
	private $outSourceSkuId;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_SkuListItemOverseaSku, "oversea_sku")
	*/
	private $overseaSku;

	/**
	* @JsonProperty(Long, "price")
	*/
	private $price;

	/**
	* @JsonProperty(Long, "quantity")
	*/
	private $quantity;

	/**
	* @JsonProperty(String, "spec_id_list")
	*/
	private $specIdList;

	/**
	* @JsonProperty(String, "thumb_url")
	*/
	private $thumbUrl;

	/**
	* @JsonProperty(Long, "weight")
	*/
	private $weight;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsAddRequest_SkuListItemSkuPropertiesItem>, "sku_properties")
	*/
	private $skuProperties;

	public function setIsOnsale($isOnsale)
	{
		$this->isOnsale = $isOnsale;
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function setLimitQuantity($limitQuantity)
	{
		$this->limitQuantity = $limitQuantity;
	}

	public function setMultiPrice($multiPrice)
	{
		$this->multiPrice = $multiPrice;
	}

	public function setOutSkuSn($outSkuSn)
	{
		$this->outSkuSn = $outSkuSn;
	}

	public function setOutSourceSkuId($outSourceSkuId)
	{
		$this->outSourceSkuId = $outSourceSkuId;
	}

	public function setOverseaSku($overseaSku)
	{
		$this->overseaSku = $overseaSku;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function setSpecIdList($specIdList)
	{
		$this->specIdList = $specIdList;
	}

	public function setThumbUrl($thumbUrl)
	{
		$this->thumbUrl = $thumbUrl;
	}

	public function setWeight($weight)
	{
		$this->weight = $weight;
	}

	public function setSkuProperties($skuProperties)
	{
		$this->skuProperties = $skuProperties;
	}

}

class PddGoodsAddRequest_SkuListItemOverseaSku extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "measurement_code")
	*/
	private $measurementCode;

	/**
	* @JsonProperty(String, "specifications")
	*/
	private $specifications;

	/**
	* @JsonProperty(Integer, "taxation")
	*/
	private $taxation;

	public function setMeasurementCode($measurementCode)
	{
		$this->measurementCode = $measurementCode;
	}

	public function setSpecifications($specifications)
	{
		$this->specifications = $specifications;
	}

	public function setTaxation($taxation)
	{
		$this->taxation = $taxation;
	}

}

class PddGoodsAddRequest_SkuListItemSkuPropertiesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "punit")
	*/
	private $punit;

	/**
	* @JsonProperty(Long, "ref_pid")
	*/
	private $refPid;

	/**
	* @JsonProperty(String, "value")
	*/
	private $value;

	/**
	* @JsonProperty(Long, "vid")
	*/
	private $vid;

	public function setPunit($punit)
	{
		$this->punit = $punit;
	}

	public function setRefPid($refPid)
	{
		$this->refPid = $refPid;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setVid($vid)
	{
		$this->vid = $vid;
	}

}
