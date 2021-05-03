<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddMallInfoGroupRemoveStoreGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "group_id")
	*/
	private $groupId;

	/**
	* @JsonProperty(List<Long>, "store_id_list")
	*/
	private $storeIdList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "group_id", $this->groupId);
		$this->setUserParam($params, "store_id_list", $this->storeIdList);

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
		return "pdd.mall.info.group.remove.store.get";
	}

	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
	}

	public function setStoreIdList($storeIdList)
	{
		$this->storeIdList = $storeIdList;
	}

}
