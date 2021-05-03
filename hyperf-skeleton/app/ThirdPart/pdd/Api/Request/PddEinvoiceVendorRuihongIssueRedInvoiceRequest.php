<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddEinvoiceVendorRuihongIssueRedInvoiceRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueRedInvoiceRequest_Request, "request")
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
		return "pdd.einvoice.vendor.ruihong.issue.red.invoice";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddEinvoiceVendorRuihongIssueRedInvoiceRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "serialNo")
	*/
	private $serialNo;

	/**
	* @JsonProperty(String, "postTime")
	*/
	private $postTime;

	/**
	* @JsonProperty(String, "originalCode")
	*/
	private $originalCode;

	/**
	* @JsonProperty(String, "reason")
	*/
	private $reason;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueRedInvoiceRequest_RequestItemsItem>, "items")
	*/
	private $items;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueRedInvoiceRequest_RequestExtendedParams, "extendedParams")
	*/
	private $extendedParams;

	/**
	* @JsonProperty(String, "appCode")
	*/
	private $appCode;

	/**
	* @JsonProperty(String, "cmdName")
	*/
	private $cmdName;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueRedInvoiceRequest_RequestDynamicParams, "dynamicParams")
	*/
	private $dynamicParams;

	public function setSerialNo($serialNo)
	{
		$this->serialNo = $serialNo;
	}

	public function setPostTime($postTime)
	{
		$this->postTime = $postTime;
	}

	public function setOriginalCode($originalCode)
	{
		$this->originalCode = $originalCode;
	}

	public function setReason($reason)
	{
		$this->reason = $reason;
	}

	public function setItems($items)
	{
		$this->items = $items;
	}

	public function setExtendedParams($extendedParams)
	{
		$this->extendedParams = $extendedParams;
	}

	public function setAppCode($appCode)
	{
		$this->appCode = $appCode;
	}

	public function setCmdName($cmdName)
	{
		$this->cmdName = $cmdName;
	}

	public function setDynamicParams($dynamicParams)
	{
		$this->dynamicParams = $dynamicParams;
	}

}

class PddEinvoiceVendorRuihongIssueRedInvoiceRequest_RequestItemsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "type")
	*/
	private $type;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "spec")
	*/
	private $spec;

	/**
	* @JsonProperty(String, "price")
	*/
	private $price;

	/**
	* @JsonProperty(String, "quantity")
	*/
	private $quantity;

	/**
	* @JsonProperty(String, "uom")
	*/
	private $uom;

	/**
	* @JsonProperty(String, "taxRate")
	*/
	private $taxRate;

	/**
	* @JsonProperty(String, "amount")
	*/
	private $amount;

	/**
	* @JsonProperty(String, "catalogCode")
	*/
	private $catalogCode;

	/**
	* @JsonProperty(String, "preferentialPolicyFlg")
	*/
	private $preferentialPolicyFlg;

	/**
	* @JsonProperty(String, "addedValueTaxFlg")
	*/
	private $addedValueTaxFlg;

	/**
	* @JsonProperty(String, "zeroTaxRateFlg")
	*/
	private $zeroTaxRateFlg;

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setSpec($spec)
	{
		$this->spec = $spec;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function setUom($uom)
	{
		$this->uom = $uom;
	}

	public function setTaxRate($taxRate)
	{
		$this->taxRate = $taxRate;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	public function setCatalogCode($catalogCode)
	{
		$this->catalogCode = $catalogCode;
	}

	public function setPreferentialPolicyFlg($preferentialPolicyFlg)
	{
		$this->preferentialPolicyFlg = $preferentialPolicyFlg;
	}

	public function setAddedValueTaxFlg($addedValueTaxFlg)
	{
		$this->addedValueTaxFlg = $addedValueTaxFlg;
	}

	public function setZeroTaxRateFlg($zeroTaxRateFlg)
	{
		$this->zeroTaxRateFlg = $zeroTaxRateFlg;
	}

}

class PddEinvoiceVendorRuihongIssueRedInvoiceRequest_RequestExtendedParams extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

}

class PddEinvoiceVendorRuihongIssueRedInvoiceRequest_RequestDynamicParams extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

}
