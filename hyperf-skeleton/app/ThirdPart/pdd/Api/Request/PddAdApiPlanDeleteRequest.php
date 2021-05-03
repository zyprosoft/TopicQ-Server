<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanDeleteRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

	/**
	* @JsonProperty(Integer, "scenesType")
	*/
	private $scenesType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "planId", $this->planId);
		$this->setUserParam($params, "scenesType", $this->scenesType);

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
		return "pdd.ad.api.plan.delete";
	}

	public function setPlanId($planId)
	{
		$this->planId = $planId;
	}

	public function setScenesType($scenesType)
	{
		$this->scenesType = $scenesType;
	}

}
