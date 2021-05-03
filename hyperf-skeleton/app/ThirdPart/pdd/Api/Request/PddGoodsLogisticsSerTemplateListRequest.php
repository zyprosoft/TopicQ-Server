<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsLogisticsSerTemplateListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "template_type")
	*/
	private $templateType;

	/**
	* @JsonProperty(Integer, "start")
	*/
	private $start;

	/**
	* @JsonProperty(Integer, "length")
	*/
	private $length;

	/**
	* @JsonProperty(Integer, "query_type")
	*/
	private $queryType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "template_type", $this->templateType);
		$this->setUserParam($params, "start", $this->start);
		$this->setUserParam($params, "length", $this->length);
		$this->setUserParam($params, "query_type", $this->queryType);

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
		return "pdd.goods.logistics.ser.template.list";
	}

	public function setTemplateType($templateType)
	{
		$this->templateType = $templateType;
	}

	public function setStart($start)
	{
		$this->start = $start;
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function setQueryType($queryType)
	{
		$this->queryType = $queryType;
	}

}
