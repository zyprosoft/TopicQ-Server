<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddStockWareListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "id")
	*/
	private $id;

	/**
	* @JsonProperty(String, "ware_sn")
	*/
	private $wareSn;

	/**
	* @JsonProperty(String, "ware_name")
	*/
	private $wareName;

	/**
	* @JsonProperty(Integer, "ware_type")
	*/
	private $wareType;

	/**
	* @JsonProperty(Integer, "page")
	*/
	private $page;

	/**
	* @JsonProperty(Integer, "size")
	*/
	private $size;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "id", $this->id);
		$this->setUserParam($params, "ware_sn", $this->wareSn);
		$this->setUserParam($params, "ware_name", $this->wareName);
		$this->setUserParam($params, "ware_type", $this->wareType);
		$this->setUserParam($params, "page", $this->page);
		$this->setUserParam($params, "size", $this->size);

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
		return "pdd.stock.ware.list";
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

	public function setWareName($wareName)
	{
		$this->wareName = $wareName;
	}

	public function setWareType($wareType)
	{
		$this->wareType = $wareType;
	}

	public function setPage($page)
	{
		$this->page = $page;
	}

	public function setSize($size)
	{
		$this->size = $size;
	}

}
