<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkCashgiftStatusUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "cash_gift_id")
	*/
	private $cashGiftId;

	/**
	* @JsonProperty(Integer, "update_type")
	*/
	private $updateType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cash_gift_id", $this->cashGiftId);
		$this->setUserParam($params, "update_type", $this->updateType);

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
		return "pdd.ddk.cashgift.status.update";
	}

	public function setCashGiftId($cashGiftId)
	{
		$this->cashGiftId = $cashGiftId;
	}

	public function setUpdateType($updateType)
	{
		$this->updateType = $updateType;
	}

}
