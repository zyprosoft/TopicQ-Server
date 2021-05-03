<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainChangeTicketRequest extends PopBaseHttpRequest
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
	* @JsonProperty(String, "new_depart_station")
	*/
	private $newDepartStation;

	/**
	* @JsonProperty(String, "new_arrive_station")
	*/
	private $newArriveStation;

	/**
	* @JsonProperty(String, "new_train_date")
	*/
	private $newTrainDate;

	/**
	* @JsonProperty(String, "new_train_no")
	*/
	private $newTrainNo;

	/**
	* @JsonProperty(String, "new_depart_time")
	*/
	private $newDepartTime;

	/**
	* @JsonProperty(String, "new_arrive_time")
	*/
	private $newArriveTime;

	/**
	* @JsonProperty(Integer, "new_seat_type")
	*/
	private $newSeatType;

	/**
	* @JsonProperty(String, "new_choose_seat")
	*/
	private $newChooseSeat;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainChangeTicketRequest_NewPassengerInfosItem>, "new_passenger_infos")
	*/
	private $newPassengerInfos;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "order_id", $this->orderId);
		$this->setUserParam($params, "new_depart_station", $this->newDepartStation);
		$this->setUserParam($params, "new_arrive_station", $this->newArriveStation);
		$this->setUserParam($params, "new_train_date", $this->newTrainDate);
		$this->setUserParam($params, "new_train_no", $this->newTrainNo);
		$this->setUserParam($params, "new_depart_time", $this->newDepartTime);
		$this->setUserParam($params, "new_arrive_time", $this->newArriveTime);
		$this->setUserParam($params, "new_seat_type", $this->newSeatType);
		$this->setUserParam($params, "new_choose_seat", $this->newChooseSeat);
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
		return "pdd.train.change.ticket";
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
	}

	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
	}

	public function setNewDepartStation($newDepartStation)
	{
		$this->newDepartStation = $newDepartStation;
	}

	public function setNewArriveStation($newArriveStation)
	{
		$this->newArriveStation = $newArriveStation;
	}

	public function setNewTrainDate($newTrainDate)
	{
		$this->newTrainDate = $newTrainDate;
	}

	public function setNewTrainNo($newTrainNo)
	{
		$this->newTrainNo = $newTrainNo;
	}

	public function setNewDepartTime($newDepartTime)
	{
		$this->newDepartTime = $newDepartTime;
	}

	public function setNewArriveTime($newArriveTime)
	{
		$this->newArriveTime = $newArriveTime;
	}

	public function setNewSeatType($newSeatType)
	{
		$this->newSeatType = $newSeatType;
	}

	public function setNewChooseSeat($newChooseSeat)
	{
		$this->newChooseSeat = $newChooseSeat;
	}

	public function setNewPassengerInfos($newPassengerInfos)
	{
		$this->newPassengerInfos = $newPassengerInfos;
	}

}

class PddTrainChangeTicketRequest_NewPassengerInfosItem extends PopBaseJsonEntity
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
	* @JsonProperty(String, "sub_order_id")
	*/
	private $subOrderId;

	/**
	* @JsonProperty(String, "new_sub_pdd_order_id")
	*/
	private $newSubPddOrderId;

	/**
	* @JsonProperty(String, "birthday")
	*/
	private $birthday;

	/**
	* @JsonProperty(String, "effective_date")
	*/
	private $effectiveDate;

	/**
	* @JsonProperty(String, "sex")
	*/
	private $sex;

	/**
	* @JsonProperty(String, "country")
	*/
	private $country;

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "email")
	*/
	private $email;

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

	public function setSubOrderId($subOrderId)
	{
		$this->subOrderId = $subOrderId;
	}

	public function setNewSubPddOrderId($newSubPddOrderId)
	{
		$this->newSubPddOrderId = $newSubPddOrderId;
	}

	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;
	}

	public function setEffectiveDate($effectiveDate)
	{
		$this->effectiveDate = $effectiveDate;
	}

	public function setSex($sex)
	{
		$this->sex = $sex;
	}

	public function setCountry($country)
	{
		$this->country = $country;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

}
