<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddAdApiKeywordCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "adId")
	*/
	private $adId;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddAdApiKeywordCreateRequest_KeywordListItem>, "keywordList")
	*/
	private $keywordList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "adId", $this->adId);
		$this->setUserParam($params, "keywordList", $this->keywordList);

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
		return "pdd.ad.api.keyword.create";
	}

	public function setAdId($adId)
	{
		$this->adId = $adId;
	}

	public function setKeywordList($keywordList)
	{
		$this->keywordList = $keywordList;
	}

}

class PddAdApiKeywordCreateRequest_KeywordListItem extends PopBaseJsonEntity
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
