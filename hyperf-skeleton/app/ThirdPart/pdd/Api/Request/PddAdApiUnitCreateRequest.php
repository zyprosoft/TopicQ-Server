<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiUnitCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessage, "adUnitCreateComplexMessage")
	*/
	private $adUnitCreateComplexMessage;

	/**
	* @JsonProperty(Long, "planId")
	*/
	private $planId;

	/**
	* @JsonProperty(Integer, "scenesType")
	*/
	private $scenesType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adUnitCreateComplexMessage", $this->adUnitCreateComplexMessage);
		$this->setUserParam($params, "planId", $this->planId);
		$this->setUserParam($params, "scenesType", $this->scenesType);

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
		return "pdd.ad.api.unit.create";
	}

	public function setAdUnitCreateComplexMessage($adUnitCreateComplexMessage)
	{
		$this->adUnitCreateComplexMessage = $adUnitCreateComplexMessage;
	}

	public function setPlanId($planId)
	{
		$this->planId = $planId;
	}

	public function setScenesType($scenesType)
	{
		$this->scenesType = $scenesType;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdCreativeCreateMessagesListItem>, "adCreativeCreateMessagesList")
	*/
	private $adCreativeCreateMessagesList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdKeywordCreateMessageListItem>, "adKeywordCreateMessageList")
	*/
	private $adKeywordCreateMessageList;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdKeywordSetMessage, "adKeywordSetMessage")
	*/
	private $adKeywordSetMessage;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdProductCreateMessage, "adProductCreateMessage")
	*/
	private $adProductCreateMessage;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdUnitCreateMessage, "adUnitCreateMessage")
	*/
	private $adUnitCreateMessage;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItem>, "audienceBidCreateMessageList")
	*/
	private $audienceBidCreateMessageList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageLocationBidCreateMessageListItem>, "locationBidCreateMessageList")
	*/
	private $locationBidCreateMessageList;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageSmartCreativeCreateMessage, "smartCreativeCreateMessage")
	*/
	private $smartCreativeCreateMessage;

	public function setAdCreativeCreateMessagesList($adCreativeCreateMessagesList)
	{
		$this->adCreativeCreateMessagesList = $adCreativeCreateMessagesList;
	}

	public function setAdKeywordCreateMessageList($adKeywordCreateMessageList)
	{
		$this->adKeywordCreateMessageList = $adKeywordCreateMessageList;
	}

	public function setAdKeywordSetMessage($adKeywordSetMessage)
	{
		$this->adKeywordSetMessage = $adKeywordSetMessage;
	}

	public function setAdProductCreateMessage($adProductCreateMessage)
	{
		$this->adProductCreateMessage = $adProductCreateMessage;
	}

	public function setAdUnitCreateMessage($adUnitCreateMessage)
	{
		$this->adUnitCreateMessage = $adUnitCreateMessage;
	}

	public function setAudienceBidCreateMessageList($audienceBidCreateMessageList)
	{
		$this->audienceBidCreateMessageList = $audienceBidCreateMessageList;
	}

	public function setLocationBidCreateMessageList($locationBidCreateMessageList)
	{
		$this->locationBidCreateMessageList = $locationBidCreateMessageList;
	}

	public function setSmartCreativeCreateMessage($smartCreativeCreateMessage)
	{
		$this->smartCreativeCreateMessage = $smartCreativeCreateMessage;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdCreativeCreateMessagesListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdCreativeCreateMessagesListItemAdImageVOListItem>, "adImageVOList")
	*/
	private $adImageVOList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdCreativeCreateMessagesListItemAdTextVOListItem>, "adTextVOList")
	*/
	private $adTextVOList;

	/**
	* @JsonProperty(Long, "creativeSpecificationId")
	*/
	private $creativeSpecificationId;

	public function setAdImageVOList($adImageVOList)
	{
		$this->adImageVOList = $adImageVOList;
	}

	public function setAdTextVOList($adTextVOList)
	{
		$this->adTextVOList = $adTextVOList;
	}

	public function setCreativeSpecificationId($creativeSpecificationId)
	{
		$this->creativeSpecificationId = $creativeSpecificationId;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdCreativeCreateMessagesListItemAdImageVOListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "imageUrl")
	*/
	private $imageUrl;

	public function setImageUrl($imageUrl)
	{
		$this->imageUrl = $imageUrl;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdCreativeCreateMessagesListItemAdTextVOListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "text")
	*/
	private $text;

	public function setText($text)
	{
		$this->text = $text;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdKeywordCreateMessageListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "bid")
	*/
	private $bid;

	/**
	* @JsonProperty(Long, "premiumRate")
	*/
	private $premiumRate;

	/**
	* @JsonProperty(String, "word")
	*/
	private $word;

	public function setBid($bid)
	{
		$this->bid = $bid;
	}

	public function setPremiumRate($premiumRate)
	{
		$this->premiumRate = $premiumRate;
	}

	public function setWord($word)
	{
		$this->word = $word;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdKeywordSetMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "keywordSetBid")
	*/
	private $keywordSetBid;

	public function setKeywordSetBid($keywordSetBid)
	{
		$this->keywordSetBid = $keywordSetBid;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdProductCreateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "goodsId")
	*/
	private $goodsId;

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdUnitCreateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "adName")
	*/
	private $adName;

	/**
	* @JsonProperty(Long, "bid")
	*/
	private $bid;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdUnitCreateMessageOptimizationMessage, "optimizationMessage")
	*/
	private $optimizationMessage;

	public function setAdName($adName)
	{
		$this->adName = $adName;
	}

	public function setBid($bid)
	{
		$this->bid = $bid;
	}

	public function setOptimizationMessage($optimizationMessage)
	{
		$this->optimizationMessage = $optimizationMessage;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdUnitCreateMessageOptimizationMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "accumulationBid")
	*/
	private $accumulationBid;

	/**
	* @JsonProperty(Long, "optimizationBid")
	*/
	private $optimizationBid;

	/**
	* @JsonProperty(Integer, "optimizationGoal")
	*/
	private $optimizationGoal;

	/**
	* @JsonProperty(Integer, "optimizationMethod")
	*/
	private $optimizationMethod;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdUnitCreateMessageOptimizationMessageOptionalOptimizationBidMessageListItem>, "optionalOptimizationBidMessageList")
	*/
	private $optionalOptimizationBidMessageList;

	public function setAccumulationBid($accumulationBid)
	{
		$this->accumulationBid = $accumulationBid;
	}

	public function setOptimizationBid($optimizationBid)
	{
		$this->optimizationBid = $optimizationBid;
	}

	public function setOptimizationGoal($optimizationGoal)
	{
		$this->optimizationGoal = $optimizationGoal;
	}

	public function setOptimizationMethod($optimizationMethod)
	{
		$this->optimizationMethod = $optimizationMethod;
	}

	public function setOptionalOptimizationBidMessageList($optionalOptimizationBidMessageList)
	{
		$this->optionalOptimizationBidMessageList = $optionalOptimizationBidMessageList;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAdUnitCreateMessageOptimizationMessageOptionalOptimizationBidMessageListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "optimizationBid")
	*/
	private $optimizationBid;

	/**
	* @JsonProperty(Integer, "optimizationGoal")
	*/
	private $optimizationGoal;

	public function setOptimizationBid($optimizationBid)
	{
		$this->optimizationBid = $optimizationBid;
	}

	public function setOptimizationGoal($optimizationGoal)
	{
		$this->optimizationGoal = $optimizationGoal;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItemAdTargetingCreateMessage, "adTargetingCreateMessage")
	*/
	private $adTargetingCreateMessage;

	/**
	* @JsonProperty(Long, "bidReferenceId")
	*/
	private $bidReferenceId;

	/**
	* @JsonProperty(Long, "bidValue")
	*/
	private $bidValue;

	/**
	* @JsonProperty(Long, "subBidReferenceId")
	*/
	private $subBidReferenceId;

	public function setAdTargetingCreateMessage($adTargetingCreateMessage)
	{
		$this->adTargetingCreateMessage = $adTargetingCreateMessage;
	}

	public function setBidReferenceId($bidReferenceId)
	{
		$this->bidReferenceId = $bidReferenceId;
	}

	public function setBidValue($bidValue)
	{
		$this->bidValue = $bidValue;
	}

	public function setSubBidReferenceId($subBidReferenceId)
	{
		$this->subBidReferenceId = $subBidReferenceId;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItemAdTargetingCreateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSet, "adTargetingSet")
	*/
	private $adTargetingSet;

	/**
	* @JsonProperty(String, "targetingName")
	*/
	private $targetingName;

	public function setAdTargetingSet($adTargetingSet)
	{
		$this->adTargetingSet = $adTargetingSet;
	}

	public function setTargetingName($targetingName)
	{
		$this->targetingName = $targetingName;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSet extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSetAreaStruct, "areaStruct")
	*/
	private $areaStruct;

	public function setAreaStruct($areaStruct)
	{
		$this->areaStruct = $areaStruct;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSetAreaStruct extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<Integer>, "areaIds")
	*/
	private $areaIds;

	public function setAreaIds($areaIds)
	{
		$this->areaIds = $areaIds;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageLocationBidCreateMessageListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "bidReferenceId")
	*/
	private $bidReferenceId;

	/**
	* @JsonProperty(Long, "bidValue")
	*/
	private $bidValue;

	public function setBidReferenceId($bidReferenceId)
	{
		$this->bidReferenceId = $bidReferenceId;
	}

	public function setBidValue($bidValue)
	{
		$this->bidValue = $bidValue;
	}

}

class PddAdApiUnitCreateRequest_AdUnitCreateComplexMessageSmartCreativeCreateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "creativeFlowRate")
	*/
	private $creativeFlowRate;

	/**
	* @JsonProperty(Integer, "enableSmartCreative")
	*/
	private $enableSmartCreative;

	/**
	* @JsonProperty(String, "smartCreativeTitle")
	*/
	private $smartCreativeTitle;

	public function setCreativeFlowRate($creativeFlowRate)
	{
		$this->creativeFlowRate = $creativeFlowRate;
	}

	public function setEnableSmartCreative($enableSmartCreative)
	{
		$this->enableSmartCreative = $enableSmartCreative;
	}

	public function setSmartCreativeTitle($smartCreativeTitle)
	{
		$this->smartCreativeTitle = $smartCreativeTitle;
	}

}
