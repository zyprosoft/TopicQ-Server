<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTicketOrderCreateNotifycationRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Integer, "code_type")
	*/
	private $codeType;

	/**
	* @JsonProperty(Integer, "failed_code")
	*/
	private $failedCode;

	/**
	* @JsonProperty(String, "failed_reason")
	*/
	private $failedReason;

	/**
	* @JsonProperty(String, "order_no")
	*/
	private $orderNo;

	/**
	* @JsonProperty(String, "out_order_sn")
	*/
	private $outOrderSn;

	/**
	* @JsonProperty(Integer, "status")
	*/
	private $status;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTicketOrderCreateNotifycationRequest_TicketsItem>, "tickets")
	*/
	private $tickets;

	/**
	* @JsonProperty(Integer, "ticket_type")
	*/
	private $ticketType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "code_type", $this->codeType);
		$this->setUserParam($params, "failed_code", $this->failedCode);
		$this->setUserParam($params, "failed_reason", $this->failedReason);
		$this->setUserParam($params, "order_no", $this->orderNo);
		$this->setUserParam($params, "out_order_sn", $this->outOrderSn);
		$this->setUserParam($params, "status", $this->status);
		$this->setUserParam($params, "tickets", $this->tickets);
		$this->setUserParam($params, "ticket_type", $this->ticketType);

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
		return "pdd.ticket.order.create.notifycation";
	}

	public function setCodeType($codeType)
	{
		$this->codeType = $codeType;
	}

	public function setFailedCode($failedCode)
	{
		$this->failedCode = $failedCode;
	}

	public function setFailedReason($failedReason)
	{
		$this->failedReason = $failedReason;
	}

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
	}

	public function setOutOrderSn($outOrderSn)
	{
		$this->outOrderSn = $outOrderSn;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setTickets($tickets)
	{
		$this->tickets = $tickets;
	}

	public function setTicketType($ticketType)
	{
		$this->ticketType = $ticketType;
	}

}

class PddTicketOrderCreateNotifycationRequest_TicketsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "additional")
	*/
	private $additional;

	/**
	* @JsonProperty(String, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "file")
	*/
	private $file;

	/**
	* @JsonProperty(String, "url")
	*/
	private $url;

	public function setAdditional($additional)
	{
		$this->additional = $additional;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setFile($file)
	{
		$this->file = $file;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

}
