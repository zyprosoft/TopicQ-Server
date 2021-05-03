<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFinanceBalanceDailyBillUrlGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "bill_date")
	*/
	private $billDate;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "bill_date", $this->billDate);

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
		return "pdd.finance.balance.daily.bill.url.get";
	}

	public function setBillDate($billDate)
	{
		$this->billDate = $billDate;
	}

}
