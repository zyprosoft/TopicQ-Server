<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitBidUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitBidUpdateRequest_AdUnitBidsItem>, "adUnitBids")
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
		return "pdd.ad.api.unit.bid.update";
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

class PddAdApiUnitBidUpdateRequest_AdUnitBidsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "bidId")
	*/
	private $bidId;

	/**
	* @JsonProperty(Long, "bidValue")
	*/
	private $bidValue;

	public function setBidId($bidId)
	{
		$this->bidId = $bidId;
	}

	public function setBidValue($bidValue)
	{
		$this->bidValue = $bidValue;
	}

}
