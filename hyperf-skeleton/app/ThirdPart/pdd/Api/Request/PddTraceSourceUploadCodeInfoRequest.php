<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTraceSourceUploadCodeInfoRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTraceSourceUploadCodeInfoRequest_SerialNumListItem>, "serial_num_list")
	*/
	private $serialNumList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "serial_num_list", $this->serialNumList);

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
		return "pdd.trace.source.upload.code.info";
	}

	public function setSerialNumList($serialNumList)
	{
		$this->serialNumList = $serialNumList;
	}

}

class PddTraceSourceUploadCodeInfoRequest_SerialNumListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "encoded_serial_num")
	*/
	private $encodedSerialNum;

	/**
	* @JsonProperty(String, "serial_num")
	*/
	private $serialNum;

	public function setEncodedSerialNum($encodedSerialNum)
	{
		$this->encodedSerialNum = $encodedSerialNum;
	}

	public function setSerialNum($serialNum)
	{
		$this->serialNum = $serialNum;
	}

}
