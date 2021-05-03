<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreativeDeleteRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "unitCreativeId")
	*/
	private $unitCreativeId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "unitCreativeId", $this->unitCreativeId);

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
		return "pdd.ad.api.unit.creative.delete";
	}

	public function setUnitCreativeId($unitCreativeId)
	{
		$this->unitCreativeId = $unitCreativeId;
	}

}
