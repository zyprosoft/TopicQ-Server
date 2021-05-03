<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionLimitedDiscountListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Integer>, "activity_types")
	*/
	private $activityTypes;

	/**
	* @JsonProperty(List<Long>, "goods_id_list")
	*/
	private $goodsIdList;

	/**
	* @JsonProperty(Boolean, "just_count")
	*/
	private $justCount;

	/**
	* @JsonProperty(Integer, "order")
	*/
	private $order;

	/**
	* @JsonProperty(Integer, "page_no")
	*/
	private $pageNo;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(List<Integer>, "status_list")
	*/
	private $statusList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "activity_types", $this->activityTypes);
		$this->setUserParam($params, "goods_id_list", $this->goodsIdList);
		$this->setUserParam($params, "just_count", $this->justCount);
		$this->setUserParam($params, "order", $this->order);
		$this->setUserParam($params, "page_no", $this->pageNo);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "status_list", $this->statusList);

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
		return "pdd.promotion.limited.discount.list.get";
	}

	public function setActivityTypes($activityTypes)
	{
		$this->activityTypes = $activityTypes;
	}

	public function setGoodsIdList($goodsIdList)
	{
		$this->goodsIdList = $goodsIdList;
	}

	public function setJustCount($justCount)
	{
		$this->justCount = $justCount;
	}

	public function setOrder($order)
	{
		$this->order = $order;
	}

	public function setPageNo($pageNo)
	{
		$this->pageNo = $pageNo;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setStatusList($statusList)
	{
		$this->statusList = $statusList;
	}

}
