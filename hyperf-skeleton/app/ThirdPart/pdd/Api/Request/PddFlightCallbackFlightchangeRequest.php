<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightCallbackFlightchangeRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "change_effect_time")
	*/
	private $changeEffectTime;

	/**
	* @JsonProperty(Integer, "change_type")
	*/
	private $changeType;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackFlightchangeRequest_FlightInfo, "flight_info")
	*/
	private $flightInfo;

	/**
	* @JsonProperty(String, "parent_travel_sn")
	*/
	private $parentTravelSn;

	/**
	* @JsonProperty(String, "trace_id")
	*/
	private $traceId;

	/**
	* @JsonProperty(List<String>, "travel_sn")
	*/
	private $travelSn;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "change_effect_time", $this->changeEffectTime);
		$this->setUserParam($params, "change_type", $this->changeType);
		$this->setUserParam($params, "flight_info", $this->flightInfo);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "travel_sn", $this->travelSn);

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
		return "pdd.flight.callback.flightchange";
	}

	public function setChangeEffectTime($changeEffectTime)
	{
		$this->changeEffectTime = $changeEffectTime;
	}

	public function setChangeType($changeType)
	{
		$this->changeType = $changeType;
	}

	public function setFlightInfo($flightInfo)
	{
		$this->flightInfo = $flightInfo;
	}

	public function setParentTravelSn($parentTravelSn)
	{
		$this->parentTravelSn = $parentTravelSn;
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

	public function setTravelSn($travelSn)
	{
		$this->travelSn = $travelSn;
	}

}

class PddFlightCallbackFlightchangeRequest_FlightInfo extends PopBaseJsonEntity
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
	* @JsonProperty(String, "departure_airport_code")
	*/
	private $departureAirportCode;

	/**
	* @JsonProperty(String, "departure_date_time")
	*/
	private $departureDateTime;

	/**
	* @JsonProperty(String, "flight_no")
	*/
	private $flightNo;

	/**
	* @JsonProperty(String, "origin_arrival_date_time")
	*/
	private $originArrivalDateTime;

	/**
	* @JsonProperty(String, "origin_departure_date_time")
	*/
	private $originDepartureDateTime;

	/**
	* @JsonProperty(String, "origin_flight_no")
	*/
	private $originFlightNo;

	public function setArrivalAirportCode($arrivalAirportCode)
	{
		$this->arrivalAirportCode = $arrivalAirportCode;
	}

	public function setArrivalDateTime($arrivalDateTime)
	{
		$this->arrivalDateTime = $arrivalDateTime;
	}

	public function setDepartureAirportCode($departureAirportCode)
	{
		$this->departureAirportCode = $departureAirportCode;
	}

	public function setDepartureDateTime($departureDateTime)
	{
		$this->departureDateTime = $departureDateTime;
	}

	public function setFlightNo($flightNo)
	{
		$this->flightNo = $flightNo;
	}

	public function setOriginArrivalDateTime($originArrivalDateTime)
	{
		$this->originArrivalDateTime = $originArrivalDateTime;
	}

	public function setOriginDepartureDateTime($originDepartureDateTime)
	{
		$this->originDepartureDateTime = $originDepartureDateTime;
	}

	public function setOriginFlightNo($originFlightNo)
	{
		$this->originFlightNo = $originFlightNo;
	}

}
