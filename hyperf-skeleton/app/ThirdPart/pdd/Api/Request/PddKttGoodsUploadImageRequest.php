<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKttGoodsUploadImageRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "url")
	*/
	private $url;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "url", $this->url);

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
		return "pdd.ktt.goods.upload.image";
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

}
