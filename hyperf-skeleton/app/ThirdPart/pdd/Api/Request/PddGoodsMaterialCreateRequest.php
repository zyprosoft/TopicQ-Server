<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsMaterialCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "content")
	*/
	private $content;

	/**
	* @JsonProperty(Long, "file_id")
	*/
	private $fileId;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(Integer, "material_type")
	*/
	private $materialType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "content", $this->content);
		$this->setUserParam($params, "file_id", $this->fileId);
		$this->setUserParam($params, "goods_id", $this->goodsId);
		$this->setUserParam($params, "material_type", $this->materialType);

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
		return "pdd.goods.material.create";
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setFileId($fileId)
	{
		$this->fileId = $fileId;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setMaterialType($materialType)
	{
		$this->materialType = $materialType;
	}

}
