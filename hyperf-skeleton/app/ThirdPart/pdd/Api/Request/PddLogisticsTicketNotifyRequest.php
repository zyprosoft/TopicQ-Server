<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddLogisticsTicketNotifyRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<String>, "attach_path_list")
	*/
	private $attachPathList;

	/**
	* @JsonProperty(Long, "ticket_id")
	*/
	private $ticketId;

	/**
	* @JsonProperty(String, "waybill_no")
	*/
	private $waybillNo;

	/**
	* @JsonProperty(String, "handle_result")
	*/
	private $handleResult;

	/**
	* @JsonProperty(Integer, "sign_state")
	*/
	private $signState;

	/**
	* @JsonProperty(Integer, "compensate_state")
	*/
	private $compensateState;

	/**
	* @JsonProperty(Long, "compensate_amount")
	*/
	private $compensateAmount;

	/**
	* @JsonProperty(Integer, "duty")
	*/
	private $duty;

	/**
	* @JsonProperty(String, "express_dealer")
	*/
	private $expressDealer;

	/**
	* @JsonProperty(String, "express_dealer_contact")
	*/
	private $expressDealerContact;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "attach_path_list", $this->attachPathList);
		$this->setUserParam($params, "ticket_id", $this->ticketId);
		$this->setUserParam($params, "waybill_no", $this->waybillNo);
		$this->setUserParam($params, "handle_result", $this->handleResult);
		$this->setUserParam($params, "sign_state", $this->signState);
		$this->setUserParam($params, "compensate_state", $this->compensateState);
		$this->setUserParam($params, "compensate_amount", $this->compensateAmount);
		$this->setUserParam($params, "duty", $this->duty);
		$this->setUserParam($params, "express_dealer", $this->expressDealer);
		$this->setUserParam($params, "express_dealer_contact", $this->expressDealerContact);

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
		return "pdd.logistics.ticket.notify";
	}

	public function setAttachPathList($attachPathList)
	{
		$this->attachPathList = $attachPathList;
	}

	public function setTicketId($ticketId)
	{
		$this->ticketId = $ticketId;
	}

	public function setWaybillNo($waybillNo)
	{
		$this->waybillNo = $waybillNo;
	}

	public function setHandleResult($handleResult)
	{
		$this->handleResult = $handleResult;
	}

	public function setSignState($signState)
	{
		$this->signState = $signState;
	}

	public function setCompensateState($compensateState)
	{
		$this->compensateState = $compensateState;
	}

	public function setCompensateAmount($compensateAmount)
	{
		$this->compensateAmount = $compensateAmount;
	}

	public function setDuty($duty)
	{
		$this->duty = $duty;
	}

	public function setExpressDealer($expressDealer)
	{
		$this->expressDealer = $expressDealer;
	}

	public function setExpressDealerContact($expressDealerContact)
	{
		$this->expressDealerContact = $expressDealerContact;
	}

}
