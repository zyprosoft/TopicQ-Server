<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCallbackChangeConfirmRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "crh_order_id")
	*/
	private $crhOrderId;

	/**
	* @JsonProperty(String, "gate_no")
	*/
	private $gateNo;

	/**
	* @JsonProperty(String, "msg")
	*/
	private $msg;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCallbackChangeConfirmRequest_NewPassengersItem>, "new_passengers")
	*/
	private $newPassengers;

	/**
	* @JsonProperty(String, "order_id")
	*/
	private $orderId;

	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

	/**
	* @JsonProperty(String, "vendor_time")
	*/
	private $vendorTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "code", $this->code);
		$this->setUserParam($params, "crh_order_id", $this->crhOrderId);
		$this->setUserParam($params, "gate_no", $this->gateNo);
		$this->setUserParam($params, "msg", $this->msg);
		$this->setUserParam($params, "new_passengers", $this->newPassengers);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "vendor_time", $this->vendorTime);

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
		return "pdd.train.callback.change.confirm";
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setCrhOrderId($crhOrderId)
	{
		$this->crhOrderId = $crhOrderId;
	}

	public function setGateNo($gateNo)
	{
		$this->gateNo = $gateNo;
	}

	public function setMsg($msg)
	{
		$this->msg = $msg;
	}

	public function setNewPassengers($newPassengers)
	{
		$this->newPassengers = $newPassengers;
	}

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setVendorTime($vendorTime)
	{
		$this->vendorTime = $vendorTime;
	}

}

class PddTrainCallbackChangeConfirmRequest_NewPassengersItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "new_sub_order_id")
	*/
	private $newSubOrderId;

	/**
	* @JsonProperty(String, "new_sub_pdd_order_id")
	*/
	private $newSubPddOrderId;

	/**
	* @JsonProperty(String, "old_sub_order_id")
	*/
	private $oldSubOrderId;

	/**
	* @JsonProperty(String, "old_sub_pdd_order_id")
	*/
	private $oldSubPddOrderId;

	public function setNewSubOrderId($newSubOrderId)
	{
		$this->newSubOrderId = $newSubOrderId;
	}

	public function setNewSubPddOrderId($newSubPddOrderId)
	{
		$this->newSubPddOrderId = $newSubPddOrderId;
	}

	public function setOldSubOrderId($oldSubOrderId)
	{
		$this->oldSubOrderId = $oldSubOrderId;
	}

	public function setOldSubPddOrderId($oldSubPddOrderId)
	{
		$this->oldSubPddOrderId = $oldSubPddOrderId;
	}

}
