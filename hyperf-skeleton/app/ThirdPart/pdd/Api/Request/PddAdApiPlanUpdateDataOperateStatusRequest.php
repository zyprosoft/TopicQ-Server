<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanUpdateDataOperateStatusRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "dataOperateStatus")
	*/
	private $dataOperateStatus;

	/**
	* @JsonProperty(List<Long>, "planIds")
	*/
	private $planIds;

	/**
	* @JsonProperty(Integer, "scenesType")
	*/
	private $scenesType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "dataOperateStatus", $this->dataOperateStatus);
		$this->setUserParam($params, "planIds", $this->planIds);
		$this->setUserParam($params, "scenesType", $this->scenesType);

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
		return "pdd.ad.api.plan.update.data.operate.status";
	}

	public function setDataOperateStatus($dataOperateStatus)
	{
		$this->dataOperateStatus = $dataOperateStatus;
	}

	public function setPlanIds($planIds)
	{
		$this->planIds = $planIds;
	}

	public function setScenesType($scenesType)
	{
		$this->scenesType = $scenesType;
	}

}
