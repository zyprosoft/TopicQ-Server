<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTraceSourceQueryGoodsInfoRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "httpMethod")
	*/
	private $httpMethod;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTraceSourceQueryGoodsInfoRequest_Params, "params")
	*/
	private $params;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "httpMethod", $this->httpMethod);
		$this->setUserParam($params, "params", $this->params);

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
		return "pdd.trace.source.query.goods.info";
	}

	public function setHttpMethod($httpMethod)
	{
		$this->httpMethod = $httpMethod;
	}

	public function setParams($params)
	{
		$this->params = $params;
	}

}

class PddTraceSourceQueryGoodsInfoRequest_Params extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "userid")
	*/
	private $userid;

	/**
	* @JsonProperty(String, "timestamp")
	*/
	private $timestamp;

	/**
	* @JsonProperty(String, "sign")
	*/
	private $sign;

	/**
	* @JsonProperty(String, "id")
	*/
	private $id;

	public function setUserid($userid)
	{
		$this->userid = $userid;
	}

	public function setTimestamp($timestamp)
	{
		$this->timestamp = $timestamp;
	}

	public function setSign($sign)
	{
		$this->sign = $sign;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

}
