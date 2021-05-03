<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddLogisticsOrdertraceGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "company_code")
	*/
	private $companyCode;

	/**
	* @JsonProperty(String, "mail_no")
	*/
	private $mailNo;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "company_code", $this->companyCode);
		$this->setUserParam($params, "mail_no", $this->mailNo);

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
		return "pdd.logistics.ordertrace.get";
	}

	public function setCompanyCode($companyCode)
	{
		$this->companyCode = $companyCode;
	}

	public function setMailNo($mailNo)
	{
		$this->mailNo = $mailNo;
	}

}
