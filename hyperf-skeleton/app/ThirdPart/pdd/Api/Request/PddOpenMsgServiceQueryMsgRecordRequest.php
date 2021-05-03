<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOpenMsgServiceQueryMsgRecordRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "biz_id")
	*/
	private $bizId;

	/**
	* @JsonProperty(Integer, "page_number")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(String, "phone_number")
	*/
	private $phoneNumber;

	/**
	* @JsonProperty(String, "send_date")
	*/
	private $sendDate;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "biz_id", $this->bizId);
		$this->setUserParam($params, "page_number", $this->pageNumber);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "phone_number", $this->phoneNumber);
		$this->setUserParam($params, "send_date", $this->sendDate);

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
		return "pdd.open.msg.service.query.msg.record";
	}

	public function setBizId($bizId)
	{
		$this->bizId = $bizId;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setPhoneNumber($phoneNumber)
	{
		$this->phoneNumber = $phoneNumber;
	}

	public function setSendDate($sendDate)
	{
		$this->sendDate = $sendDate;
	}

}
