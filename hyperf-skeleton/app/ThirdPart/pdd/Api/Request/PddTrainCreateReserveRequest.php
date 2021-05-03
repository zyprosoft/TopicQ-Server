<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainCreateReserveRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "pdd_order_id")
	*/
	private $pddOrderId;

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
	* @JsonProperty(Integer, "no_seat")
	*/
	private $noSeat;

	/**
	* @JsonProperty(String, "choose_seat")
	*/
	private $chooseSeat;

	/**
	* @JsonProperty(String, "crh_account")
	*/
	private $crhAccount;

	/**
	* @JsonProperty(String, "crh_password")
	*/
	private $crhPassword;

	/**
	* @JsonProperty(Integer, "switch_account")
	*/
	private $switchAccount;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTrainCreateReserveRequest_PassengerInfosItem>, "passenger_infos")
	*/
	private $passengerInfos;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "pdd_order_id", $this->pddOrderId);
		$this->setUserParam($params, "depart_station", $this->departStation);
		$this->setUserParam($params, "arrive_station", $this->arriveStation);
		$this->setUserParam($params, "train_date", $this->trainDate);
		$this->setUserParam($params, "train_no", $this->trainNo);
		$this->setUserParam($params, "depart_time", $this->departTime);
		$this->setUserParam($params, "arrive_time", $this->arriveTime);
		$this->setUserParam($params, "no_seat", $this->noSeat);
		$this->setUserParam($params, "choose_seat", $this->chooseSeat);
		$this->setUserParam($params, "crh_account", $this->crhAccount);
		$this->setUserParam($params, "crh_password", $this->crhPassword);
		$this->setUserParam($params, "switch_account", $this->switchAccount);
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
		return "pdd.train.create.reserve";
	}

	public function setPddOrderId($pddOrderId)
	{
		$this->pddOrderId = $pddOrderId;
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

	public function setNoSeat($noSeat)
	{
		$this->noSeat = $noSeat;
	}

	public function setChooseSeat($chooseSeat)
	{
		$this->chooseSeat = $chooseSeat;
	}

	public function setCrhAccount($crhAccount)
	{
		$this->crhAccount = $crhAccount;
	}

	public function setCrhPassword($crhPassword)
	{
		$this->crhPassword = $crhPassword;
	}

	public function setSwitchAccount($switchAccount)
	{
		$this->switchAccount = $switchAccount;
	}

	public function setPassengerInfos($passengerInfos)
	{
		$this->passengerInfos = $passengerInfos;
	}

}

class PddTrainCreateReserveRequest_PassengerInfosItem extends PopBaseJsonEntity
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
	* @JsonProperty(String, "effective_Date")
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
