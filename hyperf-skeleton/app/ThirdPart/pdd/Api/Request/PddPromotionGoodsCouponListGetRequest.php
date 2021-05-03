<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionGoodsCouponListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Integer, "query_range")
	*/
	private $queryRange;

	/**
	* @JsonProperty(Integer, "batch_status")
	*/
	private $batchStatus;

	/**
	* @JsonProperty(Integer, "sort_by")
	*/
	private $sortBy;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "query_range", $this->queryRange);
		$this->setUserParam($params, "batch_status", $this->batchStatus);
		$this->setUserParam($params, "sort_by", $this->sortBy);

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
		return "pdd.promotion.goods.coupon.list.get";
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setQueryRange($queryRange)
	{
		$this->queryRange = $queryRange;
	}

	public function setBatchStatus($batchStatus)
	{
		$this->batchStatus = $batchStatus;
	}

	public function setSortBy($sortBy)
	{
		$this->sortBy = $sortBy;
	}

}
