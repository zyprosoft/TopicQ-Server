<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkOauthRpPromUrlGenerateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* #JsonProperty(Long, "amount")
	*/
	private $amount;

	/**
	* #JsonProperty(Integer, "channel_type")
	*/
	private $channelType;

	/**
	* #JsonProperty(String, "custom_parameters")
	*/
	private $customParameters;

	/**
	* #JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParam, "diy_lottery_param")
	*/
	private $diyLotteryParam;

	/**
	* #JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParam, "diy_red_packet_param")
	*/
	private $diyRedPacketParam;

	/**
	* #JsonProperty(Boolean, "generate_qq_app")
	*/
	private $generateQqApp;

	/**
	* #JsonProperty(Boolean, "generate_schema_url")
	*/
	private $generateSchemaUrl;

	/**
	* #JsonProperty(Boolean, "generate_short_url")
	*/
	private $generateShortUrl;

	/**
	* #JsonProperty(Boolean, "generate_we_app")
	*/
	private $generateWeApp;

	/**
	* #JsonProperty(List<String>, "p_id_list")
	*/
	private $pIdList;

	/**
	* #JsonProperty(Long, "scratch_card_amount")
	*/
	private $scratchCardAmount;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "amount", $this->amount);
		$this->setUserParam($params, "channel_type", $this->channelType);
		$this->setUserParam($params, "custom_parameters", $this->customParameters);
		$this->setUserParam($params, "diy_lottery_param", $this->diyLotteryParam);
		$this->setUserParam($params, "diy_red_packet_param", $this->diyRedPacketParam);
		$this->setUserParam($params, "generate_qq_app", $this->generateQqApp);
		$this->setUserParam($params, "generate_schema_url", $this->generateSchemaUrl);
		$this->setUserParam($params, "generate_short_url", $this->generateShortUrl);
		$this->setUserParam($params, "generate_we_app", $this->generateWeApp);
		$this->setUserParam($params, "p_id_list", $this->pIdList);
		$this->setUserParam($params, "scratch_card_amount", $this->scratchCardAmount);

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
		return "pdd.ddk.oauth.rp.prom.url.generate";
	}

	public function setAmount($amount)
	{
		$this->amount = $amount;
	}

	public function setChannelType($channelType)
	{
		$this->channelType = $channelType;
	}

	public function setCustomParameters($customParameters)
	{
		$this->customParameters = $customParameters;
	}

	public function setDiyLotteryParam($diyLotteryParam)
	{
		$this->diyLotteryParam = $diyLotteryParam;
	}

	public function setDiyRedPacketParam($diyRedPacketParam)
	{
		$this->diyRedPacketParam = $diyRedPacketParam;
	}

	public function setGenerateQqApp($generateQqApp)
	{
		$this->generateQqApp = $generateQqApp;
	}

	public function setGenerateSchemaUrl($generateSchemaUrl)
	{
		$this->generateSchemaUrl = $generateSchemaUrl;
	}

	public function setGenerateShortUrl($generateShortUrl)
	{
		$this->generateShortUrl = $generateShortUrl;
	}

	public function setGenerateWeApp($generateWeApp)
	{
		$this->generateWeApp = $generateWeApp;
	}

	public function setPIdList($pIdList)
	{
		$this->pIdList = $pIdList;
	}

	public function setScratchCardAmount($scratchCardAmount)
	{
		$this->scratchCardAmount = $scratchCardAmount;
	}

}

class PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParam extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* #JsonProperty(Integer, "opt_id")
	*/
	private $optId;

	/**
	* #JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParamRangeItemsItem>, "range_items")
	*/
	private $rangeItems;

	public function setOptId($optId)
	{
		$this->optId = $optId;
	}

	public function setRangeItems($rangeItems)
	{
		$this->rangeItems = $rangeItems;
	}

}

class PddDdkOauthRpPromUrlGenerateRequest_DiyLotteryParamRangeItemsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* #JsonProperty(Long, "range_from")
	*/
	private $rangeFrom;

	/**
	* #JsonProperty(Integer, "range_id")
	*/
	private $rangeId;

	/**
	* #JsonProperty(Long, "range_to")
	*/
	private $rangeTo;

	public function setRangeFrom($rangeFrom)
	{
		$this->rangeFrom = $rangeFrom;
	}

	public function setRangeId($rangeId)
	{
		$this->rangeId = $rangeId;
	}

	public function setRangeTo($rangeTo)
	{
		$this->rangeTo = $rangeTo;
	}

}

class PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParam extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* #JsonProperty(List<Long>, "amount_probability")
	*/
	private $amountProbability;

	/**
	* #JsonProperty(Boolean, "dis_text")
	*/
	private $disText;

	/**
	* #JsonProperty(Boolean, "not_show_background")
	*/
	private $notShowBackground;

	/**
	* #JsonProperty(Integer, "opt_id")
	*/
	private $optId;

	/**
	* #JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParamRangeItemsItem>, "range_items")
	*/
	private $rangeItems;

	public function setAmountProbability($amountProbability)
	{
		$this->amountProbability = $amountProbability;
	}

	public function setDisText($disText)
	{
		$this->disText = $disText;
	}

	public function setNotShowBackground($notShowBackground)
	{
		$this->notShowBackground = $notShowBackground;
	}

	public function setOptId($optId)
	{
		$this->optId = $optId;
	}

	public function setRangeItems($rangeItems)
	{
		$this->rangeItems = $rangeItems;
	}

}

class PddDdkOauthRpPromUrlGenerateRequest_DiyRedPacketParamRangeItemsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* #JsonProperty(Long, "range_from")
	*/
	private $rangeFrom;

	/**
	* #JsonProperty(Integer, "range_id")
	*/
	private $rangeId;

	/**
	* #JsonProperty(Long, "range_to")
	*/
	private $rangeTo;

	public function setRangeFrom($rangeFrom)
	{
		$this->rangeFrom = $rangeFrom;
	}

	public function setRangeId($rangeId)
	{
		$this->rangeId = $rangeId;
	}

	public function setRangeTo($rangeTo)
	{
		$this->rangeTo = $rangeTo;
	}

}
