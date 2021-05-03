<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreativeCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreativeCreateRequest_AdCreativeCreateMessage, "adCreativeCreateMessage")
	*/
	private $adCreativeCreateMessage;

	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adCreativeCreateMessage", $this->adCreativeCreateMessage);
		$this->setUserParam($params, "adId", $this->adId);

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
		return "pdd.ad.api.unit.creative.create";
	}

	public function setAdCreativeCreateMessage($adCreativeCreateMessage)
	{
		$this->adCreativeCreateMessage = $adCreativeCreateMessage;
	}

	public function setAdId($adId)
	{
		$this->adId = $adId;
	}

}

class PddAdApiUnitCreativeCreateRequest_AdCreativeCreateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreativeCreateRequest_AdCreativeCreateMessageAdImageVOListItem>, "adImageVOList")
	*/
	private $adImageVOList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreativeCreateRequest_AdCreativeCreateMessageAdTextVOListItem>, "adTextVOList")
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

class PddAdApiUnitCreativeCreateRequest_AdCreativeCreateMessageAdImageVOListItem extends PopBaseJsonEntity
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

class PddAdApiUnitCreativeCreateRequest_AdCreativeCreateMessageAdTextVOListItem extends PopBaseJsonEntity
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
