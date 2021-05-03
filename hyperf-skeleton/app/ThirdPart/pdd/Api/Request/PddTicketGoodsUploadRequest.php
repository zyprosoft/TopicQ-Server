<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTicketGoodsUploadRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<String>, "carousel_gallery")
	*/
	private $carouselGallery;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketGoodsUploadRequest_CarouselVideoItem>, "carousel_video")
	*/
	private $carouselVideo;

	/**
	* @JsonProperty(Long, "cat_id")
	*/
	private $catId;

	/**
	* @JsonProperty(Integer, "code_mode")
	*/
	private $codeMode;

	/**
	* @JsonProperty(List<String>, "detail_gallery")
	*/
	private $detailGallery;

	/**
	* @JsonProperty(Long, "goods_commit_id")
	*/
	private $goodsCommitId;

	/**
	* @JsonProperty(String, "goods_desc")
	*/
	private $goodsDesc;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(String, "goods_name")
	*/
	private $goodsName;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketGoodsUploadRequest_GoodsPropertiesItem>, "goods_properties")
	*/
	private $goodsProperties;

	/**
	* @JsonProperty(Integer, "is_submit")
	*/
	private $isSubmit;

	/**
	* @JsonProperty(Long, "market_price")
	*/
	private $marketPrice;

	/**
	* @JsonProperty(String, "out_goods_sn")
	*/
	private $outGoodsSn;

	/**
	* @JsonProperty(String, "reserve_limit_rule")
	*/
	private $reserveLimitRule;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketGoodsUploadRequest_SkuListItem>, "sku_list")
	*/
	private $skuList;

	/**
	* @JsonProperty(Integer, "sku_type")
	*/
	private $skuType;

	/**
	* @JsonProperty(Integer, "sync_goods_operate")
	*/
	private $syncGoodsOperate;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "carousel_gallery", $this->carouselGallery);
		$this->setUserParam($params, "carousel_video", $this->carouselVideo);
		$this->setUserParam($params, "cat_id", $this->catId);
		$this->setUserParam($params, "code_mode", $this->codeMode);
		$this->setUserParam($params, "detail_gallery", $this->detailGallery);
		$this->setUserParam($params, "goods_commit_id", $this->goodsCommitId);
		$this->setUserParam($params, "goods_desc", $this->goodsDesc);
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "goods_name", $this->goodsName);
		$this->setUserParam($params, "goods_properties", $this->goodsProperties);
		$this->setUserParam($params, "is_submit", $this->isSubmit);
		$this->setUserParam($params, "market_price", $this->marketPrice);
		$this->setUserParam($params, "out_goods_sn", $this->outGoodsSn);
		$this->setUserParam($params, "reserve_limit_rule", $this->reserveLimitRule);
		$this->setUserParam($params, "sku_list", $this->skuList);
		$this->setUserParam($params, "sku_type", $this->skuType);
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
		return "pdd.ticket.goods.upload";
	}

	public function setCarouselGallery($carouselGallery)
	{
		$this->carouselGallery = $carouselGallery;
	}

	public function setCarouselVideo($carouselVideo)
	{
		$this->carouselVideo = $carouselVideo;
	}

	public function setCatId($catId)
	{
		$this->catId = $catId;
	}

	public function setCodeMode($codeMode)
	{
		$this->codeMode = $codeMode;
	}

	public function setDetailGallery($detailGallery)
	{
		$this->detailGallery = $detailGallery;
	}

	public function setGoodsCommitId($goodsCommitId)
	{
		$this->goodsCommitId = $goodsCommitId;
	}

	public function setGoodsDesc($goodsDesc)
	{
		$this->goodsDesc = $goodsDesc;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setGoodsName($goodsName)
	{
		$this->goodsName = $goodsName;
	}

	public function setGoodsProperties($goodsProperties)
	{
		$this->goodsProperties = $goodsProperties;
	}

	public function setIsSubmit($isSubmit)
	{
		$this->isSubmit = $isSubmit;
	}

	public function setMarketPrice($marketPrice)
	{
		$this->marketPrice = $marketPrice;
	}

	public function setOutGoodsSn($outGoodsSn)
	{
		$this->outGoodsSn = $outGoodsSn;
	}

	public function setReserveLimitRule($reserveLimitRule)
	{
		$this->reserveLimitRule = $reserveLimitRule;
	}

	public function setSkuList($skuList)
	{
		$this->skuList = $skuList;
	}

	public function setSkuType($skuType)
	{
		$this->skuType = $skuType;
	}

	public function setSyncGoodsOperate($syncGoodsOperate)
	{
		$this->syncGoodsOperate = $syncGoodsOperate;
	}

}

class PddTicketGoodsUploadRequest_CarouselVideoItem extends PopBaseJsonEntity
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

class PddTicketGoodsUploadRequest_GoodsPropertiesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

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

class PddTicketGoodsUploadRequest_SkuListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketGoodsUploadRequest_SkuListItemChildSkusItem>, "child_skus")
	*/
	private $childSkus;

	/**
	* @JsonProperty(Long, "group_price")
	*/
	private $groupPrice;

	/**
	* @JsonProperty(Integer, "is_onsale")
	*/
	private $isOnsale;

	/**
	* @JsonProperty(String, "out_sku_sn")
	*/
	private $outSkuSn;

	/**
	* @JsonProperty(Long, "quantity_delta")
	*/
	private $quantityDelta;

	/**
	* @JsonProperty(String, "rule_id")
	*/
	private $ruleId;

	/**
	* @JsonProperty(Long, "single_price")
	*/
	private $singlePrice;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	/**
	* @JsonProperty(List<Long>, "spec_id_list")
	*/
	private $specIdList;

	/**
	* @JsonProperty(String, "thumb_url")
	*/
	private $thumbUrl;

	public function setChildSkus($childSkus)
	{
		$this->childSkus = $childSkus;
	}

	public function setGroupPrice($groupPrice)
	{
		$this->groupPrice = $groupPrice;
	}

	public function setIsOnsale($isOnsale)
	{
		$this->isOnsale = $isOnsale;
	}

	public function setOutSkuSn($outSkuSn)
	{
		$this->outSkuSn = $outSkuSn;
	}

	public function setQuantityDelta($quantityDelta)
	{
		$this->quantityDelta = $quantityDelta;
	}

	public function setRuleId($ruleId)
	{
		$this->ruleId = $ruleId;
	}

	public function setSinglePrice($singlePrice)
	{
		$this->singlePrice = $singlePrice;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

	public function setSpecIdList($specIdList)
	{
		$this->specIdList = $specIdList;
	}

	public function setThumbUrl($thumbUrl)
	{
		$this->thumbUrl = $thumbUrl;
	}

}

class PddTicketGoodsUploadRequest_SkuListItemChildSkusItem extends PopBaseJsonEntity
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
