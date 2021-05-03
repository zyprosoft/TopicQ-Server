<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightCallbackNotifyChangeapplyreplyRequest extends PopBaseHttpRequest
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackNotifyChangeapplyreplyRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	/**
	* @JsonProperty(Integer, "review_change_type")
	*/
	private $reviewChangeType;

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
		$this->setUserParam($params, "error_code", $this->errorCode);
		$this->setUserParam($params, "error_msg", $this->errorMsg);
		$this->setUserParam($params, "out_change_no", $this->outChangeNo);
		$this->setUserParam($params, "out_order_no", $this->outOrderNo);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "passenger_info_list", $this->passengerInfoList);
		$this->setUserParam($params, "review_change_type", $this->reviewChangeType);
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
		return "pdd.flight.callback.notify.changeapplyreply";
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

	public function setReviewChangeType($reviewChangeType)
	{
		$this->reviewChangeType = $reviewChangeType;
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

class PddFlightCallbackNotifyChangeapplyreplyRequest_PassengerInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "airport_tax")
	*/
	private $airportTax;

	/**
	* @JsonProperty(Long, "airport_tax_diff")
	*/
	private $airportTaxDiff;

	/**
	* @JsonProperty(Long, "base_price")
	*/
	private $basePrice;

	/**
	* @JsonProperty(Long, "base_price_diff")
	*/
	private $basePriceDiff;

	/**
	* @JsonProperty(String, "fuel_tax")
	*/
	private $fuelTax;

	/**
	* @JsonProperty(Long, "fuel_tax_diff")
	*/
	private $fuelTaxDiff;

	/**
	* @JsonProperty(String, "origin_ticket_no")
	*/
	private $originTicketNo;

	/**
	* @JsonProperty(Long, "pay")
	*/
	private $pay;

	/**
	* @JsonProperty(Long, "pay_fee")
	*/
	private $payFee;

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

	public function setAirportTaxDiff($airportTaxDiff)
	{
		$this->airportTaxDiff = $airportTaxDiff;
	}

	public function setBasePrice($basePrice)
	{
		$this->basePrice = $basePrice;
	}

	public function setBasePriceDiff($basePriceDiff)
	{
		$this->basePriceDiff = $basePriceDiff;
	}

	public function setFuelTax($fuelTax)
	{
		$this->fuelTax = $fuelTax;
	}

	public function setFuelTaxDiff($fuelTaxDiff)
	{
		$this->fuelTaxDiff = $fuelTaxDiff;
	}

	public function setOriginTicketNo($originTicketNo)
	{
		$this->originTicketNo = $originTicketNo;
	}

	public function setPay($pay)
	{
		$this->pay = $pay;
	}

	public function setPayFee($payFee)
	{
		$this->payFee = $payFee;
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
