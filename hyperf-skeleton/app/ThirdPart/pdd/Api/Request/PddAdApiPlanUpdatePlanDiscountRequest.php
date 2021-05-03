<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanUpdatePlanDiscountRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanUpdatePlanDiscountRequest_PlanDiscount, "planDiscount")
	*/
	private $planDiscount;

	/**
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "planDiscount", $this->planDiscount);
		$this->setUserParam($params, "planId", $this->planId);

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
		return "pdd.ad.api.plan.update.plan.discount";
	}

	public function setPlanDiscount($planDiscount)
	{
		$this->planDiscount = $planDiscount;
	}

	public function setPlanId($planId)
	{
		$this->planId = $planId;
	}

}

class PddAdApiPlanUpdatePlanDiscountRequest_PlanDiscount extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanUpdatePlanDiscountRequest_PlanDiscountDiscountsItem>, "discounts")
	*/
	private $discounts;

	public function setDiscounts($discounts)
	{
		$this->discounts = $discounts;
	}

}

class PddAdApiPlanUpdatePlanDiscountRequest_PlanDiscountDiscountsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "index")
	*/
	private $index;

	/**
	* @JsonProperty(Integer, "rate")
	*/
	private $rate;

	public function setIndex($index)
	{
		$this->index = $index;
	}

	public function setRate($rate)
	{
		$this->rate = $rate;
	}

}
