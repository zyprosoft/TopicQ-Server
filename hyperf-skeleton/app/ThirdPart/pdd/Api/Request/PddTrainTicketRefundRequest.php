<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTrainTicketRefundRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "sub_order_id")
	*/
	private $subOrderId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "sub_order_id", $this->subOrderId);

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
		return "pdd.train.ticket.refund";
	}

	public function setSubOrderId($subOrderId)
	{
		$this->subOrderId = $subOrderId;
	}

}
