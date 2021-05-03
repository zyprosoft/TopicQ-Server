<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudprintCmdprintRenderRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudprintCmdprintRenderRequest_Request, "request")
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
		return "pdd.cloudprint.cmdprint.render";
	}

	public function setRequest($request)
	{
		$this->request = $request;
	}

}

class PddCloudprintCmdprintRenderRequest_Request extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "client_side_id")
	*/
	private $clientSideId;

	/**
	* @JsonProperty(String, "client_type")
	*/
	private $clientType;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudprintCmdprintRenderRequest_RequestConfig, "config")
	*/
	private $config;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudprintCmdprintRenderRequest_RequestDocument, "document")
	*/
	private $document;

	/**
	* @JsonProperty(String, "printer_name")
	*/
	private $printerName;

	/**
	* @JsonProperty(String, "print_command_type")
	*/
	private $printCommandType;

	/**
	* @JsonProperty(String, "cmd_encoding")
	*/
	private $cmdEncoding;

	public function setClientSideId($clientSideId)
	{
		$this->clientSideId = $clientSideId;
	}

	public function setClientType($clientType)
	{
		$this->clientType = $clientType;
	}

	public function setConfig($config)
	{
		$this->config = $config;
	}

	public function setDocument($document)
	{
		$this->document = $document;
	}

	public function setPrinterName($printerName)
	{
		$this->printerName = $printerName;
	}

	public function setPrintCommandType($printCommandType)
	{
		$this->printCommandType = $printCommandType;
	}

	public function setCmdEncoding($cmdEncoding)
	{
		$this->cmdEncoding = $cmdEncoding;
	}

}

class PddCloudprintCmdprintRenderRequest_RequestConfig extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Double, "horizontal_offset")
	*/
	private $horizontalOffset;

	/**
	* @JsonProperty(Boolean, "need_bottom_logo")
	*/
	private $needBottomLogo;

	/**
	* @JsonProperty(Boolean, "need_middle_logo")
	*/
	private $needMiddleLogo;

	/**
	* @JsonProperty(Boolean, "need_top_logo")
	*/
	private $needTopLogo;

	/**
	* @JsonProperty(String, "orientation")
	*/
	private $orientation;

	/**
	* @JsonProperty(Double, "vertical_offset")
	*/
	private $verticalOffset;

	public function setHorizontalOffset($horizontalOffset)
	{
		$this->horizontalOffset = $horizontalOffset;
	}

	public function setNeedBottomLogo($needBottomLogo)
	{
		$this->needBottomLogo = $needBottomLogo;
	}

	public function setNeedMiddleLogo($needMiddleLogo)
	{
		$this->needMiddleLogo = $needMiddleLogo;
	}

	public function setNeedTopLogo($needTopLogo)
	{
		$this->needTopLogo = $needTopLogo;
	}

	public function setOrientation($orientation)
	{
		$this->orientation = $orientation;
	}

	public function setVerticalOffset($verticalOffset)
	{
		$this->verticalOffset = $verticalOffset;
	}

}

class PddCloudprintCmdprintRenderRequest_RequestDocument extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddCloudprintCmdprintRenderRequest_RequestDocumentContentsItem>, "contents")
	*/
	private $contents;

	public function setContents($contents)
	{
		$this->contents = $contents;
	}

}

class PddCloudprintCmdprintRenderRequest_RequestDocumentContentsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "add_data")
	*/
	private $addData;

	/**
	* @JsonProperty(Boolean, "encrypted")
	*/
	private $encrypted;

	/**
	* @JsonProperty(String, "print_data")
	*/
	private $printData;

	/**
	* @JsonProperty(String, "signature")
	*/
	private $signature;

	/**
	* @JsonProperty(String, "template_url")
	*/
	private $templateUrl;

	/**
	* @JsonProperty(String, "ver")
	*/
	private $ver;

	public function setAddData($addData)
	{
		$this->addData = $addData;
	}

	public function setEncrypted($encrypted)
	{
		$this->encrypted = $encrypted;
	}

	public function setPrintData($printData)
	{
		$this->printData = $printData;
	}

	public function setSignature($signature)
	{
		$this->signature = $signature;
	}

	public function setTemplateUrl($templateUrl)
	{
		$this->templateUrl = $templateUrl;
	}

	public function setVer($ver)
	{
		$this->ver = $ver;
	}

}
