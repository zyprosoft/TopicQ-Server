<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddExpressSearchDepotRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "code")
	*/
	private $code;

	/**
	* @JsonProperty(Integer, "length")
	*/
	private $length;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(Integer, "start")
	*/
	private $start;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "code", $this->code);
		$this->setUserParam($params, "length", $this->length);
		$this->setUserParam($params, "name", $this->name);
		$this->setUserParam($params, "start", $this->start);

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
		return "pdd.express.search.depot";
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setStart($start)
	{
		$this->start = $start;
	}

}
