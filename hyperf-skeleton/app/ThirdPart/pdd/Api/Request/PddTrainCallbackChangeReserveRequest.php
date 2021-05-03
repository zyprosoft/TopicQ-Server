<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCallbackChangeReserveRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "arrive_date")
	*/
	private $arriveDate;

	/**
	* @JsonProperty(String, "arrive_station")
	*/
	private $arriveStation;

	/**
	* @JsonProperty(String, "arrive_time")
	*/
	private $arriveTime;

	/**
	* @JsonProperty(Long, "change_pay")
	*/
	private $changePay;

	/**
	* @JsonProperty(Long, "change_refund")
	*/
	private $changeRefund;

	/**
	* @JsonProperty(Integer, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "crh_order_id")
	*/
	private $crhOrderId;

	/**
	* @JsonProperty(String, "depart_date")
	*/
	private $departDate;

	/**
	* @JsonProperty(String, "depart_station")
	*/
	private $departStation;

	/**
	* @JsonProperty(String, "depart_time")
	*/
	private $departTime;

	/**
	* @JsonProperty(String, "msg")
	*/
	private $msg;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCallbackChangeReserveRequest_NewPassengersItem>, "new_passengers")
	*/
	private $newPassengers;

	/**
	* @JsonProperty(String, "order_id")
	*/
	private $orderId;

	/**
	* @JsonProperty(String, "pay_limit_time")
	*/
	private $payLimitTime;

	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

	/**
	* @JsonProperty(String, "request_id")
	*/
	private $requestId;

	/**
	* @JsonProperty(String, "train_no")
	*/
	private $trainNo;

	/**
	* @JsonProperty(Integer, "use_id_card_in")
	*/
	private $useIdCardIn;

	/**
	* @JsonProperty(String, "vendor_time")
	*/
	private $vendorTime;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "arrive_date", $this->arriveDate);
		$this->setUserParam($params, "arrive_station", $this->arriveStation);
		$this->setUserParam($params, "arrive_time", $this->arriveTime);
		$this->setUserParam($params, "change_pay", $this->changePay);
		$this->setUserParam($params, "change_refund", $this->changeRefund);
		$this->setUserParam($params, "code", $this->code);
		$this->setUserParam($params, "crh_order_id", $this->crhOrderId);
		$this->setUserParam($params, "depart_date", $this->departDate);
		$this->setUserParam($params, "depart_station", $this->departStation);
		$this->setUserParam($params, "depart_time", $this->departTime);
		$this->setUserParam($params, "msg", $this->msg);
		$this->setUserParam($params, "new_passengers", $this->newPassengers);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "pay_limit_time", $this->payLimitTime);
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "request_id", $this->requestId);
		$this->setUserParam($params, "train_no", $this->trainNo);
		$this->setUserParam($params, "use_id_card_in", $this->useIdCardIn);
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
		return "pdd.train.callback.change.reserve";
	}

	public function setArriveDate($arriveDate)
	{
		$this->arriveDate = $arriveDate;
	}

	public function setArriveStation($arriveStation)
	{
		$this->arriveStation = $arriveStation;
	}

	public function setArriveTime($arriveTime)
	{
		$this->arriveTime = $arriveTime;
	}

	public function setChangePay($changePay)
	{
		$this->changePay = $changePay;
	}

	public function setChangeRefund($changeRefund)
	{
		$this->changeRefund = $changeRefund;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setCrhOrderId($crhOrderId)
	{
		$this->crhOrderId = $crhOrderId;
	}

	public function setDepartDate($departDate)
	{
		$this->departDate = $departDate;
	}

	public function setDepartStation($departStation)
	{
		$this->departStation = $departStation;
	}

	public function setDepartTime($departTime)
	{
		$this->departTime = $departTime;
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

	public function setPayLimitTime($payLimitTime)
	{
		$this->payLimitTime = $payLimitTime;
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setRequestId($requestId)
	{
		$this->requestId = $requestId;
	}

	public function setTrainNo($trainNo)
	{
		$this->trainNo = $trainNo;
	}

	public function setUseIdCardIn($useIdCardIn)
	{
		$this->useIdCardIn = $useIdCardIn;
	}

	public function setVendorTime($vendorTime)
	{
		$this->vendorTime = $vendorTime;
	}

}

class PddTrainCallbackChangeReserveRequest_NewPassengersItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "change_pay")
	*/
	private $changePay;

	/**
	* @JsonProperty(Long, "change_refund")
	*/
	private $changeRefund;

	/**
	* @JsonProperty(String, "coach_name")
	*/
	private $coachName;

	/**
	* @JsonProperty(String, "coach_no")
	*/
	private $coachNo;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

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

	/**
	* @JsonProperty(String, "seat_name")
	*/
	private $seatName;

	/**
	* @JsonProperty(Integer, "seat_type")
	*/
	private $seatType;

	/**
	* @JsonProperty(String, "sub_crh_order_id")
	*/
	private $subCrhOrderId;

	/**
	* @JsonProperty(Long, "ticket_price")
	*/
	private $ticketPrice;

	public function setChangePay($changePay)
	{
		$this->changePay = $changePay;
	}

	public function setChangeRefund($changeRefund)
	{
		$this->changeRefund = $changeRefund;
	}

	public function setCoachName($coachName)
	{
		$this->coachName = $coachName;
	}

	public function setCoachNo($coachNo)
	{
		$this->coachNo = $coachNo;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

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

	public function setSeatName($seatName)
	{
		$this->seatName = $seatName;
	}

	public function setSeatType($seatType)
	{
		$this->seatType = $seatType;
	}

	public function setSubCrhOrderId($subCrhOrderId)
	{
		$this->subCrhOrderId = $subCrhOrderId;
	}

	public function setTicketPrice($ticketPrice)
	{
		$this->ticketPrice = $ticketPrice;
	}

}
