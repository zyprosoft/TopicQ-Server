<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiPlanCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdPlanCreateMessage, "adPlanCreateMessage")
	*/
	private $adPlanCreateMessage;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItem>, "adUnitCreateComplexMessageList")
	*/
	private $adUnitCreateComplexMessageList;

	/**
	* @JsonProperty(Integer, "planStrategy")
	*/
	private $planStrategy;

	/**
	* @JsonProperty(Integer, "scenesType")
	*/
	private $scenesType;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adPlanCreateMessage", $this->adPlanCreateMessage);
		$this->setUserParam($params, "adUnitCreateComplexMessageList", $this->adUnitCreateComplexMessageList);
		$this->setUserParam($params, "planStrategy", $this->planStrategy);
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
		return "pdd.ad.api.plan.create";
	}

	public function setAdPlanCreateMessage($adPlanCreateMessage)
	{
		$this->adPlanCreateMessage = $adPlanCreateMessage;
	}

	public function setAdUnitCreateComplexMessageList($adUnitCreateComplexMessageList)
	{
		$this->adUnitCreateComplexMessageList = $adUnitCreateComplexMessageList;
	}

	public function setPlanStrategy($planStrategy)
	{
		$this->planStrategy = $planStrategy;
	}

	public function setScenesType($scenesType)
	{
		$this->scenesType = $scenesType;
	}

}

class PddAdApiPlanCreateRequest_AdPlanCreateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "maxCost")
	*/
	private $maxCost;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdPlanCreateMessagePlanDiscount, "planDiscount")
	*/
	private $planDiscount;

	/**
	* @JsonProperty(String, "planName")
	*/
	private $planName;

	public function setMaxCost($maxCost)
	{
		$this->maxCost = $maxCost;
	}

	public function setPlanDiscount($planDiscount)
	{
		$this->planDiscount = $planDiscount;
	}

	public function setPlanName($planName)
	{
		$this->planName = $planName;
	}

}

class PddAdApiPlanCreateRequest_AdPlanCreateMessagePlanDiscount extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdPlanCreateMessagePlanDiscountDiscountsItem>, "discounts")
	*/
	private $discounts;

	public function setDiscounts($discounts)
	{
		$this->discounts = $discounts;
	}

}

class PddAdApiPlanCreateRequest_AdPlanCreateMessagePlanDiscountDiscountsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "index")
	*/
	private $index;

	/**
	* @JsonProperty(Integer, "rate")
	*/
	private $rate;

	public function setIndex($index)
	{
		$this->index = $index;
	}

	public function setRate($rate)
	{
		$this->rate = $rate;
	}

}

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdCreativeCreateMessagesListItem>, "adCreativeCreateMessagesList")
	*/
	private $adCreativeCreateMessagesList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdKeywordCreateMessageListItem>, "adKeywordCreateMessageList")
	*/
	private $adKeywordCreateMessageList;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdKeywordSetMessage, "adKeywordSetMessage")
	*/
	private $adKeywordSetMessage;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdProductCreateMessage, "adProductCreateMessage")
	*/
	private $adProductCreateMessage;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdUnitCreateMessage, "adUnitCreateMessage")
	*/
	private $adUnitCreateMessage;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItem>, "audienceBidCreateMessageList")
	*/
	private $audienceBidCreateMessageList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemLocationBidCreateMessageListItem>, "locationBidCreateMessageList")
	*/
	private $locationBidCreateMessageList;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemSmartCreativeCreateMessage, "smartCreativeCreateMessage")
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdCreativeCreateMessagesListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdCreativeCreateMessagesListItemAdImageVOListItem>, "adImageVOList")
	*/
	private $adImageVOList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdCreativeCreateMessagesListItemAdTextVOListItem>, "adTextVOList")
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdCreativeCreateMessagesListItemAdImageVOListItem extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdCreativeCreateMessagesListItemAdTextVOListItem extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdKeywordCreateMessageListItem extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdKeywordSetMessage extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdProductCreateMessage extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdUnitCreateMessage extends PopBaseJsonEntity
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
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdUnitCreateMessageOptimizationMessage, "optimizationMessage")
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdUnitCreateMessageOptimizationMessage extends PopBaseJsonEntity
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdUnitCreateMessageOptimizationMessageOptionalOptimizationBidMessageListItem>, "optionalOptimizationBidMessageList")
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAdUnitCreateMessageOptimizationMessageOptionalOptimizationBidMessageListItem extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItemAdTargetingCreateMessage, "adTargetingCreateMessage")
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItemAdTargetingCreateMessage extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSet, "adTargetingSet")
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSet extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSetAreaStruct, "areaStruct")
	*/
	private $areaStruct;

	public function setAreaStruct($areaStruct)
	{
		$this->areaStruct = $areaStruct;
	}

}

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemAudienceBidCreateMessageListItemAdTargetingCreateMessageAdTargetingSetAreaStruct extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemLocationBidCreateMessageListItem extends PopBaseJsonEntity
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

class PddAdApiPlanCreateRequest_AdUnitCreateComplexMessageListItemSmartCreativeCreateMessage extends PopBaseJsonEntity
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
