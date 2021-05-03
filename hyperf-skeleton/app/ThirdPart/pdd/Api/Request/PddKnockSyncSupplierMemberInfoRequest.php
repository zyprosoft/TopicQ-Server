<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKnockSyncSupplierMemberInfoRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSyncSupplierMemberInfoRequest_SyncRequest, "sync_request")
	*/
	private $syncRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "sync_request", $this->syncRequest);

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
		return "pdd.knock.sync.supplier.member.info";
	}

	public function setSyncRequest($syncRequest)
	{
		$this->syncRequest = $syncRequest;
	}

}

class PddKnockSyncSupplierMemberInfoRequest_SyncRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSyncSupplierMemberInfoRequest_SyncRequestSupplierMemberSyncInfosItem>, "supplier_member_sync_infos")
	*/
	private $supplierMemberSyncInfos;

	public function setSupplierMemberSyncInfos($supplierMemberSyncInfos)
	{
		$this->supplierMemberSyncInfos = $supplierMemberSyncInfos;
	}

}

class PddKnockSyncSupplierMemberInfoRequest_SyncRequestSupplierMemberSyncInfosItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "email")
	*/
	private $email;

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "org_number")
	*/
	private $orgNumber;

	/**
	* @JsonProperty(String, "sync_action")
	*/
	private $syncAction;

	/**
	* @JsonProperty(Boolean, "temp_user")
	*/
	private $tempUser;

	/**
	* @JsonProperty(String, "user_number")
	*/
	private $userNumber;

	/**
	* @JsonProperty(String, "encrypted_job_id")
	*/
	private $encryptedJobId;

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setOrgNumber($orgNumber)
	{
		$this->orgNumber = $orgNumber;
	}

	public function setSyncAction($syncAction)
	{
		$this->syncAction = $syncAction;
	}

	public function setTempUser($tempUser)
	{
		$this->tempUser = $tempUser;
	}

	public function setUserNumber($userNumber)
	{
		$this->userNumber = $userNumber;
	}

	public function setEncryptedJobId($encryptedJobId)
	{
		$this->encryptedJobId = $encryptedJobId;
	}

}
