<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkOauthGoodsSearchRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Integer>, "activity_tags")
	*/
	private $activityTags;

	/**
	* @JsonProperty(List<Integer>, "block_cats")
	*/
	private $blockCats;

	/**
	* @JsonProperty(List<Integer>, "block_cat_packages")
	*/
	private $blockCatPackages;

	/**
	* @JsonProperty(Long, "cat_id")
	*/
	private $catId;

	/**
	* @JsonProperty(String, "custom_parameters")
	*/
	private $customParameters;

	/**
	* @JsonProperty(Boolean, "force_auth_duo_id")
	*/
	private $forceAuthDuoId;

	/**
	* @JsonProperty(List<String>, "goods_sign_list")
	*/
	private $goodsSignList;

	/**
	* @JsonProperty(Boolean, "is_brand_goods")
	*/
	private $isBrandGoods;

	/**
	* @JsonProperty(String, "keyword")
	*/
	private $keyword;

	/**
	* @JsonProperty(String, "list_id")
	*/
	private $listId;

	/**
	* @JsonProperty(Integer, "merchant_type")
	*/
	private $merchantType;

	/**
	* @JsonProperty(List<Integer>, "merchant_type_list")
	*/
	private $merchantTypeList;

	/**
	* @JsonProperty(Long, "opt_id")
	*/
	private $optId;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(String, "pid")
	*/
	private $pid;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthGoodsSearchRequest_RangeListItem>, "range_list")
	*/
	private $rangeList;

	/**
	* @JsonProperty(Integer, "sort_type")
	*/
	private $sortType;

	/**
	* @JsonProperty(Boolean, "with_coupon")
	*/
	private $withCoupon;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "activity_tags", $this->activityTags);
		$this->setUserParam($params, "block_cats", $this->blockCats);
		$this->setUserParam($params, "block_cat_packages", $this->blockCatPackages);
		$this->setUserParam($params, "cat_id", $this->catId);
		$this->setUserParam($params, "custom_parameters", $this->customParameters);
		$this->setUserParam($params, "force_auth_duo_id", $this->forceAuthDuoId);
		$this->setUserParam($params, "goods_sign_list", $this->goodsSignList);
		$this->setUserParam($params, "is_brand_goods", $this->isBrandGoods);
		$this->setUserParam($params, "keyword", $this->keyword);
		$this->setUserParam($params, "list_id", $this->listId);
		$this->setUserParam($params, "merchant_type", $this->merchantType);
		$this->setUserParam($params, "merchant_type_list", $this->merchantTypeList);
		$this->setUserParam($params, "opt_id", $this->optId);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "pid", $this->pid);
		$this->setUserParam($params, "range_list", $this->rangeList);
		$this->setUserParam($params, "sort_type", $this->sortType);
		$this->setUserParam($params, "with_coupon", $this->withCoupon);

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
		return "pdd.ddk.oauth.goods.search";
	}

	public function setActivityTags($activityTags)
	{
		$this->activityTags = $activityTags;
	}

	public function setBlockCats($blockCats)
	{
		$this->blockCats = $blockCats;
	}

	public function setBlockCatPackages($blockCatPackages)
	{
		$this->blockCatPackages = $blockCatPackages;
	}

	public function setCatId($catId)
	{
		$this->catId = $catId;
	}

	public function setCustomParameters($customParameters)
	{
		$this->customParameters = $customParameters;
	}

	public function setForceAuthDuoId($forceAuthDuoId)
	{
		$this->forceAuthDuoId = $forceAuthDuoId;
	}

	public function setGoodsSignList($goodsSignList)
	{
		$this->goodsSignList = $goodsSignList;
	}

	public function setIsBrandGoods($isBrandGoods)
	{
		$this->isBrandGoods = $isBrandGoods;
	}

	public function setKeyword($keyword)
	{
		$this->keyword = $keyword;
	}

	public function setListId($listId)
	{
		$this->listId = $listId;
	}

	public function setMerchantType($merchantType)
	{
		$this->merchantType = $merchantType;
	}

	public function setMerchantTypeList($merchantTypeList)
	{
		$this->merchantTypeList = $merchantTypeList;
	}

	public function setOptId($optId)
	{
		$this->optId = $optId;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setPid($pid)
	{
		$this->pid = $pid;
	}

	public function setRangeList($rangeList)
	{
		$this->rangeList = $rangeList;
	}

	public function setSortType($sortType)
	{
		$this->sortType = $sortType;
	}

	public function setWithCoupon($withCoupon)
	{
		$this->withCoupon = $withCoupon;
	}

}

class PddDdkOauthGoodsSearchRequest_RangeListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "range_from")
	*/
	private $rangeFrom;

	/**
	* @JsonProperty(Integer, "range_id")
	*/
	private $rangeId;

	/**
	* @JsonProperty(Long, "range_to")
	*/
	private $rangeTo;

	public function setRangeFrom($rangeFrom)
	{
		$this->rangeFrom = $rangeFrom;
	}

	public function setRangeId($rangeId)
	{
		$this->rangeId = $rangeId;
	}

	public function setRangeTo($rangeTo)
	{
		$this->rangeTo = $rangeTo;
	}

}
