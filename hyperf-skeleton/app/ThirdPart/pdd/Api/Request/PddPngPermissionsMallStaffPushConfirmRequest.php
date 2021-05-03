<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPngPermissionsMallStaffPushConfirmRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "from_mall_id")
	*/
	private $fromMallId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "from_mall_id", $this->fromMallId);

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
		return "pdd.png.permissions.mall.staff.push.confirm";
	}

	public function setFromMallId($fromMallId)
	{
		$this->fromMallId = $fromMallId;
	}

}
