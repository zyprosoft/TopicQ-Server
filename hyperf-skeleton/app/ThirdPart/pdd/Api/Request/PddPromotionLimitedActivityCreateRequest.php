<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionLimitedActivityCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddPromotionLimitedActivityCreateRequest_RequestItem>, "request")
	*/
	private $request;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "request", $this->request);

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
		return "pdd.promotion.limited.activity.create";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddPromotionLimitedActivityCreateRequest_RequestItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "activity_name")
	*/
	private $activityName;

	/**
	* @JsonProperty(Integer, "activity_type")
	*/
	private $activityType;

	/**
	* @JsonProperty(Long, "discount")
	*/
	private $discount;

	/**
	* @JsonProperty(Long, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Long, "quantity")
	*/
	private $quantity;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddPromotionLimitedActivityCreateRequest_RequestItemSkuPriceListItem>, "sku_price_list")
	*/
	private $skuPriceList;

	/**
	* @JsonProperty(Long, "start_time")
	*/
	private $startTime;

	/**
	* @JsonProperty(Long, "user_activity_limit")
	*/
	private $userActivityLimit;

	public function setActivityName($activityName)
	{
		$this->activityName = $activityName;
	}

	public function setActivityType($activityType)
	{
		$this->activityType = $activityType;
	}

	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function setSkuPriceList($skuPriceList)
	{
		$this->skuPriceList = $skuPriceList;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

	public function setUserActivityLimit($userActivityLimit)
	{
		$this->userActivityLimit = $userActivityLimit;
	}

}

class PddPromotionLimitedActivityCreateRequest_RequestItemSkuPriceListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "activity_price")
	*/
	private $activityPrice;

	/**
	* @JsonProperty(Long, "sku_id")
	*/
	private $skuId;

	public function setActivityPrice($activityPrice)
	{
		$this->activityPrice = $activityPrice;
	}

	public function setSkuId($skuId)
	{
		$this->skuId = $skuId;
	}

}
