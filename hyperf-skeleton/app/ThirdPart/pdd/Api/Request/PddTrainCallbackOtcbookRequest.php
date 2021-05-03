<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCallbackOtcbookRequest extends PopBaseHttpRequest
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
	* @JsonProperty(Long, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "crh_order")
	*/
	private $crhOrder;

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
	* @JsonProperty(String, "order_id")
	*/
	private $orderId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCallbackOtcbookRequest_PassengersItem>, "passengers")
	*/
	private $passengers;

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
		$this->setUserParam($params, "code", $this->code);
		$this->setUserParam($params, "crh_order", $this->crhOrder);
		$this->setUserParam($params, "depart_date", $this->departDate);
		$this->setUserParam($params, "depart_station", $this->departStation);
		$this->setUserParam($params, "depart_time", $this->departTime);
		$this->setUserParam($params, "msg", $this->msg);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "passengers", $this->passengers);
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
		return "pdd.train.callback.otcbook";
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

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setCrhOrder($crhOrder)
	{
		$this->crhOrder = $crhOrder;
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

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

	public function setPassengers($passengers)
	{
		$this->passengers = $passengers;
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

class PddTrainCallbackOtcbookRequest_PassengersItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "card_no")
	*/
	private $cardNo;

	/**
	* @JsonProperty(String, "card_type")
	*/
	private $cardType;

	/**
	* @JsonProperty(String, "coach_name")
	*/
	private $coachName;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "seat_name")
	*/
	private $seatName;

	/**
	* @JsonProperty(Integer, "seat_position")
	*/
	private $seatPosition;

	/**
	* @JsonProperty(Integer, "seat_type")
	*/
	private $seatType;

	/**
	* @JsonProperty(String, "sub_crh_order")
	*/
	private $subCrhOrder;

	/**
	* @JsonProperty(String, "sub_order_id")
	*/
	private $subOrderId;

	/**
	* @JsonProperty(String, "sub_pdd_order_id")
	*/
	private $subPddOrderId;

	/**
	* @JsonProperty(Long, "ticket_price")
	*/
	private $ticketPrice;

	/**
	* @JsonProperty(Integer, "ticket_type")
	*/
	private $ticketType;

	public function setCardNo($cardNo)
	{
		$this->cardNo = $cardNo;
	}

	public function setCardType($cardType)
	{
		$this->cardType = $cardType;
	}

	public function setCoachName($coachName)
	{
		$this->coachName = $coachName;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setSeatName($seatName)
	{
		$this->seatName = $seatName;
	}

	public function setSeatPosition($seatPosition)
	{
		$this->seatPosition = $seatPosition;
	}

	public function setSeatType($seatType)
	{
		$this->seatType = $seatType;
	}

	public function setSubCrhOrder($subCrhOrder)
	{
		$this->subCrhOrder = $subCrhOrder;
	}

	public function setSubOrderId($subOrderId)
	{
		$this->subOrderId = $subOrderId;
	}

	public function setSubPddOrderId($subPddOrderId)
	{
		$this->subPddOrderId = $subPddOrderId;
	}

	public function setTicketPrice($ticketPrice)
	{
		$this->ticketPrice = $ticketPrice;
	}

	public function setTicketType($ticketType)
	{
		$this->ticketType = $ticketType;
	}

}
