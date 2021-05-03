<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudprintCustomaresGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "template_id")
	*/
	private $templateId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "template_id", $this->templateId);

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
		return "pdd.cloudprint.customares.get";
	}

	public function setTemplateId($templateId)
	{
		$this->templateId = $templateId;
	}

}
