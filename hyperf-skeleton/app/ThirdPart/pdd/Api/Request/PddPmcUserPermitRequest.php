<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPmcUserPermitRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "topics")
	*/
	private $topics;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "topics", $this->topics);

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
		return "pdd.pmc.user.permit";
	}

	public function setTopics($topics)
	{
		$this->topics = $topics;
	}

}
