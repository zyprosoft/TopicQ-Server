<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKnockSupplierSendGroupRobotMessageRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddKnockSupplierSendGroupRobotMessageRequest_GroupRobotSendMsgReq, "group_robot_send_msg_req")
	*/
	private $groupRobotSendMsgReq;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "group_robot_send_msg_req", $this->groupRobotSendMsgReq);

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
		return "pdd.knock.supplier.send.group.robot.message";
	}

	public function setGroupRobotSendMsgReq($groupRobotSendMsgReq)
	{
		$this->groupRobotSendMsgReq = $groupRobotSendMsgReq;
	}

}

class PddKnockSupplierSendGroupRobotMessageRequest_GroupRobotSendMsgReq extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "at_all")
	*/
	private $atAll;

	/**
	* @JsonProperty(String, "content")
	*/
	private $content;

	/**
	* @JsonProperty(String, "group_robot_token")
	*/
	private $groupRobotToken;

	/**
	* @JsonProperty(String, "msg_type")
	*/
	private $msgType;

	/**
	* @JsonProperty(List<String>, "knock_ids")
	*/
	private $knockIds;

	public function setAtAll($atAll)
	{
		$this->atAll = $atAll;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setGroupRobotToken($groupRobotToken)
	{
		$this->groupRobotToken = $groupRobotToken;
	}

	public function setMsgType($msgType)
	{
		$this->msgType = $msgType;
	}

	public function setKnockIds($knockIds)
	{
		$this->knockIds = $knockIds;
	}

}
