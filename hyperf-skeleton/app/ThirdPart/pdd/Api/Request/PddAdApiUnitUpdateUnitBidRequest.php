<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitUpdateUnitBidRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	/**
	* @JsonProperty(Long, "bid")
	*/
	private $bid;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adId", $this->adId);
		$this->setUserParam($params, "bid", $this->bid);

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
		return "pdd.ad.api.unit.update.unit.bid";
	}

	public function setAdId($adId)
	{
		$this->adId = $adId;
	}

	public function setBid($bid)
	{
		$this->bid = $bid;
	}

}
