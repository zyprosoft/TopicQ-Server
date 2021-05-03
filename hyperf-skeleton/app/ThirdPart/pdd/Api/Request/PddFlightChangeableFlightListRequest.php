<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightChangeableFlightListRequest extends PopBaseHttpRequest
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
	* @JsonProperty(String, "parent_travel_sn")
	*/
	private $parentTravelSn;

	/**
	* @JsonProperty(String, "out_order_no")
	*/
	private $outOrderNo;

	/**
	* @JsonProperty(String, "change_date")
	*/
	private $changeDate;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangeableFlightListRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "trip_type", $this->tripType);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "out_order_no", $this->outOrderNo);
		$this->setUserParam($params, "change_date", $this->changeDate);
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
		return "pdd.flight.changeable.flight.list";
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

	public function setParentTravelSn($parentTravelSn)
	{
		$this->parentTravelSn = $parentTravelSn;
	}

	public function setOutOrderNo($outOrderNo)
	{
		$this->outOrderNo = $outOrderNo;
	}

	public function setChangeDate($changeDate)
	{
		$this->changeDate = $changeDate;
	}

	public function setPassengerInfoList($passengerInfoList)
	{
		$this->passengerInfoList = $passengerInfoList;
	}

}

class PddFlightChangeableFlightListRequest_PassengerInfoListItem extends PopBaseJsonEntity
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
	* @JsonProperty(String, "travel_sn")
	*/
	private $travelSn;

	/**
	* @JsonProperty(String, "ticket_no")
	*/
	private $ticketNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangeableFlightListRequest_PassengerInfoListItemFlightListItem>, "flight_list")
	*/
	private $flightList;

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

class PddFlightChangeableFlightListRequest_PassengerInfoListItemFlightListItem extends PopBaseJsonEntity
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
