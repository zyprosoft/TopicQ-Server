<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsOptGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "parent_opt_id")
	*/
	private $parentOptId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "parent_opt_id", $this->parentOptId);

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
		return "pdd.goods.opt.get";
	}

	public function setParentOptId($parentOptId)
	{
		$this->parentOptId = $parentOptId;
	}

}
