<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionHomeCouponCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "batch_desc")
	*/
	private $batchDesc;

	/**
	* @JsonProperty(Long, "batch_start_time")
	*/
	private $batchStartTime;

	/**
	* @JsonProperty(Long, "batch_end_time")
	*/
	private $batchEndTime;

	/**
	* @JsonProperty(Long, "discount")
	*/
	private $discount;

	/**
	* @JsonProperty(Long, "min_order_amount")
	*/
	private $minOrderAmount;

	/**
	* @JsonProperty(Long, "init_quantity")
	*/
	private $initQuantity;

	/**
	* @JsonProperty(Long, "user_limit")
	*/
	private $userLimit;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "batch_desc", $this->batchDesc);
		$this->setUserParam($params, "batch_start_time", $this->batchStartTime);
		$this->setUserParam($params, "batch_end_time", $this->batchEndTime);
		$this->setUserParam($params, "discount", $this->discount);
		$this->setUserParam($params, "min_order_amount", $this->minOrderAmount);
		$this->setUserParam($params, "init_quantity", $this->initQuantity);
		$this->setUserParam($params, "user_limit", $this->userLimit);

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
		return "pdd.promotion.home.coupon.create";
	}

	public function setBatchDesc($batchDesc)
	{
		$this->batchDesc = $batchDesc;
	}

	public function setBatchStartTime($batchStartTime)
	{
		$this->batchStartTime = $batchStartTime;
	}

	public function setBatchEndTime($batchEndTime)
	{
		$this->batchEndTime = $batchEndTime;
	}

	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function setMinOrderAmount($minOrderAmount)
	{
		$this->minOrderAmount = $minOrderAmount;
	}

	public function setInitQuantity($initQuantity)
	{
		$this->initQuantity = $initQuantity;
	}

	public function setUserLimit($userLimit)
	{
		$this->userLimit = $userLimit;
	}

}
