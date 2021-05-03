<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanUpdateMaxCostRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "maxCost")
	*/
	private $maxCost;

	/**
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "maxCost", $this->maxCost);
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
		return "pdd.ad.api.plan.update.max.cost";
	}

	public function setMaxCost($maxCost)
	{
		$this->maxCost = $maxCost;
	}

	public function setPlanId($planId)
	{
		$this->planId = $planId;
	}

}
