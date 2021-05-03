<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightChangePayRequest extends PopBaseHttpRequest
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
	* @JsonProperty(String, "out_order_no")
	*/
	private $outOrderNo;

	/**
	* @JsonProperty(String, "parent_travel_sn")
	*/
	private $parentTravelSn;

	/**
	* @JsonProperty(String, "out_change_no")
	*/
	private $outChangeNo;

	/**
	* @JsonProperty(String, "change_date")
	*/
	private $changeDate;

	/**
	* @JsonProperty(Long, "total_pay_fee")
	*/
	private $totalPayFee;

	/**
	* @JsonProperty(Long, "total_pay")
	*/
	private $totalPay;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangePayRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "out_order_no", $this->outOrderNo);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "out_change_no", $this->outChangeNo);
		$this->setUserParam($params, "change_date", $this->changeDate);
		$this->setUserParam($params, "total_pay_fee", $this->totalPayFee);
		$this->setUserParam($params, "total_pay", $this->totalPay);
		$this->setUserParam($params, "passenger_info_list", $this->passengerInfoList);

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
		return "pdd.flight.change.pay";
	}

	public function setTraceId($traceId)
	{
		$this->traceId = $traceId;
	}

	public function setSubTraceId($subTraceId)
	{
		$this->subTraceId = $subTraceId;
	}

	public function setOutOrderNo($outOrderNo)
	{
		$this->outOrderNo = $outOrderNo;
	}

	public function setParentTravelSn($parentTravelSn)
	{
		$this->parentTravelSn = $parentTravelSn;
	}

	public function setOutChangeNo($outChangeNo)
	{
		$this->outChangeNo = $outChangeNo;
	}

	public function setChangeDate($changeDate)
	{
		$this->changeDate = $changeDate;
	}

	public function setTotalPayFee($totalPayFee)
	{
		$this->totalPayFee = $totalPayFee;
	}

	public function setTotalPay($totalPay)
	{
		$this->totalPay = $totalPay;
	}

	public function setPassengerInfoList($passengerInfoList)
	{
		$this->passengerInfoList = $passengerInfoList;
	}

}

class PddFlightChangePayRequest_PassengerInfoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

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
	* @JsonProperty(String, "sub_out_change_no")
	*/
	private $subOutChangeNo;

	/**
	* @JsonProperty(String, "travel_sn")
	*/
	private $travelSn;

	/**
	* @JsonProperty(String, "ticket_no")
	*/
	private $ticketNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangePayRequest_PassengerInfoListItemFlightListItem>, "flight_list")
	*/
	private $flightList;

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

	public function setSubOutChangeNo($subOutChangeNo)
	{
		$this->subOutChangeNo = $subOutChangeNo;
	}

	public function setTravelSn($travelSn)
	{
		$this->travelSn = $travelSn;
	}

	public function setTicketNo($ticketNo)
	{
		$this->ticketNo = $ticketNo;
	}

	public function setFlightList($flightList)
	{
		$this->flightList = $flightList;
	}

}

class PddFlightChangePayRequest_PassengerInfoListItemFlightListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "flight_no")
	*/
	private $flightNo;

	/**
	* @JsonProperty(Integer, "segment_no")
	*/
	private $segmentNo;

	/**
	* @JsonProperty(Integer, "sequence_no")
	*/
	private $sequenceNo;

	/**
	* @JsonProperty(String, "sub_class")
	*/
	private $subClass;

	public function setFlightNo($flightNo)
	{
		$this->flightNo = $flightNo;
	}

	public function setSegmentNo($segmentNo)
	{
		$this->segmentNo = $segmentNo;
	}

	public function setSequenceNo($sequenceNo)
	{
		$this->sequenceNo = $sequenceNo;
	}

	public function setSubClass($subClass)
	{
		$this->subClass = $subClass;
	}

}
