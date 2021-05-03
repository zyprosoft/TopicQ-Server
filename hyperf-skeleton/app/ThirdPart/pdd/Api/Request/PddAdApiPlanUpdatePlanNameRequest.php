<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanUpdatePlanNameRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

	/**
	* @JsonProperty(String, "planName")
	*/
	private $planName;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "planId", $this->planId);
		$this->setUserParam($params, "planName", $this->planName);

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
		return "pdd.ad.api.plan.update.plan.name";
	}

	public function setPlanId($planId)
	{
		$this->planId = $planId;
	}

	public function setPlanName($planName)
	{
		$this->planName = $planName;
	}

}
