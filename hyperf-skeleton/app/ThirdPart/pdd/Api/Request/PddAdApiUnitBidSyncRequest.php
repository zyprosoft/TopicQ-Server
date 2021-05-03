<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitBidSyncRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitBidSyncRequest_AdUnitBidsItem>, "adUnitBids")
	*/
	private $adUnitBids;

	/**
	* @JsonProperty(Integer, "bidReferenceType")
	*/
	private $bidReferenceType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adId", $this->adId);
		$this->setUserParam($params, "adUnitBids", $this->adUnitBids);
		$this->setUserParam($params, "bidReferenceType", $this->bidReferenceType);

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
		return "pdd.ad.api.unit.bid.sync";
	}

	public function setAdId($adId)
	{
		$this->adId = $adId;
	}

	public function setAdUnitBids($adUnitBids)
	{
		$this->adUnitBids = $adUnitBids;
	}

	public function setBidReferenceType($bidReferenceType)
	{
		$this->bidReferenceType = $bidReferenceType;
	}

}

class PddAdApiUnitBidSyncRequest_AdUnitBidsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitBidSyncRequest_AdUnitBidsItemAdTargetingVO, "adTargetingVO")
	*/
	private $adTargetingVO;

	/**
	* @JsonProperty(Long, "bidReferenceId")
	*/
	private $bidReferenceId;

	/**
	* @JsonProperty(Long, "bidValue")
	*/
	private $bidValue;

	/**
	* @JsonProperty(Long, "subBidReferenceId")
	*/
	private $subBidReferenceId;

	public function setAdTargetingVO($adTargetingVO)
	{
		$this->adTargetingVO = $adTargetingVO;
	}

	public function setBidReferenceId($bidReferenceId)
	{
		$this->bidReferenceId = $bidReferenceId;
	}

	public function setBidValue($bidValue)
	{
		$this->bidValue = $bidValue;
	}

	public function setSubBidReferenceId($subBidReferenceId)
	{
		$this->subBidReferenceId = $subBidReferenceId;
	}

}

class PddAdApiUnitBidSyncRequest_AdUnitBidsItemAdTargetingVO extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitBidSyncRequest_AdUnitBidsItemAdTargetingVOAdTargetingSet, "adTargetingSet")
	*/
	private $adTargetingSet;

	/**
	* @JsonProperty(String, "targetingName")
	*/
	private $targetingName;

	public function setAdTargetingSet($adTargetingSet)
	{
		$this->adTargetingSet = $adTargetingSet;
	}

	public function setTargetingName($targetingName)
	{
		$this->targetingName = $targetingName;
	}

}

class PddAdApiUnitBidSyncRequest_AdUnitBidsItemAdTargetingVOAdTargetingSet extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitBidSyncRequest_AdUnitBidsItemAdTargetingVOAdTargetingSetAreaStruct, "areaStruct")
	*/
	private $areaStruct;

	public function setAreaStruct($areaStruct)
	{
		$this->areaStruct = $areaStruct;
	}

}

class PddAdApiUnitBidSyncRequest_AdUnitBidsItemAdTargetingVOAdTargetingSetAreaStruct extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<Integer>, "areaIds")
	*/
	private $areaIds;

	public function setAreaIds($areaIds)
	{
		$this->areaIds = $areaIds;
	}

}
