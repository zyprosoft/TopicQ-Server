<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightCallbackConfirmRefundRequest extends PopBaseHttpRequest
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
	* @JsonProperty(String, "out_order_no")
	*/
	private $outOrderNo;

	/**
	* @JsonProperty(String, "out_refund_no")
	*/
	private $outRefundNo;

	/**
	* @JsonProperty(String, "parent_travel_sn")
	*/
	private $parentTravelSn;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmRefundRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	/**
	* @JsonProperty(Integer, "refund_callback_type")
	*/
	private $refundCallbackType;

	/**
	* @JsonProperty(Integer, "refund_status")
	*/
	private $refundStatus;

	/**
	* @JsonProperty(String, "refund_time")
	*/
	private $refundTime;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmRefundRequest_SubRefundInfoListItem>, "sub_refund_info_list")
	*/
	private $subRefundInfoList;

	/**
	* @JsonProperty(String, "trace_id")
	*/
	private $traceId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "error_code", $this->errorCode);
		$this->setUserParam($params, "error_msg", $this->errorMsg);
		$this->setUserParam($params, "out_order_no", $this->outOrderNo);
		$this->setUserParam($params, "out_refund_no", $this->outRefundNo);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "passenger_info_list", $this->passengerInfoList);
		$this->setUserParam($params, "refund_callback_type", $this->refundCallbackType);
		$this->setUserParam($params, "refund_status", $this->refundStatus);
		$this->setUserParam($params, "refund_time", $this->refundTime);
		$this->setUserParam($params, "sub_refund_info_list", $this->subRefundInfoList);
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
		return "pdd.flight.callback.confirm.refund";
	}

	public function setErrorCode($errorCode)
	{
		$this->errorCode = $errorCode;
	}

	public function setErrorMsg($errorMsg)
	{
		$this->errorMsg = $errorMsg;
	}

	public function setOutOrderNo($outOrderNo)
	{
		$this->outOrderNo = $outOrderNo;
	}

	public function setOutRefundNo($outRefundNo)
	{
		$this->outRefundNo = $outRefundNo;
	}

	public function setParentTravelSn($parentTravelSn)
	{
		$this->parentTravelSn = $parentTravelSn;
	}

	public function setPassengerInfoList($passengerInfoList)
	{
		$this->passengerInfoList = $passengerInfoList;
	}

	public function setRefundCallbackType($refundCallbackType)
	{
		$this->refundCallbackType = $refundCallbackType;
	}

	public function setRefundStatus($refundStatus)
	{
		$this->refundStatus = $refundStatus;
	}

	public function setRefundTime($refundTime)
	{
		$this->refundTime = $refundTime;
	}

	public function setSubRefundInfoList($subRefundInfoList)
	{
		$this->subRefundInfoList = $subRefundInfoList;
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

}

class PddFlightCallbackConfirmRefundRequest_PassengerInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(Long, "refund_airport_tax")
	*/
	private $refundAirportTax;

	/**
	* @JsonProperty(Long, "refund_fee")
	*/
	private $refundFee;

	/**
	* @JsonProperty(Long, "refund_fuel_tax")
	*/
	private $refundFuelTax;

	/**
	* @JsonProperty(Long, "refund_settle_price")
	*/
	private $refundSettlePrice;

	/**
	* @JsonProperty(String, "sub_out_refund_no")
	*/
	private $subOutRefundNo;

	/**
	* @JsonProperty(String, "ticket_no")
	*/
	private $ticketNo;

	/**
	* @JsonProperty(String, "travel_sn")
	*/
	private $travelSn;

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setRefundAirportTax($refundAirportTax)
	{
		$this->refundAirportTax = $refundAirportTax;
	}

	public function setRefundFee($refundFee)
	{
		$this->refundFee = $refundFee;
	}

	public function setRefundFuelTax($refundFuelTax)
	{
		$this->refundFuelTax = $refundFuelTax;
	}

	public function setRefundSettlePrice($refundSettlePrice)
	{
		$this->refundSettlePrice = $refundSettlePrice;
	}

	public function setSubOutRefundNo($subOutRefundNo)
	{
		$this->subOutRefundNo = $subOutRefundNo;
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

class PddFlightCallbackConfirmRefundRequest_SubRefundInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "no")
	*/
	private $no;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightCallbackConfirmRefundRequest_SubRefundInfoListItemPassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	public function setNo($no)
	{
		$this->no = $no;
	}

	public function setPassengerInfoList($passengerInfoList)
	{
		$this->passengerInfoList = $passengerInfoList;
	}

}

class PddFlightCallbackConfirmRefundRequest_SubRefundInfoListItemPassengerInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(Long, "refund_airport_tax")
	*/
	private $refundAirportTax;

	/**
	* @JsonProperty(Long, "refund_fee")
	*/
	private $refundFee;

	/**
	* @JsonProperty(Long, "refund_fuel_tax")
	*/
	private $refundFuelTax;

	/**
	* @JsonProperty(Long, "refund_settle_price")
	*/
	private $refundSettlePrice;

	/**
	* @JsonProperty(String, "sub_out_refund_no")
	*/
	private $subOutRefundNo;

	/**
	* @JsonProperty(String, "ticket_no")
	*/
	private $ticketNo;

	/**
	* @JsonProperty(String, "travel_sn")
	*/
	private $travelSn;

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setRefundAirportTax($refundAirportTax)
	{
		$this->refundAirportTax = $refundAirportTax;
	}

	public function setRefundFee($refundFee)
	{
		$this->refundFee = $refundFee;
	}

	public function setRefundFuelTax($refundFuelTax)
	{
		$this->refundFuelTax = $refundFuelTax;
	}

	public function setRefundSettlePrice($refundSettlePrice)
	{
		$this->refundSettlePrice = $refundSettlePrice;
	}

	public function setSubOutRefundNo($subOutRefundNo)
	{
		$this->subOutRefundNo = $subOutRefundNo;
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
