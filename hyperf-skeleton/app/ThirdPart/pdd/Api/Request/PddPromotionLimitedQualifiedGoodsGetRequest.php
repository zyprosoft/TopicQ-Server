<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionLimitedQualifiedGoodsGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Long>, "goods_id_list")
	*/
	private $goodsIdList;

	/**
	* @JsonProperty(Boolean, "is_valid")
	*/
	private $isValid;

	/**
	* @JsonProperty(Integer, "page_no")
	*/
	private $pageNo;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_id_list", $this->goodsIdList);
		$this->setUserParam($params, "is_valid", $this->isValid);
		$this->setUserParam($params, "page_no", $this->pageNo);
		$this->setUserParam($params, "page_size", $this->pageSize);

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
		return "pdd.promotion.limited.qualified.goods.get";
	}

	public function setGoodsIdList($goodsIdList)
	{
		$this->goodsIdList = $goodsIdList;
	}

	public function setIsValid($isValid)
	{
		$this->isValid = $isValid;
	}

	public function setPageNo($pageNo)
	{
		$this->pageNo = $pageNo;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

}
