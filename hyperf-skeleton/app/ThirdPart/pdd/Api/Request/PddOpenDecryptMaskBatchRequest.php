<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOpenDecryptMaskBatchRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddOpenDecryptMaskBatchRequest_DataListItem>, "data_list")
	*/
	private $dataList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "data_list", $this->dataList);

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
		return "pdd.open.decrypt.mask.batch";
	}

	public function setDataList($dataList)
	{
		$this->dataList = $dataList;
	}

}

class PddOpenDecryptMaskBatchRequest_DataListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "data_tag")
	*/
	private $dataTag;

	/**
	* @JsonProperty(String, "encrypted_data")
	*/
	private $encryptedData;

	public function setDataTag($dataTag)
	{
		$this->dataTag = $dataTag;
	}

	public function setEncryptedData($encryptedData)
	{
		$this->encryptedData = $encryptedData;
	}

}
