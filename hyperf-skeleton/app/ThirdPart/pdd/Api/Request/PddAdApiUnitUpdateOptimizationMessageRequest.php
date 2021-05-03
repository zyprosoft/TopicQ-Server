<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitUpdateOptimizationMessageRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitUpdateOptimizationMessageRequest_OptimizationMessage, "optimizationMessage")
	*/
	private $optimizationMessage;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adId", $this->adId);
		$this->setUserParam($params, "optimizationMessage", $this->optimizationMessage);

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
		return "pdd.ad.api.unit.update.optimization.message";
	}

	public function setAdId($adId)
	{
		$this->adId = $adId;
	}

	public function setOptimizationMessage($optimizationMessage)
	{
		$this->optimizationMessage = $optimizationMessage;
	}

}

class PddAdApiUnitUpdateOptimizationMessageRequest_OptimizationMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "accumulationBid")
	*/
	private $accumulationBid;

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

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitUpdateOptimizationMessageRequest_OptimizationMessageOptionalOptimizationBidMessageListItem>, "optionalOptimizationBidMessageList")
	*/
	private $optionalOptimizationBidMessageList;

	public function setAccumulationBid($accumulationBid)
	{
		$this->accumulationBid = $accumulationBid;
	}

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

	public function setOptionalOptimizationBidMessageList($optionalOptimizationBidMessageList)
	{
		$this->optionalOptimizationBidMessageList = $optionalOptimizationBidMessageList;
	}

}

class PddAdApiUnitUpdateOptimizationMessageRequest_OptimizationMessageOptionalOptimizationBidMessageListItem extends PopBaseJsonEntity
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

	public function setOptimizationBid($optimizationBid)
	{
		$this->optimizationBid = $optimizationBid;
	}

	public function setOptimizationGoal($optimizationGoal)
	{
		$this->optimizationGoal = $optimizationGoal;
	}

}
