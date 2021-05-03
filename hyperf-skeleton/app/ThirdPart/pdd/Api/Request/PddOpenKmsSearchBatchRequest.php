<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOpenKmsSearchBatchRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddOpenKmsSearchBatchRequest_InputListItem>, "input_list")
	*/
	private $inputList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "input_list", $this->inputList);

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
		return "pdd.open.kms.search.batch";
	}

	public function setInputList($inputList)
	{
		$this->inputList = $inputList;
	}

}

class PddOpenKmsSearchBatchRequest_InputListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "input")
	*/
	private $input;

	/**
	* @JsonProperty(String, "type")
	*/
	private $type;

	public function setInput($input)
	{
		$this->input = $input;
	}

	public function setType($type)
	{
		$this->type = $type;
	}

}
