<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreativeUpdateDataOperateStatusRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "dataOperateStatus")
	*/
	private $dataOperateStatus;

	/**
	* @JsonProperty(List<Long>, "unitCreativeIds")
	*/
	private $unitCreativeIds;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "dataOperateStatus", $this->dataOperateStatus);
		$this->setUserParam($params, "unitCreativeIds", $this->unitCreativeIds);

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
		return "pdd.ad.api.unit.creative.update.data.operate.status";
	}

	public function setDataOperateStatus($dataOperateStatus)
	{
		$this->dataOperateStatus = $dataOperateStatus;
	}

	public function setUnitCreativeIds($unitCreativeIds)
	{
		$this->unitCreativeIds = $unitCreativeIds;
	}

}
