<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFdsOrderGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFdsOrderGetRequest_ParamFdsOrderGetRequest, "param_fds_order_get_request")
	*/
	private $paramFdsOrderGetRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "param_fds_order_get_request", $this->paramFdsOrderGetRequest);

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
		return "pdd.fds.order.get";
	}

	public function setParamFdsOrderGetRequest($paramFdsOrderGetRequest)
	{
		$this->paramFdsOrderGetRequest = $paramFdsOrderGetRequest;
	}

}

class PddFdsOrderGetRequest_ParamFdsOrderGetRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "mall_mask_id")
	*/
	private $mallMaskId;

	/**
	* @JsonProperty(String, "order_mask_sn")
	*/
	private $orderMaskSn;

	public function setMallMaskId($mallMaskId)
	{
		$this->mallMaskId = $mallMaskId;
	}

	public function setOrderMaskSn($orderMaskSn)
	{
		$this->orderMaskSn = $orderMaskSn;
	}

}
