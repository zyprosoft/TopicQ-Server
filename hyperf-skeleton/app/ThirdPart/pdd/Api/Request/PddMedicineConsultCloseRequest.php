<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddMedicineConsultCloseRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "consult_no")
	*/
	private $consultNo;

	/**
	* @JsonProperty(String, "reason")
	*/
	private $reason;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "consult_no", $this->consultNo);
		$this->setUserParam($params, "reason", $this->reason);

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
		return "pdd.medicine.consult.close";
	}

	public function setConsultNo($consultNo)
	{
		$this->consultNo = $consultNo;
	}

	public function setReason($reason)
	{
		$this->reason = $reason;
	}

}
