<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddMallTicketNotifyRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "content")
	*/
	private $content;

	/**
	* @JsonProperty(Boolean, "syn_to_user")
	*/
	private $synToUser;

	/**
	* @JsonProperty(String, "ticket_id")
	*/
	private $ticketId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "content", $this->content);
		$this->setUserParam($params, "syn_to_user", $this->synToUser);
		$this->setUserParam($params, "ticket_id", $this->ticketId);

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
		return "pdd.mall.ticket.notify";
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setSynToUser($synToUser)
	{
		$this->synToUser = $synToUser;
	}

	public function setTicketId($ticketId)
	{
		$this->ticketId = $ticketId;
	}

}
