<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightQueryFlightListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<String>, "carrier_code_list")
	*/
	private $carrierCodeList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightQueryFlightListRequest_SegmentListItem>, "segment_list")
	*/
	private $segmentList;

	/**
	* @JsonProperty(String, "sub_trace_id")
	*/
	private $subTraceId;

	/**
	* @JsonProperty(String, "trace_id")
	*/
	private $traceId;

	/**
	* @JsonProperty(String, "trip_type")
	*/
	private $tripType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "carrier_code_list", $this->carrierCodeList);
		$this->setUserParam($params, "segment_list", $this->segmentList);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "trip_type", $this->tripType);

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
		return "pdd.flight.query.flight.list";
	}

	public function setCarrierCodeList($carrierCodeList)
	{
		$this->carrierCodeList = $carrierCodeList;
	}

	public function setSegmentList($segmentList)
	{
		$this->segmentList = $segmentList;
	}

	public function setSubTraceId($subTraceId)
	{
		$this->subTraceId = $subTraceId;
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

	public function setTripType($tripType)
	{
		$this->tripType = $tripType;
	}

}

class PddFlightQueryFlightListRequest_SegmentListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<String>, "arrival_airport_code_list")
	*/
	private $arrivalAirportCodeList;

	/**
	* @JsonProperty(String, "arrival_city_code")
	*/
	private $arrivalCityCode;

	/**
	* @JsonProperty(List<String>, "departure_airport_code_list")
	*/
	private $departureAirportCodeList;

	/**
	* @JsonProperty(String, "departure_city_code")
	*/
	private $departureCityCode;

	/**
	* @JsonProperty(String, "departure_date")
	*/
	private $departureDate;

	/**
	* @JsonProperty(Integer, "segment_no")
	*/
	private $segmentNo;

	public function setArrivalAirportCodeList($arrivalAirportCodeList)
	{
		$this->arrivalAirportCodeList = $arrivalAirportCodeList;
	}

	public function setArrivalCityCode($arrivalCityCode)
	{
		$this->arrivalCityCode = $arrivalCityCode;
	}

	public function setDepartureAirportCodeList($departureAirportCodeList)
	{
		$this->departureAirportCodeList = $departureAirportCodeList;
	}

	public function setDepartureCityCode($departureCityCode)
	{
		$this->departureCityCode = $departureCityCode;
	}

	public function setDepartureDate($departureDate)
	{
		$this->departureDate = $departureDate;
	}

	public function setSegmentNo($segmentNo)
	{
		$this->segmentNo = $segmentNo;
	}

}
