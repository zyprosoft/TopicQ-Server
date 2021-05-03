<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddEinvoiceVendorRuihongIssueInvoiceRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueInvoiceRequest_Request, "request")
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
		return "pdd.einvoice.vendor.ruihong.issue.invoice";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddEinvoiceVendorRuihongIssueInvoiceRequest_Request extends PopBaseJsonEntity
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
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestOrder, "order")
	*/
	private $order;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestInvoice, "invoice")
	*/
	private $invoice;

	/**
	* @JsonProperty(String, "appCode")
	*/
	private $appCode;

	/**
	* @JsonProperty(String, "cmdName")
	*/
	private $cmdName;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestExtendedParams, "extendedParams")
	*/
	private $extendedParams;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestDynamicParams, "dynamicParams")
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

	public function setOrder($order)
	{
		$this->order = $order;
	}

	public function setInvoice($invoice)
	{
		$this->invoice = $invoice;
	}

	public function setAppCode($appCode)
	{
		$this->appCode = $appCode;
	}

	public function setCmdName($cmdName)
	{
		$this->cmdName = $cmdName;
	}

	public function setExtendedParams($extendedParams)
	{
		$this->extendedParams = $extendedParams;
	}

	public function setDynamicParams($dynamicParams)
	{
		$this->dynamicParams = $dynamicParams;
	}

}

class PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestOrder extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "orderNo")
	*/
	private $orderNo;

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
	}

}

class PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestInvoice extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "taxpayerCode")
	*/
	private $taxpayerCode;

	/**
	* @JsonProperty(String, "taxpayerName")
	*/
	private $taxpayerName;

	/**
	* @JsonProperty(String, "taxpayerAddress")
	*/
	private $taxpayerAddress;

	/**
	* @JsonProperty(String, "taxpayerTel")
	*/
	private $taxpayerTel;

	/**
	* @JsonProperty(String, "taxpayerBankName")
	*/
	private $taxpayerBankName;

	/**
	* @JsonProperty(String, "taxpayerBankAccount")
	*/
	private $taxpayerBankAccount;

	/**
	* @JsonProperty(String, "customerName")
	*/
	private $customerName;

	/**
	* @JsonProperty(String, "customerCode")
	*/
	private $customerCode;

	/**
	* @JsonProperty(String, "customerAddress")
	*/
	private $customerAddress;

	/**
	* @JsonProperty(String, "customerTel")
	*/
	private $customerTel;

	/**
	* @JsonProperty(String, "customerBankName")
	*/
	private $customerBankName;

	/**
	* @JsonProperty(String, "customerBankAccount")
	*/
	private $customerBankAccount;

	/**
	* @JsonProperty(String, "invoiceType")
	*/
	private $invoiceType;

	/**
	* @JsonProperty(String, "drawer")
	*/
	private $drawer;

	/**
	* @JsonProperty(String, "payee")
	*/
	private $payee;

	/**
	* @JsonProperty(String, "reviewer")
	*/
	private $reviewer;

	/**
	* @JsonProperty(String, "totalAmount")
	*/
	private $totalAmount;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestInvoiceItemsItem>, "items")
	*/
	private $items;

	public function setTaxpayerCode($taxpayerCode)
	{
		$this->taxpayerCode = $taxpayerCode;
	}

	public function setTaxpayerName($taxpayerName)
	{
		$this->taxpayerName = $taxpayerName;
	}

	public function setTaxpayerAddress($taxpayerAddress)
	{
		$this->taxpayerAddress = $taxpayerAddress;
	}

	public function setTaxpayerTel($taxpayerTel)
	{
		$this->taxpayerTel = $taxpayerTel;
	}

	public function setTaxpayerBankName($taxpayerBankName)
	{
		$this->taxpayerBankName = $taxpayerBankName;
	}

	public function setTaxpayerBankAccount($taxpayerBankAccount)
	{
		$this->taxpayerBankAccount = $taxpayerBankAccount;
	}

	public function setCustomerName($customerName)
	{
		$this->customerName = $customerName;
	}

	public function setCustomerCode($customerCode)
	{
		$this->customerCode = $customerCode;
	}

	public function setCustomerAddress($customerAddress)
	{
		$this->customerAddress = $customerAddress;
	}

	public function setCustomerTel($customerTel)
	{
		$this->customerTel = $customerTel;
	}

	public function setCustomerBankName($customerBankName)
	{
		$this->customerBankName = $customerBankName;
	}

	public function setCustomerBankAccount($customerBankAccount)
	{
		$this->customerBankAccount = $customerBankAccount;
	}

	public function setInvoiceType($invoiceType)
	{
		$this->invoiceType = $invoiceType;
	}

	public function setDrawer($drawer)
	{
		$this->drawer = $drawer;
	}

	public function setPayee($payee)
	{
		$this->payee = $payee;
	}

	public function setReviewer($reviewer)
	{
		$this->reviewer = $reviewer;
	}

	public function setTotalAmount($totalAmount)
	{
		$this->totalAmount = $totalAmount;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	public function setItems($items)
	{
		$this->items = $items;
	}

}

class PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestInvoiceItemsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "type")
	*/
	private $type;

	/**
	* @JsonProperty(String, "catalogCode")
	*/
	private $catalogCode;

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

	public function setCatalogCode($catalogCode)
	{
		$this->catalogCode = $catalogCode;
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

class PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestExtendedParams extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

}

class PddEinvoiceVendorRuihongIssueInvoiceRequest_RequestDynamicParams extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

}
