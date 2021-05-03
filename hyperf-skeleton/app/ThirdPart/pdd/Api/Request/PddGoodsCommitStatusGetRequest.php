<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsCommitStatusGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Long>, "goods_commit_id_list")
	*/
	private $goodsCommitIdList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "goods_commit_id_list", $this->goodsCommitIdList);

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
		return "pdd.goods.commit.status.get";
	}

	public function setGoodsCommitIdList($goodsCommitIdList)
	{
		$this->goodsCommitIdList = $goodsCommitIdList;
	}

}
