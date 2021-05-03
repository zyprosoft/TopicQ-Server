<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKnockSupplierQueryMemberInfoByUserNumberRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSupplierQueryMemberInfoByUserNumberRequest_Request, "request")
	*/
	private $request;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "request", $this->request);

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
		return "pdd.knock.supplier.query.member.info.by.user.number";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddKnockSupplierQueryMemberInfoByUserNumberRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<String>, "user_numbers")
	*/
	private $userNumbers;

	public function setUserNumbers($userNumbers)
	{
		$this->userNumbers = $userNumbers;
	}

}
