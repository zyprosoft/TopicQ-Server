<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsLogisticsSerTemplateDeleteRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "template_id")
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
		return "pdd.goods.logistics.ser.template.delete";
	}

	public function setTemplateId($templateId)
	{
		$this->templateId = $templateId;
	}

}
