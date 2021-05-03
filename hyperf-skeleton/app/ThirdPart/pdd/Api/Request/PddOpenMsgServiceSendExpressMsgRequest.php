<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOpenMsgServiceSendExpressMsgRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "sign_name")
	*/
	private $signName;

	/**
	* @JsonProperty(Long, "template_code")
	*/
	private $templateCode;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddOpenMsgServiceSendExpressMsgRequest_Map<String, String>>, "template_param_json")
	*/
	private $templateParamJson;

	/**
	* @JsonProperty(List<String>, "waybill_codes")
	*/
	private $waybillCodes;

	/**
	* @JsonProperty(String, "wp_code")
	*/
	private $wpCode;

	/**
	* @JsonProperty(String, "out_id")
	*/
	private $outId;

	/**
	* @JsonProperty(String, "sms_up_extend_code")
	*/
	private $smsUpExtendCode;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "sign_name", $this->signName);
		$this->setUserParam($params, "template_code", $this->templateCode);
		$this->setUserParam($params, "template_param_json", $this->templateParamJson);
		$this->setUserParam($params, "waybill_codes", $this->waybillCodes);
		$this->setUserParam($params, "wp_code", $this->wpCode);
		$this->setUserParam($params, "out_id", $this->outId);
		$this->setUserParam($params, "sms_up_extend_code", $this->smsUpExtendCode);

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
		return "pdd.open.msg.service.send.express.msg";
	}

	public function setSignName($signName)
	{
		$this->signName = $signName;
	}

	public function setTemplateCode($templateCode)
	{
		$this->templateCode = $templateCode;
	}

	public function setTemplateParamJson($templateParamJson)
	{
		$this->templateParamJson = $templateParamJson;
	}

	public function setWaybillCodes($waybillCodes)
	{
		$this->waybillCodes = $waybillCodes;
	}

	public function setWpCode($wpCode)
	{
		$this->wpCode = $wpCode;
	}

	public function setOutId($outId)
	{
		$this->outId = $outId;
	}

	public function setSmsUpExtendCode($smsUpExtendCode)
	{
		$this->smsUpExtendCode = $smsUpExtendCode;
	}

}
