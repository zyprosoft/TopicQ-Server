<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreativeQueryFlowRateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adId", $this->adId);

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
		return "pdd.ad.api.unit.creative.query.flow.rate";
	}

	public function setAdId($adId)
	{
		$this->adId = $adId;
	}

}
