<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPngMallStaffBatchSycnRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Long>, "staff_ids")
	*/
	private $staffIds;

	/**
	* @JsonProperty(Long, "to_mall_id")
	*/
	private $toMallId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "staff_ids", $this->staffIds);
		$this->setUserParam($params, "to_mall_id", $this->toMallId);

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
		return "pdd.png.mall.staff.batch.sycn";
	}

	public function setStaffIds($staffIds)
	{
		$this->staffIds = $staffIds;
	}

	public function setToMallId($toMallId)
	{
		$this->toMallId = $toMallId;
	}

}
