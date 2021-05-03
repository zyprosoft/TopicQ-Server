<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKnockSyncSupplierOrgInfoRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSyncSupplierOrgInfoRequest_SyncRequest, "sync_request")
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
		return "pdd.knock.sync.supplier.org.info";
	}

	public function setSyncRequest($syncRequest)
	{
		$this->syncRequest = $syncRequest;
	}

}

class PddKnockSyncSupplierOrgInfoRequest_SyncRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSyncSupplierOrgInfoRequest_SyncRequestSupplierOrgSyncInfosItem>, "supplier_org_sync_infos")
	*/
	private $supplierOrgSyncInfos;

	public function setSupplierOrgSyncInfos($supplierOrgSyncInfos)
	{
		$this->supplierOrgSyncInfos = $supplierOrgSyncInfos;
	}

}

class PddKnockSyncSupplierOrgInfoRequest_SyncRequestSupplierOrgSyncInfosItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "org_name")
	*/
	private $orgName;

	/**
	* @JsonProperty(String, "org_number")
	*/
	private $orgNumber;

	/**
	* @JsonProperty(String, "org_short_name")
	*/
	private $orgShortName;

	/**
	* @JsonProperty(String, "supplier_org_sync_action")
	*/
	private $supplierOrgSyncAction;

	public function setOrgName($orgName)
	{
		$this->orgName = $orgName;
	}

	public function setOrgNumber($orgNumber)
	{
		$this->orgNumber = $orgNumber;
	}

	public function setOrgShortName($orgShortName)
	{
		$this->orgShortName = $orgShortName;
	}

	public function setSupplierOrgSyncAction($supplierOrgSyncAction)
	{
		$this->supplierOrgSyncAction = $supplierOrgSyncAction;
	}

}
