<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreativeUpdateContentRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreativeUpdateContentRequest_AdCreativeUpdateMessage, "adCreativeUpdateMessage")
	*/
	private $adCreativeUpdateMessage;

	/**
	* @JsonProperty(Long, "unitCreativeId")
	*/
	private $unitCreativeId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adCreativeUpdateMessage", $this->adCreativeUpdateMessage);
		$this->setUserParam($params, "unitCreativeId", $this->unitCreativeId);

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
		return "pdd.ad.api.unit.creative.update.content";
	}

	public function setAdCreativeUpdateMessage($adCreativeUpdateMessage)
	{
		$this->adCreativeUpdateMessage = $adCreativeUpdateMessage;
	}

	public function setUnitCreativeId($unitCreativeId)
	{
		$this->unitCreativeId = $unitCreativeId;
	}

}

class PddAdApiUnitCreativeUpdateContentRequest_AdCreativeUpdateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreativeUpdateContentRequest_AdCreativeUpdateMessageAdImageVOListItem>, "adImageVOList")
	*/
	private $adImageVOList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreativeUpdateContentRequest_AdCreativeUpdateMessageAdTextVOListItem>, "adTextVOList")
	*/
	private $adTextVOList;

	/**
	* @JsonProperty(Long, "creativeSpecificationId")
	*/
	private $creativeSpecificationId;

	public function setAdImageVOList($adImageVOList)
	{
		$this->adImageVOList = $adImageVOList;
	}

	public function setAdTextVOList($adTextVOList)
	{
		$this->adTextVOList = $adTextVOList;
	}

	public function setCreativeSpecificationId($creativeSpecificationId)
	{
		$this->creativeSpecificationId = $creativeSpecificationId;
	}

}

class PddAdApiUnitCreativeUpdateContentRequest_AdCreativeUpdateMessageAdImageVOListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "imageUrl")
	*/
	private $imageUrl;

	public function setImageUrl($imageUrl)
	{
		$this->imageUrl = $imageUrl;
	}

}

class PddAdApiUnitCreativeUpdateContentRequest_AdCreativeUpdateMessageAdTextVOListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "text")
	*/
	private $text;

	public function setText($text)
	{
		$this->text = $text;
	}

}
