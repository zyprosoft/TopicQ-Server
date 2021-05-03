<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightOrderCreateRequest extends PopBaseHttpRequest
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCreateRequest_FlightInfoListItem>, "flight_info_list")
	*/
	private $flightInfoList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCreateRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCreateRequest_PriceInfoListItem>, "price_info_list")
	*/
	private $priceInfoList;

	/**
	* @JsonProperty(Integer, "product_type")
	*/
	private $productType;

	/**
	* @JsonProperty(String, "product_id")
	*/
	private $productId;

	/**
	* @JsonProperty(String, "token")
	*/
	private $token;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "trip_type", $this->tripType);
		$this->setUserParam($params, "flight_info_list", $this->flightInfoList);
		$this->setUserParam($params, "passenger_info_list", $this->passengerInfoList);
		$this->setUserParam($params, "price_info_list", $this->priceInfoList);
		$this->setUserParam($params, "product_type", $this->productType);
		$this->setUserParam($params, "product_id", $this->productId);
		$this->setUserParam($params, "token", $this->token);

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
		return "pdd.flight.order.create";
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

	public function setFlightInfoList($flightInfoList)
	{
		$this->flightInfoList = $flightInfoList;
	}

	public function setPassengerInfoList($passengerInfoList)
	{
		$this->passengerInfoList = $passengerInfoList;
	}

	public function setPriceInfoList($priceInfoList)
	{
		$this->priceInfoList = $priceInfoList;
	}

	public function setProductType($productType)
	{
		$this->productType = $productType;
	}

	public function setProductId($productId)
	{
		$this->productId = $productId;
	}

	public function setToken($token)
	{
		$this->token = $token;
	}

}

class PddFlightOrderCreateRequest_FlightInfoListItem extends PopBaseJsonEntity
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightOrderCreateRequest_FlightInfoListItemCabinInfoListItem>, "cabin_info_list")
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

class PddFlightOrderCreateRequest_FlightInfoListItemCabinInfoListItem extends PopBaseJsonEntity
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

class PddFlightOrderCreateRequest_PassengerInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "passenger_type")
	*/
	private $passengerType;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "identity_type")
	*/
	private $identityType;

	/**
	* @JsonProperty(String, "identity_no")
	*/
	private $identityNo;

	/**
	* @JsonProperty(String, "gender")
	*/
	private $gender;

	/**
	* @JsonProperty(String, "birthday")
	*/
	private $birthday;

	/**
	* @JsonProperty(String, "effective_date")
	*/
	private $effectiveDate;

	/**
	* @JsonProperty(String, "phone_num")
	*/
	private $phoneNum;

	public function setPassengerType($passengerType)
	{
		$this->passengerType = $passengerType;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setIdentityType($identityType)
	{
		$this->identityType = $identityType;
	}

	public function setIdentityNo($identityNo)
	{
		$this->identityNo = $identityNo;
	}

	public function setGender($gender)
	{
		$this->gender = $gender;
	}

	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;
	}

	public function setEffectiveDate($effectiveDate)
	{
		$this->effectiveDate = $effectiveDate;
	}

	public function setPhoneNum($phoneNum)
	{
		$this->phoneNum = $phoneNum;
	}

}

class PddFlightOrderCreateRequest_PriceInfoListItem extends PopBaseJsonEntity
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
