<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddDdkOauthGoodsPromUrlGenerateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "cash_gift_id")
	*/
	private $cashGiftId;

	/**
	* @JsonProperty(String, "cash_gift_name")
	*/
	private $cashGiftName;

	/**
	* @JsonProperty(String, "custom_parameters")
	*/
	private $customParameters;

	/**
	* @JsonProperty(Boolean, "force_duo_id")
	*/
	private $forceDuoId;

	/**
	* @JsonProperty(Boolean, "generate_authority_url")
	*/
	private $generateAuthorityUrl;

	/**
	* @JsonProperty(Boolean, "generate_mall_collect_coupon")
	*/
	private $generateMallCollectCoupon;

	/**
	* @JsonProperty(Boolean, "generate_qq_app")
	*/
	private $generateQqApp;

	/**
	* @JsonProperty(Boolean, "generate_schema_url")
	*/
	private $generateSchemaUrl;

	/**
	* @JsonProperty(Boolean, "generate_short_url")
	*/
	private $generateShortUrl;

	/**
	* @JsonProperty(Boolean, "generate_we_app")
	*/
	private $generateWeApp;

	/**
	* @JsonProperty(List<String>, "goods_sign_list")
	*/
	private $goodsSignList;

	/**
	* @JsonProperty(Boolean, "multi_group")
	*/
	private $multiGroup;

	/**
	* @JsonProperty(String, "p_id")
	*/
	private $pId;

	/**
	* @JsonProperty(String, "search_id")
	*/
	private $searchId;

	/**
	* @JsonProperty(Long, "zs_duo_id")
	*/
	private $zsDuoId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cash_gift_id", $this->cashGiftId);
		$this->setUserParam($params, "cash_gift_name", $this->cashGiftName);
		$this->setUserParam($params, "custom_parameters", $this->customParameters);
		$this->setUserParam($params, "force_duo_id", $this->forceDuoId);
		$this->setUserParam($params, "generate_authority_url", $this->generateAuthorityUrl);
		$this->setUserParam($params, "generate_mall_collect_coupon", $this->generateMallCollectCoupon);
		$this->setUserParam($params, "generate_qq_app", $this->generateQqApp);
		$this->setUserParam($params, "generate_schema_url", $this->generateSchemaUrl);
		$this->setUserParam($params, "generate_short_url", $this->generateShortUrl);
		$this->setUserParam($params, "generate_we_app", $this->generateWeApp);
		$this->setUserParam($params, "goods_sign_list", $this->goodsSignList);
		$this->setUserParam($params, "multi_group", $this->multiGroup);
		$this->setUserParam($params, "p_id", $this->pId);
		$this->setUserParam($params, "search_id", $this->searchId);
		$this->setUserParam($params, "zs_duo_id", $this->zsDuoId);

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
		return "pdd.ddk.oauth.goods.prom.url.generate";
	}

	public function setCashGiftId($cashGiftId)
	{
		$this->cashGiftId = $cashGiftId;
	}

	public function setCashGiftName($cashGiftName)
	{
		$this->cashGiftName = $cashGiftName;
	}

	public function setCustomParameters($customParameters)
	{
		$this->customParameters = $customParameters;
	}

	public function setForceDuoId($forceDuoId)
	{
		$this->forceDuoId = $forceDuoId;
	}

	public function setGenerateAuthorityUrl($generateAuthorityUrl)
	{
		$this->generateAuthorityUrl = $generateAuthorityUrl;
	}

	public function setGenerateMallCollectCoupon($generateMallCollectCoupon)
	{
		$this->generateMallCollectCoupon = $generateMallCollectCoupon;
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

	public function setGoodsSignList($goodsSignList)
	{
		$this->goodsSignList = $goodsSignList;
	}

	public function setMultiGroup($multiGroup)
	{
		$this->multiGroup = $multiGroup;
	}

	public function setPId($pId)
	{
		$this->pId = $pId;
	}

	public function setSearchId($searchId)
	{
		$this->searchId = $searchId;
	}

	public function setZsDuoId($zsDuoId)
	{
		$this->zsDuoId = $zsDuoId;
	}

}
