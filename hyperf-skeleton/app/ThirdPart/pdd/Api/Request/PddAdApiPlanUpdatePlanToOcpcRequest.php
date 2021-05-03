<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanUpdatePlanToOcpcRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanUpdatePlanToOcpcRequest_AdUnitUpdateOcpcMessageListItem>, "adUnitUpdateOcpcMessageList")
	*/
	private $adUnitUpdateOcpcMessageList;

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
		$this->setUserParam($params, "adUnitUpdateOcpcMessageList", $this->adUnitUpdateOcpcMessageList);
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
		return "pdd.ad.api.plan.update.plan.to.ocpc";
	}

	public function setAdUnitUpdateOcpcMessageList($adUnitUpdateOcpcMessageList)
	{
		$this->adUnitUpdateOcpcMessageList = $adUnitUpdateOcpcMessageList;
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

class PddAdApiPlanUpdatePlanToOcpcRequest_AdUnitUpdateOcpcMessageListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanUpdatePlanToOcpcRequest_AdUnitUpdateOcpcMessageListItemOptimizationMessage, "optimizationMessage")
	*/
	private $optimizationMessage;

	public function setAdId($adId)
	{
		$this->adId = $adId;
	}

	public function setOptimizationMessage($optimizationMessage)
	{
		$this->optimizationMessage = $optimizationMessage;
	}

}

class PddAdApiPlanUpdatePlanToOcpcRequest_AdUnitUpdateOcpcMessageListItemOptimizationMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "optimizationBid")
	*/
	private $optimizationBid;

	/**
	* @JsonProperty(Integer, "optimizationGoal")
	*/
	private $optimizationGoal;

	/**
	* @JsonProperty(Integer, "optimizationMethod")
	*/
	private $optimizationMethod;

	public function setOptimizationBid($optimizationBid)
	{
		$this->optimizationBid = $optimizationBid;
	}

	public function setOptimizationGoal($optimizationGoal)
	{
		$this->optimizationGoal = $optimizationGoal;
	}

	public function setOptimizationMethod($optimizationMethod)
	{
		$this->optimizationMethod = $optimizationMethod;
	}

}
