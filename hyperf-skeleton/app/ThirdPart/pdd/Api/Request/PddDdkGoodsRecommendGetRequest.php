<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkGoodsRecommendGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Integer>, "activity_tags")
	*/
	private $activityTags;

	/**
	* @JsonProperty(Long, "cat_id")
	*/
	private $catId;

	/**
	* @JsonProperty(Integer, "channel_type")
	*/
	private $channelType;

	/**
	* @JsonProperty(String, "custom_parameters")
	*/
	private $customParameters;

	/**
	* @JsonProperty(List<String>, "goods_sign_list")
	*/
	private $goodsSignList;

	/**
	* @JsonProperty(Integer, "limit")
	*/
	private $limit;

	/**
	* @JsonProperty(String, "list_id")
	*/
	private $listId;

	/**
	* @JsonProperty(Integer, "offset")
	*/
	private $offset;

	/**
	* @JsonProperty(String, "pid")
	*/
	private $pid;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "activity_tags", $this->activityTags);
		$this->setUserParam($params, "cat_id", $this->catId);
		$this->setUserParam($params, "channel_type", $this->channelType);
		$this->setUserParam($params, "custom_parameters", $this->customParameters);
		$this->setUserParam($params, "goods_sign_list", $this->goodsSignList);
		$this->setUserParam($params, "limit", $this->limit);
		$this->setUserParam($params, "list_id", $this->listId);
		$this->setUserParam($params, "offset", $this->offset);
		$this->setUserParam($params, "pid", $this->pid);

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
		return "pdd.ddk.goods.recommend.get";
	}

	public function setActivityTags($activityTags)
	{
		$this->activityTags = $activityTags;
	}

	public function setCatId($catId)
	{
		$this->catId = $catId;
	}

	public function setChannelType($channelType)
	{
		$this->channelType = $channelType;
	}

	public function setCustomParameters($customParameters)
	{
		$this->customParameters = $customParameters;
	}

	public function setGoodsSignList($goodsSignList)
	{
		$this->goodsSignList = $goodsSignList;
	}

	public function setLimit($limit)
	{
		$this->limit = $limit;
	}

	public function setListId($listId)
	{
		$this->listId = $listId;
	}

	public function setOffset($offset)
	{
		$this->offset = $offset;
	}

	public function setPid($pid)
	{
		$this->pid = $pid;
	}

}
