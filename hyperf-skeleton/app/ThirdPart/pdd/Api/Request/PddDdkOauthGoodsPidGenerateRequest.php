<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkOauthGoodsPidGenerateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "media_id")
	*/
	private $mediaId;

	/**
	* @JsonProperty(Long, "number")
	*/
	private $number;

	/**
	* @JsonProperty(List<String>, "p_id_name_list")
	*/
	private $pIdNameList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "media_id", $this->mediaId);
		$this->setUserParam($params, "number", $this->number);
		$this->setUserParam($params, "p_id_name_list", $this->pIdNameList);

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
		return "pdd.ddk.oauth.goods.pid.generate";
	}

	public function setMediaId($mediaId)
	{
		$this->mediaId = $mediaId;
	}

	public function setNumber($number)
	{
		$this->number = $number;
	}

	public function setPIdNameList($pIdNameList)
	{
		$this->pIdNameList = $pIdNameList;
	}

}
