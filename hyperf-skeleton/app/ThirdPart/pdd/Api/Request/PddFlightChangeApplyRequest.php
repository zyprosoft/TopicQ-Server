<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFlightChangeApplyRequest extends PopBaseHttpRequest
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
	* @JsonProperty(String, "change_date")
	*/
	private $changeDate;

	/**
	* @JsonProperty(String, "attachment_path")
	*/
	private $attachmentPath;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangeApplyRequest_PassengerInfoListItem>, "passenger_info_list")
	*/
	private $passengerInfoList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangeApplyRequest_FlightInfoListItem>, "flight_info_list")
	*/
	private $flightInfoList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "trace_id", $this->traceId);
		$this->setUserParam($params, "sub_trace_id", $this->subTraceId);
		$this->setUserParam($params, "out_order_no", $this->outOrderNo);
		$this->setUserParam($params, "parent_travel_sn", $this->parentTravelSn);
		$this->setUserParam($params, "change_date", $this->changeDate);
		$this->setUserParam($params, "attachment_path", $this->attachmentPath);
		$this->setUserParam($params, "passenger_info_list", $this->passengerInfoList);
		$this->setUserParam($params, "flight_info_list", $this->flightInfoList);

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
		return "pdd.flight.change.apply";
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

	public function setChangeDate($changeDate)
	{
		$this->changeDate = $changeDate;
	}

	public function setAttachmentPath($attachmentPath)
	{
		$this->attachmentPath = $attachmentPath;
	}

	public function setPassengerInfoList($passengerInfoList)
	{
		$this->passengerInfoList = $passengerInfoList;
	}

	public function setFlightInfoList($flightInfoList)
	{
		$this->flightInfoList = $flightInfoList;
	}

}

class PddFlightChangeApplyRequest_PassengerInfoListItem extends PopBaseJsonEntity
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
	* @JsonProperty(String, "old_travel_sn")
	*/
	private $oldTravelSn;

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

	public function setOldTravelSn($oldTravelSn)
	{
		$this->oldTravelSn = $oldTravelSn;
	}

}

class PddFlightChangeApplyRequest_FlightInfoListItem extends PopBaseJsonEntity
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFlightChangeApplyRequest_FlightInfoListItemCabinInfoListItem>, "cabin_info_list")
	*/
	private $cabinInfoList;

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

	public function setCabinInfoList($cabinInfoList)
	{
		$this->cabinInfoList = $cabinInfoList;
	}

}

class PddFlightChangeApplyRequest_FlightInfoListItemCabinInfoListItem extends PopBaseJsonEntity
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
