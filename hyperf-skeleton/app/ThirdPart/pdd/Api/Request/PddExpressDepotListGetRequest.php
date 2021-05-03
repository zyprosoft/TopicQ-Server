<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddExpressDepotListGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "length")
	*/
	private $length;

	/**
	* @JsonProperty(Long, "start")
	*/
	private $start;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "length", $this->length);
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
		return "pdd.express.depot.list.get";
	}

	public function setLength($length)
	{
		$this->length = $length;
	}

	public function setStart($start)
	{
		$this->start = $start;
	}

}
