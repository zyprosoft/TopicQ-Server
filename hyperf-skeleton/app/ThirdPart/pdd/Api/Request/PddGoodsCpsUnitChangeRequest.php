<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsCpsUnitChangeRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "coupon_end_time")
	*/
	private $couponEndTime;

	/**
	* @JsonProperty(Long, "coupon_id")
	*/
	private $couponId;

	/**
	* @JsonProperty(String, "coupon_sn")
	*/
	private $couponSn;

	/**
	* @JsonProperty(String, "coupon_start_time")
	*/
	private $couponStartTime;

	/**
	* @JsonProperty(Integer, "discount")
	*/
	private $discount;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Long, "init_quantity")
	*/
	private $initQuantity;

	/**
	* @JsonProperty(Integer, "rate")
	*/
	private $rate;

	/**
	* @JsonProperty(Long, "remain_quantity")
	*/
	private $remainQuantity;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "coupon_end_time", $this->couponEndTime);
		$this->setUserParam($params, "coupon_id", $this->couponId);
		$this->setUserParam($params, "coupon_sn", $this->couponSn);
		$this->setUserParam($params, "coupon_start_time", $this->couponStartTime);
		$this->setUserParam($params, "discount", $this->discount);
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "init_quantity", $this->initQuantity);
		$this->setUserParam($params, "rate", $this->rate);
		$this->setUserParam($params, "remain_quantity", $this->remainQuantity);

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
		return "pdd.goods.cps.unit.change";
	}

	public function setCouponEndTime($couponEndTime)
	{
		$this->couponEndTime = $couponEndTime;
	}

	public function setCouponId($couponId)
	{
		$this->couponId = $couponId;
	}

	public function setCouponSn($couponSn)
	{
		$this->couponSn = $couponSn;
	}

	public function setCouponStartTime($couponStartTime)
	{
		$this->couponStartTime = $couponStartTime;
	}

	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setInitQuantity($initQuantity)
	{
		$this->initQuantity = $initQuantity;
	}

	public function setRate($rate)
	{
		$this->rate = $rate;
	}

	public function setRemainQuantity($remainQuantity)
	{
		$this->remainQuantity = $remainQuantity;
	}

}
