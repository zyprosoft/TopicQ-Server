<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsWareinformSendRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsWareinformSendRequest_Request, "request")
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
		return "pdd.wms.wareinform.send";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddWmsWareinformSendRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "ownerCode")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddWmsWareinformSendRequest_RequestWare, "ware")
	*/
	private $ware;

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setWare($ware)
	{
		$this->ware = $ware;
	}

}

class PddWmsWareinformSendRequest_RequestWare extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

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
	* @JsonProperty(String, "weight")
	*/
	private $weight;

	/**
	* @JsonProperty(String, "width")
	*/
	private $width;

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

	public function setWeight($weight)
	{
		$this->weight = $weight;
	}

	public function setWidth($width)
	{
		$this->width = $width;
	}

}
