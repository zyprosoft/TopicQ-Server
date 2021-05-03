<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddMallInfoStoreDeletePostRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Long>, "store_id_list")
	*/
	private $storeIdList;

	protected function setUserParams(&$params)
	{
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
		return "pdd.mall.info.store.delete.post";
	}

	public function setStoreIdList($storeIdList)
	{
		$this->storeIdList = $storeIdList;
	}

}
