<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreativeUpdateSmartCreativeRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* #JsonProperty(String, "text")
	*/
	private $text;

	/**
	* #JsonProperty(Long, "unitCreativeId")
	*/
	private $unitCreativeId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "text", $this->text);
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
		return "pdd.ad.api.unit.creative.update.smart.creative";
	}

	public function setText($text)
	{
		$this->text = $text;
	}

	public function setUnitCreativeId($unitCreativeId)
	{
		$this->unitCreativeId = $unitCreativeId;
	}

}
