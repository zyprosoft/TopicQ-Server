<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "outer_id")
	*/
	private $outerId;

	/**
	* @JsonProperty(Integer, "is_onsale")
	*/
	private $isOnsale;

	/**
	* @JsonProperty(String, "goods_name")
	*/
	private $goodsName;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(String, "outer_goods_id")
	*/
	private $outerGoodsId;

	/**
	* @JsonProperty(Long, "cost_template_id")
	*/
	private $costTemplateId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "outer_id", $this->outerId);
		$this->setUserParam($params, "is_onsale", $this->isOnsale);
		$this->setUserParam($params, "goods_name", $this->goodsName);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "outer_goods_id", $this->outerGoodsId);
		$this->setUserParam($params, "cost_template_id", $this->costTemplateId);

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
		return "pdd.goods.list.get";
	}

	public function setOuterId($outerId)
	{
		$this->outerId = $outerId;
	}

	public function setIsOnsale($isOnsale)
	{
		$this->isOnsale = $isOnsale;
	}

	public function setGoodsName($goodsName)
	{
		$this->goodsName = $goodsName;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setOuterGoodsId($outerGoodsId)
	{
		$this->outerGoodsId = $outerGoodsId;
	}

	public function setCostTemplateId($costTemplateId)
	{
		$this->costTemplateId = $costTemplateId;
	}

}
