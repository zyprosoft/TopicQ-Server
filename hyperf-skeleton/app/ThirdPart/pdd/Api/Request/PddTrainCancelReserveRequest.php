<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCancelReserveRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "order_id")
	*/
	private $orderId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "order_id", $this->orderId);

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
		return "pdd.train.cancel.reserve";
	}

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

}
