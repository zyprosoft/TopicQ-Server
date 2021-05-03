<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddEinvoiceIssueInvoiceResultCallbackRuihongRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceIssueInvoiceResultCallbackRuihongRequest_Data, "data")
	*/
	private $data;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "data", $this->data);

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
		return "pdd.einvoice.issue.invoice.result.callback.ruihong";
	}

	public function setData($data)
	{
		$this->data = $data;
	}

}

class PddEinvoiceIssueInvoiceResultCallbackRuihongRequest_Data extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "einvoiceApiVersion")
	*/
	private $einvoiceApiVersion;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceIssueInvoiceResultCallbackRuihongRequest_DataInvoice, "invoice")
	*/
	private $invoice;

	/**
	* @JsonProperty(String, "mallId")
	*/
	private $mallId;

	/**
	* @JsonProperty(String, "message")
	*/
	private $message;

	/**
	* @JsonProperty(String, "orderNo")
	*/
	private $orderNo;

	/**
	* @JsonProperty(String, "serialNo")
	*/
	private $serialNo;

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setEinvoiceApiVersion($einvoiceApiVersion)
	{
		$this->einvoiceApiVersion = $einvoiceApiVersion;
	}

	public function setInvoice($invoice)
	{
		$this->invoice = $invoice;
	}

	public function setMallId($mallId)
	{
		$this->mallId = $mallId;
	}

	public function setMessage($message)
	{
		$this->message = $message;
	}

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
	}

	public function setSerialNo($serialNo)
	{
		$this->serialNo = $serialNo;
	}

}

class PddEinvoiceIssueInvoiceResultCallbackRuihongRequest_DataInvoice extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "checkCode")
	*/
	private $checkCode;

	/**
	* @JsonProperty(String, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "customerAddress")
	*/
	private $customerAddress;

	/**
	* @JsonProperty(String, "customerBankAccount")
	*/
	private $customerBankAccount;

	/**
	* @JsonProperty(String, "customerBankName")
	*/
	private $customerBankName;

	/**
	* @JsonProperty(String, "customerCode")
	*/
	private $customerCode;

	/**
	* @JsonProperty(String, "customerName")
	*/
	private $customerName;

	/**
	* @JsonProperty(String, "customerTel")
	*/
	private $customerTel;

	/**
	* @JsonProperty(String, "drawer")
	*/
	private $drawer;

	/**
	* @JsonProperty(String, "fiscalCode")
	*/
	private $fiscalCode;

	/**
	* @JsonProperty(String, "generateTime")
	*/
	private $generateTime;

	/**
	* @JsonProperty(String, "invPdf")
	*/
	private $invPdf;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddEinvoiceIssueInvoiceResultCallbackRuihongRequest_DataInvoiceItemsItem>, "items")
	*/
	private $items;

	/**
	* @JsonProperty(String, "noTaxAmount")
	*/
	private $noTaxAmount;

	/**
	* @JsonProperty(String, "orderNo")
	*/
	private $orderNo;

	/**
	* @JsonProperty(String, "payee")
	*/
	private $payee;

	/**
	* @JsonProperty(String, "pdfUnsignedUrl")
	*/
	private $pdfUnsignedUrl;

	/**
	* @JsonProperty(String, "relatedCode")
	*/
	private $relatedCode;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	/**
	* @JsonProperty(String, "reviewer")
	*/
	private $reviewer;

	/**
	* @JsonProperty(String, "status")
	*/
	private $status;

	/**
	* @JsonProperty(String, "taxAmount")
	*/
	private $taxAmount;

	/**
	* @JsonProperty(String, "taxDeviceNo")
	*/
	private $taxDeviceNo;

	/**
	* @JsonProperty(String, "taxpayerAddress")
	*/
	private $taxpayerAddress;

	/**
	* @JsonProperty(String, "taxpayerBankAccount")
	*/
	private $taxpayerBankAccount;

	/**
	* @JsonProperty(String, "taxpayerBankName")
	*/
	private $taxpayerBankName;

	/**
	* @JsonProperty(String, "taxpayerCode")
	*/
	private $taxpayerCode;

	/**
	* @JsonProperty(String, "taxpayerName")
	*/
	private $taxpayerName;

	/**
	* @JsonProperty(String, "taxpayerTel")
	*/
	private $taxpayerTel;

	/**
	* @JsonProperty(String, "totalAmount")
	*/
	private $totalAmount;

	/**
	* @JsonProperty(String, "validReason")
	*/
	private $validReason;

	/**
	* @JsonProperty(String, "validTime")
	*/
	private $validTime;

	/**
	* @JsonProperty(String, "viewUrl")
	*/
	private $viewUrl;

	/**
	* @JsonProperty(String, "cipherText")
	*/
	private $cipherText;

	/**
	* @JsonProperty(String, "qrCode")
	*/
	private $qrCode;

	public function setCheckCode($checkCode)
	{
		$this->checkCode = $checkCode;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setCustomerAddress($customerAddress)
	{
		$this->customerAddress = $customerAddress;
	}

	public function setCustomerBankAccount($customerBankAccount)
	{
		$this->customerBankAccount = $customerBankAccount;
	}

	public function setCustomerBankName($customerBankName)
	{
		$this->customerBankName = $customerBankName;
	}

	public function setCustomerCode($customerCode)
	{
		$this->customerCode = $customerCode;
	}

	public function setCustomerName($customerName)
	{
		$this->customerName = $customerName;
	}

	public function setCustomerTel($customerTel)
	{
		$this->customerTel = $customerTel;
	}

	public function setDrawer($drawer)
	{
		$this->drawer = $drawer;
	}

	public function setFiscalCode($fiscalCode)
	{
		$this->fiscalCode = $fiscalCode;
	}

	public function setGenerateTime($generateTime)
	{
		$this->generateTime = $generateTime;
	}

	public function setInvPdf($invPdf)
	{
		$this->invPdf = $invPdf;
	}

	public function setItems($items)
	{
		$this->items = $items;
	}

	public function setNoTaxAmount($noTaxAmount)
	{
		$this->noTaxAmount = $noTaxAmount;
	}

	public function setOrderNo($orderNo)
	{
		$this->orderNo = $orderNo;
	}

	public function setPayee($payee)
	{
		$this->payee = $payee;
	}

	public function setPdfUnsignedUrl($pdfUnsignedUrl)
	{
		$this->pdfUnsignedUrl = $pdfUnsignedUrl;
	}

	public function setRelatedCode($relatedCode)
	{
		$this->relatedCode = $relatedCode;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	public function setReviewer($reviewer)
	{
		$this->reviewer = $reviewer;
	}

	public function setStatus($status)
	{
		$this->status = $status;
	}

	public function setTaxAmount($taxAmount)
	{
		$this->taxAmount = $taxAmount;
	}

	public function setTaxDeviceNo($taxDeviceNo)
	{
		$this->taxDeviceNo = $taxDeviceNo;
	}

	public function setTaxpayerAddress($taxpayerAddress)
	{
		$this->taxpayerAddress = $taxpayerAddress;
	}

	public function setTaxpayerBankAccount($taxpayerBankAccount)
	{
		$this->taxpayerBankAccount = $taxpayerBankAccount;
	}

	public function setTaxpayerBankName($taxpayerBankName)
	{
		$this->taxpayerBankName = $taxpayerBankName;
	}

	public function setTaxpayerCode($taxpayerCode)
	{
		$this->taxpayerCode = $taxpayerCode;
	}

	public function setTaxpayerName($taxpayerName)
	{
		$this->taxpayerName = $taxpayerName;
	}

	public function setTaxpayerTel($taxpayerTel)
	{
		$this->taxpayerTel = $taxpayerTel;
	}

	public function setTotalAmount($totalAmount)
	{
		$this->totalAmount = $totalAmount;
	}

	public function setValidReason($validReason)
	{
		$this->validReason = $validReason;
	}

	public function setValidTime($validTime)
	{
		$this->validTime = $validTime;
	}

	public function setViewUrl($viewUrl)
	{
		$this->viewUrl = $viewUrl;
	}

	public function setCipherText($cipherText)
	{
		$this->cipherText = $cipherText;
	}

	public function setQrCode($qrCode)
	{
		$this->qrCode = $qrCode;
	}

}

class PddEinvoiceIssueInvoiceResultCallbackRuihongRequest_DataInvoiceItemsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "addedValueTaxFlg")
	*/
	private $addedValueTaxFlg;

	/**
	* @JsonProperty(String, "amount")
	*/
	private $amount;

	/**
	* @JsonProperty(String, "catalogCode")
	*/
	private $catalogCode;

	/**
	* @JsonProperty(String, "code")
	*/
	private $code;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "noTaxAmount")
	*/
	private $noTaxAmount;

	/**
	* @JsonProperty(String, "preferentialPolicyFlg")
	*/
	private $preferentialPolicyFlg;

	/**
	* @JsonProperty(String, "price")
	*/
	private $price;

	/**
	* @JsonProperty(String, "quantity")
	*/
	private $quantity;

	/**
	* @JsonProperty(String, "spec")
	*/
	private $spec;

	/**
	* @JsonProperty(String, "taxAmount")
	*/
	private $taxAmount;

	/**
	* @JsonProperty(String, "taxRate")
	*/
	private $taxRate;

	/**
	* @JsonProperty(String, "type")
	*/
	private $type;

	/**
	* @JsonProperty(String, "uom")
	*/
	private $uom;

	/**
	* @JsonProperty(String, "zeroTaxRateFlg")
	*/
	private $zeroTaxRateFlg;

	public function setAddedValueTaxFlg($addedValueTaxFlg)
	{
		$this->addedValueTaxFlg = $addedValueTaxFlg;
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	public function setCatalogCode($catalogCode)
	{
		$this->catalogCode = $catalogCode;
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setNoTaxAmount($noTaxAmount)
	{
		$this->noTaxAmount = $noTaxAmount;
	}

	public function setPreferentialPolicyFlg($preferentialPolicyFlg)
	{
		$this->preferentialPolicyFlg = $preferentialPolicyFlg;
	}

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function setQuantity($quantity)
	{
		$this->quantity = $quantity;
	}

	public function setSpec($spec)
	{
		$this->spec = $spec;
	}

	public function setTaxAmount($taxAmount)
	{
		$this->taxAmount = $taxAmount;
	}

	public function setTaxRate($taxRate)
	{
		$this->taxRate = $taxRate;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

	public function setUom($uom)
	{
		$this->uom = $uom;
	}

	public function setZeroTaxRateFlg($zeroTaxRateFlg)
	{
		$this->zeroTaxRateFlg = $zeroTaxRateFlg;
	}

}
