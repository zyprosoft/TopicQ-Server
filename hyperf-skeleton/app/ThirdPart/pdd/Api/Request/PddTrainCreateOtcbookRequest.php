<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCreateOtcbookRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "depart_station")
	*/
	private $departStation;

	/**
	* @JsonProperty(String, "arrive_station")
	*/
	private $arriveStation;

	/**
	* @JsonProperty(String, "train_date")
	*/
	private $trainDate;

	/**
	* @JsonProperty(String, "train_no")
	*/
	private $trainNo;

	/**
	* @JsonProperty(String, "depart_time")
	*/
	private $departTime;

	/**
	* @JsonProperty(String, "arrive_time")
	*/
	private $arriveTime;

	/**
	* @JsonProperty(Integer, "accept_other_seat")
	*/
	private $acceptOtherSeat;

	/**
	* @JsonProperty(Integer, "accept_stand_seat")
	*/
	private $acceptStandSeat;

	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCreateOtcbookRequest_OtcChooseSeatItem>, "otc_choose_seat")
	*/
	private $otcChooseSeat;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCreateOtcbookRequest_PassengerInfosItem>, "passenger_infos")
	*/
	private $passengerInfos;

	/**
	* @JsonProperty(String, "request_id")
	*/
	private $requestId;

	/**
	* @JsonProperty(String, "comment")
	*/
	private $comment;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "depart_station", $this->departStation);
		$this->setUserParam($params, "arrive_station", $this->arriveStation);
		$this->setUserParam($params, "train_date", $this->trainDate);
		$this->setUserParam($params, "train_no", $this->trainNo);
		$this->setUserParam($params, "depart_time", $this->departTime);
		$this->setUserParam($params, "arrive_time", $this->arriveTime);
		$this->setUserParam($params, "accept_other_seat", $this->acceptOtherSeat);
		$this->setUserParam($params, "accept_stand_seat", $this->acceptStandSeat);
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "otc_choose_seat", $this->otcChooseSeat);
		$this->setUserParam($params, "passenger_infos", $this->passengerInfos);
		$this->setUserParam($params, "request_id", $this->requestId);
		$this->setUserParam($params, "comment", $this->comment);

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
		return "pdd.train.create.otcbook";
	}

	public function setDepartStation($departStation)
	{
		$this->departStation = $departStation;
	}

	public function setArriveStation($arriveStation)
	{
		$this->arriveStation = $arriveStation;
	}

	public function setTrainDate($trainDate)
	{
		$this->trainDate = $trainDate;
	}

	public function setTrainNo($trainNo)
	{
		$this->trainNo = $trainNo;
	}

	public function setDepartTime($departTime)
	{
		$this->departTime = $departTime;
	}

	public function setArriveTime($arriveTime)
	{
		$this->arriveTime = $arriveTime;
	}

	public function setAcceptOtherSeat($acceptOtherSeat)
	{
		$this->acceptOtherSeat = $acceptOtherSeat;
	}

	public function setAcceptStandSeat($acceptStandSeat)
	{
		$this->acceptStandSeat = $acceptStandSeat;
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setOtcChooseSeat($otcChooseSeat)
	{
		$this->otcChooseSeat = $otcChooseSeat;
	}

	public function setPassengerInfos($passengerInfos)
	{
		$this->passengerInfos = $passengerInfos;
	}

	public function setRequestId($requestId)
	{
		$this->requestId = $requestId;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
	}

}

class PddTrainCreateOtcbookRequest_OtcChooseSeatItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "otc_choose_seat_type")
	*/
	private $otcChooseSeatType;

	/**
	* @JsonProperty(Integer, "count")
	*/
	private $count;

	public function setOtcChooseSeatType($otcChooseSeatType)
	{
		$this->otcChooseSeatType = $otcChooseSeatType;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}

}

class PddTrainCreateOtcbookRequest_PassengerInfosItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "card_type")
	*/
	private $cardType;

	/**
	* @JsonProperty(String, "card_no")
	*/
	private $cardNo;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(Integer, "ticket_type")
	*/
	private $ticketType;

	/**
	* @JsonProperty(Integer, "seat_type")
	*/
	private $seatType;

	/**
	* @JsonProperty(Long, "ticket_price")
	*/
	private $ticketPrice;

	/**
	* @JsonProperty(String, "sub_pdd_order_id")
	*/
	private $subPddOrderId;

	/**
	* @JsonProperty(String, "birthday")
	*/
	private $birthday;

	/**
	* @JsonProperty(String, "effective_date")
	*/
	private $effectiveDate;

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "sex")
	*/
	private $sex;

	/**
	* @JsonProperty(String, "country")
	*/
	private $country;

	/**
	* @JsonProperty(String, "email")
	*/
	private $email;

	/**
	* @JsonProperty(String, "comment")
	*/
	private $comment;

	public function setCardType($cardType)
	{
		$this->cardType = $cardType;
	}

	public function setCardNo($cardNo)
	{
		$this->cardNo = $cardNo;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setTicketType($ticketType)
	{
		$this->ticketType = $ticketType;
	}

	public function setSeatType($seatType)
	{
		$this->seatType = $seatType;
	}

	public function setTicketPrice($ticketPrice)
	{
		$this->ticketPrice = $ticketPrice;
	}

	public function setSubPddOrderId($subPddOrderId)
	{
		$this->subPddOrderId = $subPddOrderId;
	}

	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;
	}

	public function setEffectiveDate($effectiveDate)
	{
		$this->effectiveDate = $effectiveDate;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setSex($sex)
	{
		$this->sex = $sex;
	}

	public function setCountry($country)
	{
		$this->country = $country;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setComment($comment)
	{
		$this->comment = $comment;
	}

}
