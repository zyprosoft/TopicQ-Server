<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiGoodsQueryPageRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "goodsName")
	*/
	private $goodsName;

	/**
	* @JsonProperty(Integer, "pageNumber")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "pageSize")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goodsName", $this->goodsName);
		$this->setUserParam($params, "pageNumber", $this->pageNumber);
		$this->setUserParam($params, "pageSize", $this->pageSize);
		$this->setUserParam($params, "planId", $this->planId);

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
		return "pdd.ad.api.goods.query.page";
	}

	public function setGoodsName($goodsName)
	{
		$this->goodsName = $goodsName;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setPlanId($planId)
	{
		$this->planId = $planId;
	}

}
