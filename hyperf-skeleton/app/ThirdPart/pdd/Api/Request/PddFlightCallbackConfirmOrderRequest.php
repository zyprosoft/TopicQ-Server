<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightCallbackConfirmOrderRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "error_code")
	*/
	private $errorCode;

	/**
	* @JsonProperty(String, "error_msg")
	*/
	private $errorMsg;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmOrderRequest_FlightInfoListItem>, "flight_info_list")
	*/
	private $flightInfoList;

	/**
	* @JsonProperty(String, "out_order_no")
	*/
	private $outOrderNo;

	/**
	* @JsonProperty(String, "parent_travel_sn")
	*/
	private $parentTravelSn;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmOrderRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	/**
	* @JsonProperty(Integer, "ticket_status")
	*/
	private $ticketStatus;

	/**
	* @JsonProperty(String, "ticket_time")
	*/
	private $ticketTime;

	/**
	* @JsonProperty(Long, "total_airport_tax")
	*/
	private $totalAirportTax;

	/**
	* @JsonProperty(Long, "total_fuel_tax")
	*/
	private $totalFuelTax;

	/**
	* @JsonProperty(Long, "total_pay")
	*/
	private $totalPay;

	/**
	* @JsonProperty(Long, "total_settle_price")
	*/
	private $totalSettlePrice;

	/**
	* @JsonProperty(String, "trace_id")
	*/
	private $traceId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "error_code", $this->errorCode);
		$this->setUserParam($params, "error_msg", $this->errorMsg);
		$this->setUserParam($params, "flight_info_list", $this->flightInfoList);
		$this->setUserParam($params, "out_order_no", $this->outOrderNo);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "passenger_info_list", $this->passengerInfoList);
		$this->setUserParam($params, "ticket_status", $this->ticketStatus);
		$this->setUserParam($params, "ticket_time", $this->ticketTime);
		$this->setUserParam($params, "total_airport_tax", $this->totalAirportTax);
		$this->setUserParam($params, "total_fuel_tax", $this->totalFuelTax);
		$this->setUserParam($params, "total_pay", $this->totalPay);
		$this->setUserParam($params, "total_settle_price", $this->totalSettlePrice);
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
		return "pdd.flight.callback.confirm.order";
	}

	public function setErrorCode($errorCode)
	{
		$this->errorCode = $errorCode;
	}

	public function setErrorMsg($errorMsg)
	{
		$this->errorMsg = $errorMsg;
	}

	public function setFlightInfoList($flightInfoList)
	{
		$this->flightInfoList = $flightInfoList;
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

	public function setTicketStatus($ticketStatus)
	{
		$this->ticketStatus = $ticketStatus;
	}

	public function setTicketTime($ticketTime)
	{
		$this->ticketTime = $ticketTime;
	}

	public function setTotalAirportTax($totalAirportTax)
	{
		$this->totalAirportTax = $totalAirportTax;
	}

	public function setTotalFuelTax($totalFuelTax)
	{
		$this->totalFuelTax = $totalFuelTax;
	}

	public function setTotalPay($totalPay)
	{
		$this->totalPay = $totalPay;
	}

	public function setTotalSettlePrice($totalSettlePrice)
	{
		$this->totalSettlePrice = $totalSettlePrice;
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

}

class PddFlightCallbackConfirmOrderRequest_FlightInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "arrival_airport_code")
	*/
	private $arrivalAirportCode;

	/**
	* @JsonProperty(String, "arrival_date_time")
	*/
	private $arrivalDateTime;

	/**
	* @JsonProperty(String, "arrival_terminal")
	*/
	private $arrivalTerminal;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmOrderRequest_FlightInfoListItemCabinInfoListItem>, "cabin_info_list")
	*/
	private $cabinInfoList;

	/**
	* @JsonProperty(String, "carrier_code")
	*/
	private $carrierCode;

	/**
	* @JsonProperty(String, "departure_airport_code")
	*/
	private $departureAirportCode;

	/**
	* @JsonProperty(String, "departure_date_time")
	*/
	private $departureDateTime;

	/**
	* @JsonProperty(String, "departure_terminal")
	*/
	private $departureTerminal;

	/**
	* @JsonProperty(String, "flight_no")
	*/
	private $flightNo;

	/**
	* @JsonProperty(String, "operate_carrier_code")
	*/
	private $operateCarrierCode;

	/**
	* @JsonProperty(String, "operate_flight_no")
	*/
	private $operateFlightNo;

	/**
	* @JsonProperty(Integer, "segment_no")
	*/
	private $segmentNo;

	/**
	* @JsonProperty(Integer, "sequence_no")
	*/
	private $sequenceNo;

	/**
	* @JsonProperty(Boolean, "shared")
	*/
	private $shared;

	public function setArrivalAirportCode($arrivalAirportCode)
	{
		$this->arrivalAirportCode = $arrivalAirportCode;
	}

	public function setArrivalDateTime($arrivalDateTime)
	{
		$this->arrivalDateTime = $arrivalDateTime;
	}

	public function setArrivalTerminal($arrivalTerminal)
	{
		$this->arrivalTerminal = $arrivalTerminal;
	}

	public function setCabinInfoList($cabinInfoList)
	{
		$this->cabinInfoList = $cabinInfoList;
	}

	public function setCarrierCode($carrierCode)
	{
		$this->carrierCode = $carrierCode;
	}

	public function setDepartureAirportCode($departureAirportCode)
	{
		$this->departureAirportCode = $departureAirportCode;
	}

	public function setDepartureDateTime($departureDateTime)
	{
		$this->departureDateTime = $departureDateTime;
	}

	public function setDepartureTerminal($departureTerminal)
	{
		$this->departureTerminal = $departureTerminal;
	}

	public function setFlightNo($flightNo)
	{
		$this->flightNo = $flightNo;
	}

	public function setOperateCarrierCode($operateCarrierCode)
	{
		$this->operateCarrierCode = $operateCarrierCode;
	}

	public function setOperateFlightNo($operateFlightNo)
	{
		$this->operateFlightNo = $operateFlightNo;
	}

	public function setSegmentNo($segmentNo)
	{
		$this->segmentNo = $segmentNo;
	}

	public function setSequenceNo($sequenceNo)
	{
		$this->sequenceNo = $sequenceNo;
	}

	public function setShared($shared)
	{
		$this->shared = $shared;
	}

}

class PddFlightCallbackConfirmOrderRequest_FlightInfoListItemCabinInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "passenger_type")
	*/
	private $passengerType;

	/**
	* @JsonProperty(String, "sub_class")
	*/
	private $subClass;

	public function setPassengerType($passengerType)
	{
		$this->passengerType = $passengerType;
	}

	public function setSubClass($subClass)
	{
		$this->subClass = $subClass;
	}

}

class PddFlightCallbackConfirmOrderRequest_PassengerInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "airport_tax")
	*/
	private $airportTax;

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
	* @JsonProperty(String, "out_sub_order_no")
	*/
	private $outSubOrderNo;

	/**
	* @JsonProperty(Long, "pay")
	*/
	private $pay;

	/**
	* @JsonProperty(String, "pnr")
	*/
	private $pnr;

	/**
	* @JsonProperty(Long, "settle_price")
	*/
	private $settlePrice;

	/**
	* @JsonProperty(String, "ticket_no")
	*/
	private $ticketNo;

	/**
	* @JsonProperty(String, "travel_sn")
	*/
	private $travelSn;

	public function setAirportTax($airportTax)
	{
		$this->airportTax = $airportTax;
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

	public function setOutSubOrderNo($outSubOrderNo)
	{
		$this->outSubOrderNo = $outSubOrderNo;
	}

	public function setPay($pay)
	{
		$this->pay = $pay;
	}

	public function setPnr($pnr)
	{
		$this->pnr = $pnr;
	}

	public function setSettlePrice($settlePrice)
	{
		$this->settlePrice = $settlePrice;
	}

	public function setTicketNo($ticketNo)
	{
		$this->ticketNo = $ticketNo;
	}

	public function setTravelSn($travelSn)
	{
		$this->travelSn = $travelSn;
	}

}
