<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddWmsDepotTicketGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Boolean, "notAck")
	*/
	private $notAck;

	/**
	* @JsonProperty(Integer, "createdAtGte")
	*/
	private $createdAtGte;

	/**
	* @JsonProperty(Integer, "createdAtLte")
	*/
	private $createdAtLte;

	/**
	* @JsonProperty(Integer, "pageNum")
	*/
	private $pageNum;

	/**
	* @JsonProperty(Integer, "pageSize")
	*/
	private $pageSize;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "notAck", $this->notAck);
		$this->setUserParam($params, "createdAtGte", $this->createdAtGte);
		$this->setUserParam($params, "createdAtLte", $this->createdAtLte);
		$this->setUserParam($params, "pageNum", $this->pageNum);
		$this->setUserParam($params, "pageSize", $this->pageSize);

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
		return "pdd.wms.depot.ticket.get";
	}

	public function setNotAck($notAck)
	{
		$this->notAck = $notAck;
	}

	public function setCreatedAtGte($createdAtGte)
	{
		$this->createdAtGte = $createdAtGte;
	}

	public function setCreatedAtLte($createdAtLte)
	{
		$this->createdAtLte = $createdAtLte;
	}

	public function setPageNum($pageNum)
	{
		$this->pageNum = $pageNum;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

}
