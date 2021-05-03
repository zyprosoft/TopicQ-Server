<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsDepotTicketAckRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<Long>, "ticketIds")
	*/
	private $ticketIds;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "ticketIds", $this->ticketIds);

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
		return "pdd.wms.depot.ticket.ack";
	}

	public function setTicketIds($ticketIds)
	{
		$this->ticketIds = $ticketIds;
	}

}
