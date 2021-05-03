<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightCallbackConfirmChangeRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "change_time")
	*/
	private $changeTime;

	/**
	* @JsonProperty(Integer, "change_type")
	*/
	private $changeType;

	/**
	* @JsonProperty(Integer, "error_code")
	*/
	private $errorCode;

	/**
	* @JsonProperty(String, "error_msg")
	*/
	private $errorMsg;

	/**
	* @JsonProperty(String, "out_change_no")
	*/
	private $outChangeNo;

	/**
	* @JsonProperty(String, "out_order_no")
	*/
	private $outOrderNo;

	/**
	* @JsonProperty(String, "parent_travel_sn")
	*/
	private $parentTravelSn;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmChangeRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	/**
	* @JsonProperty(String, "sub_trace_id")
	*/
	private $subTraceId;

	/**
	* @JsonProperty(String, "trace_id")
	*/
	private $traceId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "change_time", $this->changeTime);
		$this->setUserParam($params, "change_type", $this->changeType);
		$this->setUserParam($params, "error_code", $this->errorCode);
		$this->setUserParam($params, "error_msg", $this->errorMsg);
		$this->setUserParam($params, "out_change_no", $this->outChangeNo);
		$this->setUserParam($params, "out_order_no", $this->outOrderNo);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "passenger_info_list", $this->passengerInfoList);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "trace_id", $this->traceId);

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
		return "pdd.flight.callback.confirm.change";
	}

	public function setChangeTime($changeTime)
	{
		$this->changeTime = $changeTime;
	}

	public function setChangeType($changeType)
	{
		$this->changeType = $changeType;
	}

	public function setErrorCode($errorCode)
	{
		$this->errorCode = $errorCode;
	}

	public function setErrorMsg($errorMsg)
	{
		$this->errorMsg = $errorMsg;
	}

	public function setOutChangeNo($outChangeNo)
	{
		$this->outChangeNo = $outChangeNo;
	}

	public function setOutOrderNo($outOrderNo)
	{
		$this->outOrderNo = $outOrderNo;
	}

	public function setParentTravelSn($parentTravelSn)
	{
		$this->parentTravelSn = $parentTravelSn;
	}

	public function setPassengerInfoList($passengerInfoList)
	{
		$this->passengerInfoList = $passengerInfoList;
	}

	public function setSubTraceId($subTraceId)
	{
		$this->subTraceId = $subTraceId;
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

}

class PddFlightCallbackConfirmChangeRequest_PassengerInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "airport_tax")
	*/
	private $airportTax;

	/**
	* @JsonProperty(String, "change_ticket_no")
	*/
	private $changeTicketNo;

	/**
	* @JsonProperty(Long, "fuel_tax")
	*/
	private $fuelTax;

	/**
	* @JsonProperty(String, "identity_no")
	*/
	private $identityNo;

	/**
	* @JsonProperty(String, "identity_type")
	*/
	private $identityType;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "origin_pnr")
	*/
	private $originPnr;

	/**
	* @JsonProperty(String, "origin_ticket_no")
	*/
	private $originTicketNo;

	/**
	* @JsonProperty(Long, "pay")
	*/
	private $pay;

	/**
	* @JsonProperty(Long, "pay_airline_tax")
	*/
	private $payAirlineTax;

	/**
	* @JsonProperty(Long, "pay_fee")
	*/
	private $payFee;

	/**
	* @JsonProperty(Long, "pay_fuel_tax")
	*/
	private $payFuelTax;

	/**
	* @JsonProperty(Long, "pay_price")
	*/
	private $payPrice;

	/**
	* @JsonProperty(Long, "price")
	*/
	private $price;

	/**
	* @JsonProperty(String, "sub_out_change_no")
	*/
	private $subOutChangeNo;

	/**
	* @JsonProperty(String, "travel_sn")
	*/
	private $travelSn;

	public function setAirportTax($airportTax)
	{
		$this->airportTax = $airportTax;
	}

	public function setChangeTicketNo($changeTicketNo)
	{
		$this->changeTicketNo = $changeTicketNo;
	}

	public function setFuelTax($fuelTax)
	{
		$this->fuelTax = $fuelTax;
	}

	public function setIdentityNo($identityNo)
	{
		$this->identityNo = $identityNo;
	}

	public function setIdentityType($identityType)
	{
		$this->identityType = $identityType;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setOriginPnr($originPnr)
	{
		$this->originPnr = $originPnr;
	}

	public function setOriginTicketNo($originTicketNo)
	{
		$this->originTicketNo = $originTicketNo;
	}

	public function setPay($pay)
	{
		$this->pay = $pay;
	}

	public function setPayAirlineTax($payAirlineTax)
	{
		$this->payAirlineTax = $payAirlineTax;
	}

	public function setPayFee($payFee)
	{
		$this->payFee = $payFee;
	}

	public function setPayFuelTax($payFuelTax)
	{
		$this->payFuelTax = $payFuelTax;
	}

	public function setPayPrice($payPrice)
	{
		$this->payPrice = $payPrice;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function setSubOutChangeNo($subOutChangeNo)
	{
		$this->subOutChangeNo = $subOutChangeNo;
	}

	public function setTravelSn($travelSn)
	{
		$this->travelSn = $travelSn;
	}

}
