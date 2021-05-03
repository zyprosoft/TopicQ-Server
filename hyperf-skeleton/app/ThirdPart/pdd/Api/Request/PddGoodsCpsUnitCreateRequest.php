<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsCpsUnitCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsCpsUnitCreateRequest_UnitsItem>, "units")
	*/
	private $units;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "units", $this->units);

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
		return "pdd.goods.cps.unit.create";
	}

	public function setUnits($units)
	{
		$this->units = $units;
	}

}

class PddGoodsCpsUnitCreateRequest_UnitsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Long, "rate")
	*/
	private $rate;

	/**
	* @JsonProperty(Long, "coupon_id")
	*/
	private $couponId;

	/**
	* @JsonProperty(String, "coupon_start_time")
	*/
	private $couponStartTime;

	/**
	* @JsonProperty(String, "coupon_end_time")
	*/
	private $couponEndTime;

	/**
	* @JsonProperty(Long, "discount")
	*/
	private $discount;

	/**
	* @JsonProperty(Long, "init_quantity")
	*/
	private $initQuantity;

	/**
	* @JsonProperty(Long, "remain_quantity")
	*/
	private $remainQuantity;

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setRate($rate)
	{
		$this->rate = $rate;
	}

	public function setCouponId($couponId)
	{
		$this->couponId = $couponId;
	}

	public function setCouponStartTime($couponStartTime)
	{
		$this->couponStartTime = $couponStartTime;
	}

	public function setCouponEndTime($couponEndTime)
	{
		$this->couponEndTime = $couponEndTime;
	}

	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function setInitQuantity($initQuantity)
	{
		$this->initQuantity = $initQuantity;
	}

	public function setRemainQuantity($remainQuantity)
	{
		$this->remainQuantity = $remainQuantity;
	}

}
