<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKnockSupplierChangeUserNumberRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSupplierChangeUserNumberRequest_SupplierChangeUserNumberRequest, "supplier_change_user_number_request")
	*/
	private $supplierChangeUserNumberRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "supplier_change_user_number_request", $this->supplierChangeUserNumberRequest);

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
		return "pdd.knock.supplier.change.user.number";
	}

	public function setSupplierChangeUserNumberRequest($supplierChangeUserNumberRequest)
	{
		$this->supplierChangeUserNumberRequest = $supplierChangeUserNumberRequest;
	}

}

class PddKnockSupplierChangeUserNumberRequest_SupplierChangeUserNumberRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "new_user_number")
	*/
	private $newUserNumber;

	/**
	* @JsonProperty(String, "old_user_number")
	*/
	private $oldUserNumber;

	public function setNewUserNumber($newUserNumber)
	{
		$this->newUserNumber = $newUserNumber;
	}

	public function setOldUserNumber($oldUserNumber)
	{
		$this->oldUserNumber = $oldUserNumber;
	}

}
