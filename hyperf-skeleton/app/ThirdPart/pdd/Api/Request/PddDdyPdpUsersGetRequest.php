<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdyPdpUsersGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "owner_id")
	*/
	private $ownerId;

	/**
	* @JsonProperty(String, "start_modified")
	*/
	private $startModified;

	/**
	* @JsonProperty(String, "end_modified")
	*/
	private $endModified;

	/**
	* @JsonProperty(Integer, "page_no")
	*/
	private $pageNo;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "owner_id", $this->ownerId);
		$this->setUserParam($params, "start_modified", $this->startModified);
		$this->setUserParam($params, "end_modified", $this->endModified);
		$this->setUserParam($params, "page_no", $this->pageNo);
		$this->setUserParam($params, "page_size", $this->pageSize);

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
		return "pdd.ddy.pdp.users.get";
	}

	public function setOwnerId($ownerId)
	{
		$this->ownerId = $ownerId;
	}

	public function setStartModified($startModified)
	{
		$this->startModified = $startModified;
	}

	public function setEndModified($endModified)
	{
		$this->endModified = $endModified;
	}

	public function setPageNo($pageNo)
	{
		$this->pageNo = $pageNo;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

}
