<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainConfirmChangeRequest extends PopBaseHttpRequest
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainConfirmChangeRequest_NewPassengerInfosItem>, "new_passenger_infos")
	*/
	private $newPassengerInfos;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "new_passenger_infos", $this->newPassengerInfos);

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
		return "pdd.train.confirm.change";
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

	public function setNewPassengerInfos($newPassengerInfos)
	{
		$this->newPassengerInfos = $newPassengerInfos;
	}

}

class PddTrainConfirmChangeRequest_NewPassengerInfosItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "order_id")
	*/
	private $orderId;

	/**
	* @JsonProperty(String, "new_sub_order_id")
	*/
	private $newSubOrderId;

	/**
	* @JsonProperty(String, "old_sub_order_Id")
	*/
	private $oldSubOrderId;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

	public function setNewSubOrderId($newSubOrderId)
	{
		$this->newSubOrderId = $newSubOrderId;
	}

	public function setOldSubOrderId($oldSubOrderId)
	{
		$this->oldSubOrderId = $oldSubOrderId;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

}
