<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsWareSynchronizeRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsWareSynchronizeRequest_Request, "request")
	*/
	private $request;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "request", $this->request);

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
		return "pdd.wms.ware.synchronize";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsWareSynchronizeRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "actionType")
	*/
	private $actionType;

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsWareSynchronizeRequest_RequestWare, "ware")
	*/
	private $ware;

	public function setActionType($actionType)
	{
		$this->actionType = $actionType;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setWare($ware)
	{
		$this->ware = $ware;
	}

}

class PddWmsWareSynchronizeRequest_RequestWare extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "barCode")
	*/
	private $barCode;

	/**
	* @JsonProperty(String, "brandName")
	*/
	private $brandName;

	/**
	* @JsonProperty(String, "categoryId")
	*/
	private $categoryId;

	/**
	* @JsonProperty(String, "categoryName")
	*/
	private $categoryName;

	/**
	* @JsonProperty(String, "color")
	*/
	private $color;

	/**
	* @JsonProperty(String, "height")
	*/
	private $height;

	/**
	* @JsonProperty(String, "length")
	*/
	private $length;

	/**
	* @JsonProperty(String, "size")
	*/
	private $size;

	/**
	* @JsonProperty(String, "volume")
	*/
	private $volume;

	/**
	* @JsonProperty(String, "wareName")
	*/
	private $wareName;

	/**
	* @JsonProperty(String, "wareSn")
	*/
	private $wareSn;

	/**
	* @JsonProperty(String, "wareType")
	*/
	private $wareType;

	/**
	* @JsonProperty(String, "weight")
	*/
	private $weight;

	/**
	* @JsonProperty(String, "width")
	*/
	private $width;

	public function setBarCode($barCode)
	{
		$this->barCode = $barCode;
	}

	public function setBrandName($brandName)
	{
		$this->brandName = $brandName;
	}

	public function setCategoryId($categoryId)
	{
		$this->categoryId = $categoryId;
	}

	public function setCategoryName($categoryName)
	{
		$this->categoryName = $categoryName;
	}

	public function setColor($color)
	{
		$this->color = $color;
	}

	public function setHeight($height)
	{
		$this->height = $height;
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

	public function setVolume($volume)
	{
		$this->volume = $volume;
	}

	public function setWareName($wareName)
	{
		$this->wareName = $wareName;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

	public function setWareType($wareType)
	{
		$this->wareType = $wareType;
	}

	public function setWeight($weight)
	{
		$this->weight = $weight;
	}

	public function setWidth($width)
	{
		$this->width = $width;
	}

}
