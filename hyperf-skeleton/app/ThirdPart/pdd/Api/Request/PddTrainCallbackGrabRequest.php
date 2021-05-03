<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCallbackGrabRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "arrive_station")
	*/
	private $arriveStation;

	/**
	* @JsonProperty(String, "arrive_station_code")
	*/
	private $arriveStationCode;

	/**
	* @JsonProperty(String, "arrive_time")
	*/
	private $arriveTime;

	/**
	* @JsonProperty(Integer, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "crh_order_id")
	*/
	private $crhOrderId;

	/**
	* @JsonProperty(String, "depart_station")
	*/
	private $departStation;

	/**
	* @JsonProperty(String, "depart_station_code")
	*/
	private $departStationCode;

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
	* @JsonProperty(Long, "order_ticket_price")
	*/
	private $orderTicketPrice;

	/**
	* @JsonProperty(String, "order_time")
	*/
	private $orderTime;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCallbackGrabRequest_PassengersItem>, "passengers")
	*/
	private $passengers;

	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

	/**
	* @JsonProperty(Integer, "ticket_num")
	*/
	private $ticketNum;

	/**
	* @JsonProperty(String, "train_date")
	*/
	private $trainDate;

	/**
	* @JsonProperty(String, "train_no")
	*/
	private $trainNo;

	/**
	* @JsonProperty(String, "travel_time")
	*/
	private $travelTime;

	/**
	* @JsonProperty(String, "vendor_time")
	*/
	private $vendorTime;

	/**
	* @JsonProperty(String, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(Integer, "channel")
	*/
	private $channel;

	/**
	* @JsonProperty(Integer, "id_card_check_in")
	*/
	private $idCardCheckIn;

	/**
	* @JsonProperty(String, "gate_no")
	*/
	private $gateNo;

	/**
	* @JsonProperty(String, "distance")
	*/
	private $distance;

	/**
	* @JsonProperty(Integer, "is_reserve_first")
	*/
	private $isReserveFirst;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "arrive_station", $this->arriveStation);
		$this->setUserParam($params, "arrive_station_code", $this->arriveStationCode);
		$this->setUserParam($params, "arrive_time", $this->arriveTime);
		$this->setUserParam($params, "code", $this->code);
		$this->setUserParam($params, "crh_order_id", $this->crhOrderId);
		$this->setUserParam($params, "depart_station", $this->departStation);
		$this->setUserParam($params, "depart_station_code", $this->departStationCode);
		$this->setUserParam($params, "depart_time", $this->departTime);
		$this->setUserParam($params, "msg", $this->msg);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "order_ticket_price", $this->orderTicketPrice);
		$this->setUserParam($params, "order_time", $this->orderTime);
		$this->setUserParam($params, "passengers", $this->passengers);
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "ticket_num", $this->ticketNum);
		$this->setUserParam($params, "train_date", $this->trainDate);
		$this->setUserParam($params, "train_no", $this->trainNo);
		$this->setUserParam($params, "travel_time", $this->travelTime);
		$this->setUserParam($params, "vendor_time", $this->vendorTime);
		$this->setUserParam($params, "end_time", $this->endTime);
		$this->setUserParam($params, "channel", $this->channel);
		$this->setUserParam($params, "id_card_check_in", $this->idCardCheckIn);
		$this->setUserParam($params, "gate_no", $this->gateNo);
		$this->setUserParam($params, "distance", $this->distance);
		$this->setUserParam($params, "is_reserve_first", $this->isReserveFirst);

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
		return "pdd.train.callback.grab";
	}

	public function setArriveStation($arriveStation)
	{
		$this->arriveStation = $arriveStation;
	}

	public function setArriveStationCode($arriveStationCode)
	{
		$this->arriveStationCode = $arriveStationCode;
	}

	public function setArriveTime($arriveTime)
	{
		$this->arriveTime = $arriveTime;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setCrhOrderId($crhOrderId)
	{
		$this->crhOrderId = $crhOrderId;
	}

	public function setDepartStation($departStation)
	{
		$this->departStation = $departStation;
	}

	public function setDepartStationCode($departStationCode)
	{
		$this->departStationCode = $departStationCode;
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

	public function setOrderTicketPrice($orderTicketPrice)
	{
		$this->orderTicketPrice = $orderTicketPrice;
	}

	public function setOrderTime($orderTime)
	{
		$this->orderTime = $orderTime;
	}

	public function setPassengers($passengers)
	{
		$this->passengers = $passengers;
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setTicketNum($ticketNum)
	{
		$this->ticketNum = $ticketNum;
	}

	public function setTrainDate($trainDate)
	{
		$this->trainDate = $trainDate;
	}

	public function setTrainNo($trainNo)
	{
		$this->trainNo = $trainNo;
	}

	public function setTravelTime($travelTime)
	{
		$this->travelTime = $travelTime;
	}

	public function setVendorTime($vendorTime)
	{
		$this->vendorTime = $vendorTime;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setChannel($channel)
	{
		$this->channel = $channel;
	}

	public function setIdCardCheckIn($idCardCheckIn)
	{
		$this->idCardCheckIn = $idCardCheckIn;
	}

	public function setGateNo($gateNo)
	{
		$this->gateNo = $gateNo;
	}

	public function setDistance($distance)
	{
		$this->distance = $distance;
	}

	public function setIsReserveFirst($isReserveFirst)
	{
		$this->isReserveFirst = $isReserveFirst;
	}

}

class PddTrainCallbackGrabRequest_PassengersItem extends PopBaseJsonEntity
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
	* @JsonProperty(String, "coach_no")
	*/
	private $coachNo;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "seat_name")
	*/
	private $seatName;

	/**
	* @JsonProperty(String, "seat_no")
	*/
	private $seatNo;

	/**
	* @JsonProperty(Integer, "seat_type")
	*/
	private $seatType;

	/**
	* @JsonProperty(String, "seat_type_name")
	*/
	private $seatTypeName;

	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

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

	public function setCoachNo($coachNo)
	{
		$this->coachNo = $coachNo;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setSeatName($seatName)
	{
		$this->seatName = $seatName;
	}

	public function setSeatNo($seatNo)
	{
		$this->seatNo = $seatNo;
	}

	public function setSeatType($seatType)
	{
		$this->seatType = $seatType;
	}

	public function setSeatTypeName($seatTypeName)
	{
		$this->seatTypeName = $seatTypeName;
	}

	public function setStatus($status)
	{
		$this->status = $status;
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
