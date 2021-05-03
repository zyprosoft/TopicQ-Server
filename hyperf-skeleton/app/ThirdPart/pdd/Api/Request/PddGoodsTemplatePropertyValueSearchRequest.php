<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsTemplatePropertyValueSearchRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "cat_id")
	*/
	private $catId;

	/**
	* @JsonProperty(Integer, "page_num")
	*/
	private $pageNum;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Long, "parent_vid")
	*/
	private $parentVid;

	/**
	* @JsonProperty(Long, "template_pid")
	*/
	private $templatePid;

	/**
	* @JsonProperty(String, "value")
	*/
	private $value;

	/**
	* @JsonProperty(Long, "ref_pid")
	*/
	private $refPid;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cat_id", $this->catId);
		$this->setUserParam($params, "page_num", $this->pageNum);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "parent_vid", $this->parentVid);
		$this->setUserParam($params, "template_pid", $this->templatePid);
		$this->setUserParam($params, "value", $this->value);
		$this->setUserParam($params, "ref_pid", $this->refPid);

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
		return "pdd.goods.template.property.value.search";
	}

	public function setCatId($catId)
	{
		$this->catId = $catId;
	}

	public function setPageNum($pageNum)
	{
		$this->pageNum = $pageNum;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setParentVid($parentVid)
	{
		$this->parentVid = $parentVid;
	}

	public function setTemplatePid($templatePid)
	{
		$this->templatePid = $templatePid;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setRefPid($refPid)
	{
		$this->refPid = $refPid;
	}

}
