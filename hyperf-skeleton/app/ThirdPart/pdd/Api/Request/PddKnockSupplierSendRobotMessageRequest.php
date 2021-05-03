<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKnockSupplierSendRobotMessageRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSupplierSendRobotMessageRequest_SupplierSendRobotMsgReq, "supplier_send_robot_msg_req")
	*/
	private $supplierSendRobotMsgReq;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "supplier_send_robot_msg_req", $this->supplierSendRobotMsgReq);

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
		return "pdd.knock.supplier.send.robot.message";
	}

	public function setSupplierSendRobotMsgReq($supplierSendRobotMsgReq)
	{
		$this->supplierSendRobotMsgReq = $supplierSendRobotMsgReq;
	}

}

class PddKnockSupplierSendRobotMessageRequest_SupplierSendRobotMsgReq extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "content_json_body")
	*/
	private $contentJsonBody;

	/**
	* @JsonProperty(List<String>, "encrypt_uuid_list")
	*/
	private $encryptUuidList;

	/**
	* @JsonProperty(String, "msg_type")
	*/
	private $msgType;

	/**
	* @JsonProperty(String, "robot_name")
	*/
	private $robotName;

	/**
	* @JsonProperty(String, "send_msg_id")
	*/
	private $sendMsgId;

	public function setContentJsonBody($contentJsonBody)
	{
		$this->contentJsonBody = $contentJsonBody;
	}

	public function setEncryptUuidList($encryptUuidList)
	{
		$this->encryptUuidList = $encryptUuidList;
	}

	public function setMsgType($msgType)
	{
		$this->msgType = $msgType;
	}

	public function setRobotName($robotName)
	{
		$this->robotName = $robotName;
	}

	public function setSendMsgId($sendMsgId)
	{
		$this->sendMsgId = $sendMsgId;
	}

}
