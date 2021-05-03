<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddStockWareCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "ware_type")
	*/
	private $wareType;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddStockWareCreateRequest_WareInfosItem>, "ware_infos")
	*/
	private $wareInfos;

	/**
	* @JsonProperty(String, "ware_sn")
	*/
	private $wareSn;

	/**
	* @JsonProperty(String, "ware_name")
	*/
	private $wareName;

	/**
	* @JsonProperty(String, "note")
	*/
	private $note;

	/**
	* @JsonProperty(Integer, "service_quality")
	*/
	private $serviceQuality;

	/**
	* @JsonProperty(Integer, "volume")
	*/
	private $volume;

	/**
	* @JsonProperty(Integer, "length")
	*/
	private $length;

	/**
	* @JsonProperty(Integer, "width")
	*/
	private $width;

	/**
	* @JsonProperty(Integer, "height")
	*/
	private $height;

	/**
	* @JsonProperty(Integer, "weight")
	*/
	private $weight;

	/**
	* @JsonProperty(Integer, "gross_weight")
	*/
	private $grossWeight;

	/**
	* @JsonProperty(Integer, "net_weight")
	*/
	private $netWeight;

	/**
	* @JsonProperty(Integer, "tare_weight")
	*/
	private $tareWeight;

	/**
	* @JsonProperty(Integer, "price")
	*/
	private $price;

	/**
	* @JsonProperty(String, "color")
	*/
	private $color;

	/**
	* @JsonProperty(String, "packing")
	*/
	private $packing;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "ware_type", $this->wareType);
		$this->setUserParam($params, "ware_infos", $this->wareInfos);
		$this->setUserParam($params, "ware_sn", $this->wareSn);
		$this->setUserParam($params, "ware_name", $this->wareName);
		$this->setUserParam($params, "note", $this->note);
		$this->setUserParam($params, "service_quality", $this->serviceQuality);
		$this->setUserParam($params, "volume", $this->volume);
		$this->setUserParam($params, "length", $this->length);
		$this->setUserParam($params, "width", $this->width);
		$this->setUserParam($params, "height", $this->height);
		$this->setUserParam($params, "weight", $this->weight);
		$this->setUserParam($params, "gross_weight", $this->grossWeight);
		$this->setUserParam($params, "net_weight", $this->netWeight);
		$this->setUserParam($params, "tare_weight", $this->tareWeight);
		$this->setUserParam($params, "price", $this->price);
		$this->setUserParam($params, "color", $this->color);
		$this->setUserParam($params, "packing", $this->packing);

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
		return "pdd.stock.ware.create";
	}

	public function setWareType($wareType)
	{
		$this->wareType = $wareType;
	}

	public function setWareInfos($wareInfos)
	{
		$this->wareInfos = $wareInfos;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

	public function setWareName($wareName)
	{
		$this->wareName = $wareName;
	}

	public function setNote($note)
	{
		$this->note = $note;
	}

	public function setServiceQuality($serviceQuality)
	{
		$this->serviceQuality = $serviceQuality;
	}

	public function setVolume($volume)
	{
		$this->volume = $volume;
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function setWidth($width)
	{
		$this->width = $width;
	}

	public function setHeight($height)
	{
		$this->height = $height;
	}

	public function setWeight($weight)
	{
		$this->weight = $weight;
	}

	public function setGrossWeight($grossWeight)
	{
		$this->grossWeight = $grossWeight;
	}

	public function setNetWeight($netWeight)
	{
		$this->netWeight = $netWeight;
	}

	public function setTareWeight($tareWeight)
	{
		$this->tareWeight = $tareWeight;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function setColor($color)
	{
		$this->color = $color;
	}

	public function setPacking($packing)
	{
		$this->packing = $packing;
	}

}

class PddStockWareCreateRequest_WareInfosItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "ware_quantity")
	*/
	private $wareQuantity;

	/**
	* @JsonProperty(Long, "ware_id")
	*/
	private $wareId;

	public function setWareQuantity($wareQuantity)
	{
		$this->wareQuantity = $wareQuantity;
	}

	public function setWareId($wareId)
	{
		$this->wareId = $wareId;
	}

}
