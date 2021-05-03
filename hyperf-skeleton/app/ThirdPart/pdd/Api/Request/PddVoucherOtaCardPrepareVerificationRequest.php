<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddVoucherOtaCardPrepareVerificationRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddVoucherOtaCardPrepareVerificationRequest_Request, "request")
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
		return "pdd.voucher.ota.card.prepare.verification";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddVoucherOtaCardPrepareVerificationRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "card_no")
	*/
	private $cardNo;

	/**
	* @JsonProperty(Long, "store_id")
	*/
	private $storeId;

	public function setCardNo($cardNo)
	{
		$this->cardNo = $cardNo;
	}

	public function setStoreId($storeId)
	{
		$this->storeId = $storeId;
	}

}
