<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDeleteGoodsCommitRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Long>, "goods_ids")
	*/
	private $goodsIds;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_ids", $this->goodsIds);

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
		return "pdd.delete.goods.commit";
	}

	public function setGoodsIds($goodsIds)
	{
		$this->goodsIds = $goodsIds;
	}

}
