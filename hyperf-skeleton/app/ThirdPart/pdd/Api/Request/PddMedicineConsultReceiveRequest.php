<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddMedicineConsultReceiveRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "consult_no")
	*/
	private $consultNo;

	/**
	* @JsonProperty(String, "content")
	*/
	private $content;

	/**
	* @JsonProperty(Long, "doctor_id")
	*/
	private $doctorId;

	/**
	* @JsonProperty(String, "msg_id")
	*/
	private $msgId;

	/**
	* @JsonProperty(Integer, "receive_type")
	*/
	private $receiveType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "consult_no", $this->consultNo);
		$this->setUserParam($params, "content", $this->content);
		$this->setUserParam($params, "doctor_id", $this->doctorId);
		$this->setUserParam($params, "msg_id", $this->msgId);
		$this->setUserParam($params, "receive_type", $this->receiveType);

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
		return "pdd.medicine.consult.receive";
	}

	public function setConsultNo($consultNo)
	{
		$this->consultNo = $consultNo;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setDoctorId($doctorId)
	{
		$this->doctorId = $doctorId;
	}

	public function setMsgId($msgId)
	{
		$this->msgId = $msgId;
	}

	public function setReceiveType($receiveType)
	{
		$this->receiveType = $receiveType;
	}

}
