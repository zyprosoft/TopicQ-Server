<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCancelChangeRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

	/**
	* @JsonProperty(String, "order_id")
	*/
	private $orderId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCancelChangeRequest_PassengerInfosItem>, "passenger_infos")
	*/
	private $passengerInfos;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "passenger_infos", $this->passengerInfos);

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
		return "pdd.train.cancel.change";
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

	public function setPassengerInfos($passengerInfos)
	{
		$this->passengerInfos = $passengerInfos;
	}

}

class PddTrainCancelChangeRequest_PassengerInfosItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "new_sub_order_Id")
	*/
	private $newSubOrderId;

	/**
	* @JsonProperty(String, "old_sub_order_id")
	*/
	private $oldSubOrderId;

	public function setNewSubOrderId($newSubOrderId)
	{
		$this->newSubOrderId = $newSubOrderId;
	}

	public function setOldSubOrderId($oldSubOrderId)
	{
		$this->oldSubOrderId = $oldSubOrderId;
	}

}
