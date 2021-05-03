<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightOrderCheckSeatPriceRequest extends PopBaseHttpRequest
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
	* @JsonProperty(String, "trip_type")
	*/
	private $tripType;

	/**
	* @JsonProperty(Integer, "product_type")
	*/
	private $productType;

	/**
	* @JsonProperty(String, "product_id")
	*/
	private $productId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCheckSeatPriceRequest_FlightInfoListItem>, "flight_info_list")
	*/
	private $flightInfoList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCheckSeatPriceRequest_PriceInfoListItem>, "price_info_list")
	*/
	private $priceInfoList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "trip_type", $this->tripType);
		$this->setUserParam($params, "product_type", $this->productType);
		$this->setUserParam($params, "product_id", $this->productId);
		$this->setUserParam($params, "flight_info_list", $this->flightInfoList);
		$this->setUserParam($params, "price_info_list", $this->priceInfoList);

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
		return "pdd.flight.order.check.seat.price";
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

	public function setSubTraceId($subTraceId)
	{
		$this->subTraceId = $subTraceId;
	}

	public function setTripType($tripType)
	{
		$this->tripType = $tripType;
	}

	public function setProductType($productType)
	{
		$this->productType = $productType;
	}

	public function setProductId($productId)
	{
		$this->productId = $productId;
	}

	public function setFlightInfoList($flightInfoList)
	{
		$this->flightInfoList = $flightInfoList;
	}

	public function setPriceInfoList($priceInfoList)
	{
		$this->priceInfoList = $priceInfoList;
	}

}

class PddFlightOrderCheckSeatPriceRequest_FlightInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "flight_no")
	*/
	private $flightNo;

	/**
	* @JsonProperty(String, "carrier_code")
	*/
	private $carrierCode;

	/**
	* @JsonProperty(Boolean, "shared")
	*/
	private $shared;

	/**
	* @JsonProperty(String, "shared_carrier_code")
	*/
	private $sharedCarrierCode;

	/**
	* @JsonProperty(String, "shared_flight_no")
	*/
	private $sharedFlightNo;

	/**
	* @JsonProperty(String, "departure_date_time")
	*/
	private $departureDateTime;

	/**
	* @JsonProperty(String, "departure_airport_code")
	*/
	private $departureAirportCode;

	/**
	* @JsonProperty(String, "departure_terminal")
	*/
	private $departureTerminal;

	/**
	* @JsonProperty(String, "arrival_date_time")
	*/
	private $arrivalDateTime;

	/**
	* @JsonProperty(String, "arrival_airport_code")
	*/
	private $arrivalAirportCode;

	/**
	* @JsonProperty(String, "arrival_terminal")
	*/
	private $arrivalTerminal;

	/**
	* @JsonProperty(Integer, "segment_no")
	*/
	private $segmentNo;

	/**
	* @JsonProperty(Integer, "sequence_no")
	*/
	private $sequenceNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCheckSeatPriceRequest_FlightInfoListItemCabinInfoListItem>, "cabin_info_list")
	*/
	private $cabinInfoList;

	public function setFlightNo($flightNo)
	{
		$this->flightNo = $flightNo;
	}

	public function setCarrierCode($carrierCode)
	{
		$this->carrierCode = $carrierCode;
	}

	public function setShared($shared)
	{
		$this->shared = $shared;
	}

	public function setSharedCarrierCode($sharedCarrierCode)
	{
		$this->sharedCarrierCode = $sharedCarrierCode;
	}

	public function setSharedFlightNo($sharedFlightNo)
	{
		$this->sharedFlightNo = $sharedFlightNo;
	}

	public function setDepartureDateTime($departureDateTime)
	{
		$this->departureDateTime = $departureDateTime;
	}

	public function setDepartureAirportCode($departureAirportCode)
	{
		$this->departureAirportCode = $departureAirportCode;
	}

	public function setDepartureTerminal($departureTerminal)
	{
		$this->departureTerminal = $departureTerminal;
	}

	public function setArrivalDateTime($arrivalDateTime)
	{
		$this->arrivalDateTime = $arrivalDateTime;
	}

	public function setArrivalAirportCode($arrivalAirportCode)
	{
		$this->arrivalAirportCode = $arrivalAirportCode;
	}

	public function setArrivalTerminal($arrivalTerminal)
	{
		$this->arrivalTerminal = $arrivalTerminal;
	}

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

class PddFlightOrderCheckSeatPriceRequest_FlightInfoListItemCabinInfoListItem extends PopBaseJsonEntity
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

class PddFlightOrderCheckSeatPriceRequest_PriceInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "passenger_type")
	*/
	private $passengerType;

	/**
	* @JsonProperty(Long, "base_price")
	*/
	private $basePrice;

	/**
	* @JsonProperty(Long, "settle_price")
	*/
	private $settlePrice;

	/**
	* @JsonProperty(Long, "airport_tax")
	*/
	private $airportTax;

	/**
	* @JsonProperty(Long, "fuel_tax")
	*/
	private $fuelTax;

	/**
	* @JsonProperty(Double, "commission_point")
	*/
	private $commissionPoint;

	/**
	* @JsonProperty(Long, "commission_money")
	*/
	private $commissionMoney;

	public function setPassengerType($passengerType)
	{
		$this->passengerType = $passengerType;
	}

	public function setBasePrice($basePrice)
	{
		$this->basePrice = $basePrice;
	}

	public function setSettlePrice($settlePrice)
	{
		$this->settlePrice = $settlePrice;
	}

	public function setAirportTax($airportTax)
	{
		$this->airportTax = $airportTax;
	}

	public function setFuelTax($fuelTax)
	{
		$this->fuelTax = $fuelTax;
	}

	public function setCommissionPoint($commissionPoint)
	{
		$this->commissionPoint = $commissionPoint;
	}

	public function setCommissionMoney($commissionMoney)
	{
		$this->commissionMoney = $commissionMoney;
	}

}
