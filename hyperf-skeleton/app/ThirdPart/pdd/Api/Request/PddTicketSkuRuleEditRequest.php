<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTicketSkuRuleEditRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_BookerInfoLimitation, "booker_info_limitation")
	*/
	private $bookerInfoLimitation;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_BookingNotice, "booking_notice")
	*/
	private $bookingNotice;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_OrderLimitation, "order_limitation")
	*/
	private $orderLimitation;

	/**
	* @JsonProperty(String, "out_rule_id")
	*/
	private $outRuleId;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_ProviderContactInfo, "provider_contact_info")
	*/
	private $providerContactInfo;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_RefundLimitations, "refund_limitations")
	*/
	private $refundLimitations;

	/**
	* @JsonProperty(String, "rule_id")
	*/
	private $ruleId;

	/**
	* @JsonProperty(String, "rule_name")
	*/
	private $ruleName;

	/**
	* @JsonProperty(String, "rule_version")
	*/
	private $ruleVersion;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_TravelerInfoLimitation, "traveler_info_limitation")
	*/
	private $travelerInfoLimitation;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_ValidLimitation, "valid_limitation")
	*/
	private $validLimitation;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "booker_info_limitation", $this->bookerInfoLimitation);
		$this->setUserParam($params, "booking_notice", $this->bookingNotice);
		$this->setUserParam($params, "order_limitation", $this->orderLimitation);
		$this->setUserParam($params, "out_rule_id", $this->outRuleId);
		$this->setUserParam($params, "provider_contact_info", $this->providerContactInfo);
		$this->setUserParam($params, "refund_limitations", $this->refundLimitations);
		$this->setUserParam($params, "rule_id", $this->ruleId);
		$this->setUserParam($params, "rule_name", $this->ruleName);
		$this->setUserParam($params, "rule_version", $this->ruleVersion);
		$this->setUserParam($params, "traveler_info_limitation", $this->travelerInfoLimitation);
		$this->setUserParam($params, "valid_limitation", $this->validLimitation);

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
		return "pdd.ticket.sku.rule.edit";
	}

	public function setBookerInfoLimitation($bookerInfoLimitation)
	{
		$this->bookerInfoLimitation = $bookerInfoLimitation;
	}

	public function setBookingNotice($bookingNotice)
	{
		$this->bookingNotice = $bookingNotice;
	}

	public function setOrderLimitation($orderLimitation)
	{
		$this->orderLimitation = $orderLimitation;
	}

	public function setOutRuleId($outRuleId)
	{
		$this->outRuleId = $outRuleId;
	}

	public function setProviderContactInfo($providerContactInfo)
	{
		$this->providerContactInfo = $providerContactInfo;
	}

	public function setRefundLimitations($refundLimitations)
	{
		$this->refundLimitations = $refundLimitations;
	}

	public function setRuleId($ruleId)
	{
		$this->ruleId = $ruleId;
	}

	public function setRuleName($ruleName)
	{
		$this->ruleName = $ruleName;
	}

	public function setRuleVersion($ruleVersion)
	{
		$this->ruleVersion = $ruleVersion;
	}

	public function setTravelerInfoLimitation($travelerInfoLimitation)
	{
		$this->travelerInfoLimitation = $travelerInfoLimitation;
	}

	public function setValidLimitation($validLimitation)
	{
		$this->validLimitation = $validLimitation;
	}

}

class PddTicketSkuRuleEditRequest_BookerInfoLimitation extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "booker_required")
	*/
	private $bookerRequired;

	/**
	* @JsonProperty(Integer, "mobile")
	*/
	private $mobile;

	public function setBookerRequired($bookerRequired)
	{
		$this->bookerRequired = $bookerRequired;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

}

class PddTicketSkuRuleEditRequest_BookingNotice extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "enter_address")
	*/
	private $enterAddress;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_BookingNoticeEnterTimeItem>, "enter_time")
	*/
	private $enterTime;

	/**
	* @JsonProperty(String, "enter_ways")
	*/
	private $enterWays;

	/**
	* @JsonProperty(String, "extra_desc")
	*/
	private $extraDesc;

	/**
	* @JsonProperty(String, "fee_include")
	*/
	private $feeInclude;

	/**
	* @JsonProperty(String, "fee_not_include")
	*/
	private $feeNotInclude;

	/**
	* @JsonProperty(String, "important_notice")
	*/
	private $importantNotice;

	/**
	* @JsonProperty(Integer, "pass_time_limit")
	*/
	private $passTimeLimit;

	/**
	* @JsonProperty(String, "ticket_place")
	*/
	private $ticketPlace;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_BookingNoticeTicketTimeItem>, "ticket_time")
	*/
	private $ticketTime;

	public function setEnterAddress($enterAddress)
	{
		$this->enterAddress = $enterAddress;
	}

	public function setEnterTime($enterTime)
	{
		$this->enterTime = $enterTime;
	}

	public function setEnterWays($enterWays)
	{
		$this->enterWays = $enterWays;
	}

	public function setExtraDesc($extraDesc)
	{
		$this->extraDesc = $extraDesc;
	}

	public function setFeeInclude($feeInclude)
	{
		$this->feeInclude = $feeInclude;
	}

	public function setFeeNotInclude($feeNotInclude)
	{
		$this->feeNotInclude = $feeNotInclude;
	}

	public function setImportantNotice($importantNotice)
	{
		$this->importantNotice = $importantNotice;
	}

	public function setPassTimeLimit($passTimeLimit)
	{
		$this->passTimeLimit = $passTimeLimit;
	}

	public function setTicketPlace($ticketPlace)
	{
		$this->ticketPlace = $ticketPlace;
	}

	public function setTicketTime($ticketTime)
	{
		$this->ticketTime = $ticketTime;
	}

}

class PddTicketSkuRuleEditRequest_BookingNoticeEnterTimeItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "comment")
	*/
	private $comment;

	/**
	* @JsonProperty(String, "end_at")
	*/
	private $endAt;

	/**
	* @JsonProperty(String, "start_at")
	*/
	private $startAt;

	public function setComment($comment)
	{
		$this->comment = $comment;
	}

	public function setEndAt($endAt)
	{
		$this->endAt = $endAt;
	}

	public function setStartAt($startAt)
	{
		$this->startAt = $startAt;
	}

}

class PddTicketSkuRuleEditRequest_BookingNoticeTicketTimeItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "comment")
	*/
	private $comment;

	/**
	* @JsonProperty(String, "end_at")
	*/
	private $endAt;

	/**
	* @JsonProperty(String, "start_at")
	*/
	private $startAt;

	public function setComment($comment)
	{
		$this->comment = $comment;
	}

	public function setEndAt($endAt)
	{
		$this->endAt = $endAt;
	}

	public function setStartAt($startAt)
	{
		$this->startAt = $startAt;
	}

}

class PddTicketSkuRuleEditRequest_OrderLimitation extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "cycle_length")
	*/
	private $cycleLength;

	/**
	* @JsonProperty(Integer, "limitation_type")
	*/
	private $limitationType;

	/**
	* @JsonProperty(Integer, "limit_cycle")
	*/
	private $limitCycle;

	/**
	* @JsonProperty(Integer, "limit_num")
	*/
	private $limitNum;

	public function setCycleLength($cycleLength)
	{
		$this->cycleLength = $cycleLength;
	}

	public function setLimitationType($limitationType)
	{
		$this->limitationType = $limitationType;
	}

	public function setLimitCycle($limitCycle)
	{
		$this->limitCycle = $limitCycle;
	}

	public function setLimitNum($limitNum)
	{
		$this->limitNum = $limitNum;
	}

}

class PddTicketSkuRuleEditRequest_ProviderContactInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_ProviderContactInfoProviderBusinessHourItem>, "provider_business_hour")
	*/
	private $providerBusinessHour;

	/**
	* @JsonProperty(String, "provider_name")
	*/
	private $providerName;

	/**
	* @JsonProperty(String, "provider_telephone")
	*/
	private $providerTelephone;

	public function setProviderBusinessHour($providerBusinessHour)
	{
		$this->providerBusinessHour = $providerBusinessHour;
	}

	public function setProviderName($providerName)
	{
		$this->providerName = $providerName;
	}

	public function setProviderTelephone($providerTelephone)
	{
		$this->providerTelephone = $providerTelephone;
	}

}

class PddTicketSkuRuleEditRequest_ProviderContactInfoProviderBusinessHourItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "close_at")
	*/
	private $closeAt;

	/**
	* @JsonProperty(String, "open_at")
	*/
	private $openAt;

	/**
	* @JsonProperty(String, "time_info")
	*/
	private $timeInfo;

	public function setCloseAt($closeAt)
	{
		$this->closeAt = $closeAt;
	}

	public function setOpenAt($openAt)
	{
		$this->openAt = $openAt;
	}

	public function setTimeInfo($timeInfo)
	{
		$this->timeInfo = $timeInfo;
	}

}

class PddTicketSkuRuleEditRequest_RefundLimitations extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "is_refundable")
	*/
	private $isRefundable;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketSkuRuleEditRequest_RefundLimitationsRefundRulesItem>, "refund_rules")
	*/
	private $refundRules;

	public function setIsRefundable($isRefundable)
	{
		$this->isRefundable = $isRefundable;
	}

	public function setRefundRules($refundRules)
	{
		$this->refundRules = $refundRules;
	}

}

class PddTicketSkuRuleEditRequest_RefundLimitationsRefundRulesItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "ahead_time")
	*/
	private $aheadTime;

	/**
	* @JsonProperty(Integer, "deduction_fee")
	*/
	private $deductionFee;

	/**
	* @JsonProperty(Integer, "deduction_unit")
	*/
	private $deductionUnit;

	/**
	* @JsonProperty(Integer, "type")
	*/
	private $type;

	public function setAheadTime($aheadTime)
	{
		$this->aheadTime = $aheadTime;
	}

	public function setDeductionFee($deductionFee)
	{
		$this->deductionFee = $deductionFee;
	}

	public function setDeductionUnit($deductionUnit)
	{
		$this->deductionUnit = $deductionUnit;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

}

class PddTicketSkuRuleEditRequest_TravelerInfoLimitation extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "credential")
	*/
	private $credential;

	/**
	* @JsonProperty(Integer, "name")
	*/
	private $name;

	/**
	* @JsonProperty(Integer, "traveler_required")
	*/
	private $travelerRequired;

	public function setCredential($credential)
	{
		$this->credential = $credential;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setTravelerRequired($travelerRequired)
	{
		$this->travelerRequired = $travelerRequired;
	}

}

class PddTicketSkuRuleEditRequest_ValidLimitation extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "days_time")
	*/
	private $daysTime;

	/**
	* @JsonProperty(Long, "end_time")
	*/
	private $endTime;

	/**
	* @JsonProperty(Long, "start_time")
	*/
	private $startTime;

	/**
	* @JsonProperty(Integer, "time_type")
	*/
	private $timeType;

	public function setDaysTime($daysTime)
	{
		$this->daysTime = $daysTime;
	}

	public function setEndTime($endTime)
	{
		$this->endTime = $endTime;
	}

	public function setStartTime($startTime)
	{
		$this->startTime = $startTime;
	}

	public function setTimeType($timeType)
	{
		$this->timeType = $timeType;
	}

}
