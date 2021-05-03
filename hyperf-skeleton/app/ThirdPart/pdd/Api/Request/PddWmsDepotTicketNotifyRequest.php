<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsDepotTicketNotifyRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "ticketId")
	*/
	private $ticketId;

	/**
	* @JsonProperty(String, "content")
	*/
	private $content;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddWmsDepotTicketNotifyRequest_AttachUrlItem>, "attachUrl")
	*/
	private $attachUrl;

	/**
	* @JsonProperty(Integer, "serviceStatus")
	*/
	private $serviceStatus;

	/**
	* @JsonProperty(Integer, "compensateAmount")
	*/
	private $compensateAmount;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "ticketId", $this->ticketId);
		$this->setUserParam($params, "content", $this->content);
		$this->setUserParam($params, "attachUrl", $this->attachUrl);
		$this->setUserParam($params, "serviceStatus", $this->serviceStatus);
		$this->setUserParam($params, "compensateAmount", $this->compensateAmount);

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
		return "pdd.wms.depot.ticket.notify";
	}

	public function setTicketId($ticketId)
	{
		$this->ticketId = $ticketId;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setAttachUrl($attachUrl)
	{
		$this->attachUrl = $attachUrl;
	}

	public function setServiceStatus($serviceStatus)
	{
		$this->serviceStatus = $serviceStatus;
	}

	public function setCompensateAmount($compensateAmount)
	{
		$this->compensateAmount = $compensateAmount;
	}

}

class PddWmsDepotTicketNotifyRequest_AttachUrlItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "url")
	*/
	private $url;

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

}
