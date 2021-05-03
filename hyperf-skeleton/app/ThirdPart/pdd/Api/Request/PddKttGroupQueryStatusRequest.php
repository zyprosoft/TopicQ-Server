<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKttGroupQueryStatusRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "activity_no")
	*/
	private $activityNo;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "activity_no", $this->activityNo);

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
		return "pdd.ktt.group.query.status";
	}

	public function setActivityNo($activityNo)
	{
		$this->activityNo = $activityNo;
	}

}
