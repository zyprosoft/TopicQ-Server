<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanQueryCanUpdateMaxCostRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

	protected function setUserParams(&$params)
	{
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
		return "pdd.ad.api.plan.query.can.update.max.cost";
	}

	public function setPlanId($planId)
	{
		$this->planId = $planId;
	}

}
