<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkGoodsPidGenerateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "number")
	*/
	private $number;

	/**
	* @JsonProperty(List<String>, "p_id_name_list")
	*/
	private $pIdNameList;

	/**
	* @JsonProperty(Long, "media_id")
	*/
	private $mediaId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "number", $this->number);
		$this->setUserParam($params, "p_id_name_list", $this->pIdNameList);
		$this->setUserParam($params, "media_id", $this->mediaId);

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
		return "pdd.ddk.goods.pid.generate";
	}

	public function setNumber($number)
	{
		$this->number = $number;
	}

	public function setPIdNameList($pIdNameList)
	{
		$this->pIdNameList = $pIdNameList;
	}

	public function setMediaId($mediaId)
	{
		$this->mediaId = $mediaId;
	}

}
