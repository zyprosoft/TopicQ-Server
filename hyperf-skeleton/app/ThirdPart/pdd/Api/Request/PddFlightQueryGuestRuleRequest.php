<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightQueryGuestRuleRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "trace_id")
	*/
	private $traceId;

	/**
	* @JsonProperty(String, "sub_trace_id")
	*/
	private $subTraceId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightQueryGuestRuleRequest_ProductListItem>, "product_list")
	*/
	private $productList;

	/**
	* @JsonProperty(Integer, "query_stage")
	*/
	private $queryStage;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "product_list", $this->productList);
		$this->setUserParam($params, "query_stage", $this->queryStage);

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
		return "pdd.flight.query.guest.rule";
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

	public function setSubTraceId($subTraceId)
	{
		$this->subTraceId = $subTraceId;
	}

	public function setProductList($productList)
	{
		$this->productList = $productList;
	}

	public function setQueryStage($queryStage)
	{
		$this->queryStage = $queryStage;
	}

}

class PddFlightQueryGuestRuleRequest_ProductListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<String>, "passenger_type_list")
	*/
	private $passengerTypeList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightQueryGuestRuleRequest_ProductListItemFlightInfoListItem>, "flight_info_list")
	*/
	private $flightInfoList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightQueryGuestRuleRequest_ProductListItemFlightCabinInfoListItem>, "flight_cabin_info_list")
	*/
	private $flightCabinInfoList;

	/**
	* @JsonProperty(String, "trip_type")
	*/
	private $tripType;

	/**
	* @JsonProperty(String, "product_id")
	*/
	private $productId;

	/**
	* @JsonProperty(Integer, "product_type")
	*/
	private $productType;

	public function setPassengerTypeList($passengerTypeList)
	{
		$this->passengerTypeList = $passengerTypeList;
	}

	public function setFlightInfoList($flightInfoList)
	{
		$this->flightInfoList = $flightInfoList;
	}

	public function setFlightCabinInfoList($flightCabinInfoList)
	{
		$this->flightCabinInfoList = $flightCabinInfoList;
	}

	public function setTripType($tripType)
	{
		$this->tripType = $tripType;
	}

	public function setProductId($productId)
	{
		$this->productId = $productId;
	}

	public function setProductType($productType)
	{
		$this->productType = $productType;
	}

}

class PddFlightQueryGuestRuleRequest_ProductListItemFlightInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "segment_no")
	*/
	private $segmentNo;

	/**
	* @JsonProperty(Integer, "sequence_no")
	*/
	private $sequenceNo;

	/**
	* @JsonProperty(String, "departure_date_time")
	*/
	private $departureDateTime;

	/**
	* @JsonProperty(String, "departure_airport_code")
	*/
	private $departureAirportCode;

	/**
	* @JsonProperty(String, "arrival_date_time")
	*/
	private $arrivalDateTime;

	/**
	* @JsonProperty(String, "arrival_airport_code")
	*/
	private $arrivalAirportCode;

	/**
	* @JsonProperty(String, "flight_no")
	*/
	private $flightNo;

	/**
	* @JsonProperty(String, "carrier_code")
	*/
	private $carrierCode;

	public function setSegmentNo($segmentNo)
	{
		$this->segmentNo = $segmentNo;
	}

	public function setSequenceNo($sequenceNo)
	{
		$this->sequenceNo = $sequenceNo;
	}

	public function setDepartureDateTime($departureDateTime)
	{
		$this->departureDateTime = $departureDateTime;
	}

	public function setDepartureAirportCode($departureAirportCode)
	{
		$this->departureAirportCode = $departureAirportCode;
	}

	public function setArrivalDateTime($arrivalDateTime)
	{
		$this->arrivalDateTime = $arrivalDateTime;
	}

	public function setArrivalAirportCode($arrivalAirportCode)
	{
		$this->arrivalAirportCode = $arrivalAirportCode;
	}

	public function setFlightNo($flightNo)
	{
		$this->flightNo = $flightNo;
	}

	public function setCarrierCode($carrierCode)
	{
		$this->carrierCode = $carrierCode;
	}

}

class PddFlightQueryGuestRuleRequest_ProductListItemFlightCabinInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "segment_no")
	*/
	private $segmentNo;

	/**
	* @JsonProperty(Integer, "sequence_no")
	*/
	private $sequenceNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightQueryGuestRuleRequest_ProductListItemFlightCabinInfoListItemCabinInfoListItem>, "cabin_info_list")
	*/
	private $cabinInfoList;

	public function setSegmentNo($segmentNo)
	{
		$this->segmentNo = $segmentNo;
	}

	public function setSequenceNo($sequenceNo)
	{
		$this->sequenceNo = $sequenceNo;
	}

	public function setCabinInfoList($cabinInfoList)
	{
		$this->cabinInfoList = $cabinInfoList;
	}

}

class PddFlightQueryGuestRuleRequest_ProductListItemFlightCabinInfoListItemCabinInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "segment_no")
	*/
	private $segmentNo;

	/**
	* @JsonProperty(String, "sequence_no")
	*/
	private $sequenceNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightQueryGuestRuleRequest_ProductListItemFlightCabinInfoListItemCabinInfoListItemCabinInfoListItem>, "cabin_info_list")
	*/
	private $cabinInfoList;

	public function setSegmentNo($segmentNo)
	{
		$this->segmentNo = $segmentNo;
	}

	public function setSequenceNo($sequenceNo)
	{
		$this->sequenceNo = $sequenceNo;
	}

	public function setCabinInfoList($cabinInfoList)
	{
		$this->cabinInfoList = $cabinInfoList;
	}

}

class PddFlightQueryGuestRuleRequest_ProductListItemFlightCabinInfoListItemCabinInfoListItemCabinInfoListItem extends PopBaseJsonEntity
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
