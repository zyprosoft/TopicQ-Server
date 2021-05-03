<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddInvoiceDetailUploadRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "application_id")
	*/
	private $applicationId;

	/**
	* @JsonProperty(Integer, "business_type")
	*/
	private $businessType;

	/**
	* @JsonProperty(Long, "invoice_amount")
	*/
	private $invoiceAmount;

	/**
	* @JsonProperty(String, "invoice_code")
	*/
	private $invoiceCode;

	/**
	* @JsonProperty(String, "invoice_file_content")
	*/
	private $invoiceFileContent;

	/**
	* @JsonProperty(Integer, "invoice_kind")
	*/
	private $invoiceKind;

	/**
	* @JsonProperty(String, "invoice_no")
	*/
	private $invoiceNo;

	/**
	* @JsonProperty(Long, "invoice_time")
	*/
	private $invoiceTime;

	/**
	* @JsonProperty(Integer, "invoice_type")
	*/
	private $invoiceType;

	/**
	* @JsonProperty(String, "memo")
	*/
	private $memo;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	/**
	* @JsonProperty(String, "original_invoice_code")
	*/
	private $originalInvoiceCode;

	/**
	* @JsonProperty(String, "original_invoice_no")
	*/
	private $originalInvoiceNo;

	/**
	* @JsonProperty(String, "payee_operator")
	*/
	private $payeeOperator;

	/**
	* @JsonProperty(String, "payer_account")
	*/
	private $payerAccount;

	/**
	* @JsonProperty(String, "payer_address")
	*/
	private $payerAddress;

	/**
	* @JsonProperty(String, "payer_bank")
	*/
	private $payerBank;

	/**
	* @JsonProperty(String, "payer_name")
	*/
	private $payerName;

	/**
	* @JsonProperty(String, "payer_phone")
	*/
	private $payerPhone;

	/**
	* @JsonProperty(String, "payer_register_no")
	*/
	private $payerRegisterNo;

	/**
	* @JsonProperty(Long, "sum_price")
	*/
	private $sumPrice;

	/**
	* @JsonProperty(Integer, "sum_tax")
	*/
	private $sumTax;

	/**
	* @JsonProperty(Integer, "tax_rate")
	*/
	private $taxRate;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "application_id", $this->applicationId);
		$this->setUserParam($params, "business_type", $this->businessType);
		$this->setUserParam($params, "invoice_amount", $this->invoiceAmount);
		$this->setUserParam($params, "invoice_code", $this->invoiceCode);
		$this->setUserParam($params, "invoice_file_content", $this->invoiceFileContent);
		$this->setUserParam($params, "invoice_kind", $this->invoiceKind);
		$this->setUserParam($params, "invoice_no", $this->invoiceNo);
		$this->setUserParam($params, "invoice_time", $this->invoiceTime);
		$this->setUserParam($params, "invoice_type", $this->invoiceType);
		$this->setUserParam($params, "memo", $this->memo);
		$this->setUserParam($params, "order_sn", $this->orderSn);
		$this->setUserParam($params, "original_invoice_code", $this->originalInvoiceCode);
		$this->setUserParam($params, "original_invoice_no", $this->originalInvoiceNo);
		$this->setUserParam($params, "payee_operator", $this->payeeOperator);
		$this->setUserParam($params, "payer_account", $this->payerAccount);
		$this->setUserParam($params, "payer_address", $this->payerAddress);
		$this->setUserParam($params, "payer_bank", $this->payerBank);
		$this->setUserParam($params, "payer_name", $this->payerName);
		$this->setUserParam($params, "payer_phone", $this->payerPhone);
		$this->setUserParam($params, "payer_register_no", $this->payerRegisterNo);
		$this->setUserParam($params, "sum_price", $this->sumPrice);
		$this->setUserParam($params, "sum_tax", $this->sumTax);
		$this->setUserParam($params, "tax_rate", $this->taxRate);

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
		return "pdd.invoice.detail.upload";
	}

	public function setApplicationId($applicationId)
	{
		$this->applicationId = $applicationId;
	}

	public function setBusinessType($businessType)
	{
		$this->businessType = $businessType;
	}

	public function setInvoiceAmount($invoiceAmount)
	{
		$this->invoiceAmount = $invoiceAmount;
	}

	public function setInvoiceCode($invoiceCode)
	{
		$this->invoiceCode = $invoiceCode;
	}

	public function setInvoiceFileContent($invoiceFileContent)
	{
		$this->invoiceFileContent = $invoiceFileContent;
	}

	public function setInvoiceKind($invoiceKind)
	{
		$this->invoiceKind = $invoiceKind;
	}

	public function setInvoiceNo($invoiceNo)
	{
		$this->invoiceNo = $invoiceNo;
	}

	public function setInvoiceTime($invoiceTime)
	{
		$this->invoiceTime = $invoiceTime;
	}

	public function setInvoiceType($invoiceType)
	{
		$this->invoiceType = $invoiceType;
	}

	public function setMemo($memo)
	{
		$this->memo = $memo;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

	public function setOriginalInvoiceCode($originalInvoiceCode)
	{
		$this->originalInvoiceCode = $originalInvoiceCode;
	}

	public function setOriginalInvoiceNo($originalInvoiceNo)
	{
		$this->originalInvoiceNo = $originalInvoiceNo;
	}

	public function setPayeeOperator($payeeOperator)
	{
		$this->payeeOperator = $payeeOperator;
	}

	public function setPayerAccount($payerAccount)
	{
		$this->payerAccount = $payerAccount;
	}

	public function setPayerAddress($payerAddress)
	{
		$this->payerAddress = $payerAddress;
	}

	public function setPayerBank($payerBank)
	{
		$this->payerBank = $payerBank;
	}

	public function setPayerName($payerName)
	{
		$this->payerName = $payerName;
	}

	public function setPayerPhone($payerPhone)
	{
		$this->payerPhone = $payerPhone;
	}

	public function setPayerRegisterNo($payerRegisterNo)
	{
		$this->payerRegisterNo = $payerRegisterNo;
	}

	public function setSumPrice($sumPrice)
	{
		$this->sumPrice = $sumPrice;
	}

	public function setSumTax($sumTax)
	{
		$this->sumTax = $sumTax;
	}

	public function setTaxRate($taxRate)
	{
		$this->taxRate = $taxRate;
	}

}
