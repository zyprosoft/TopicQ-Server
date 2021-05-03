<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudWaybillGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequest, "param_waybill_cloud_print_apply_new_request")
	*/
	private $paramWaybillCloudPrintApplyNewRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "param_waybill_cloud_print_apply_new_request", $this->paramWaybillCloudPrintApplyNewRequest);

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
		return "pdd.cloud.waybill.get";
	}

	public function setParamWaybillCloudPrintApplyNewRequest($paramWaybillCloudPrintApplyNewRequest)
	{
		$this->paramWaybillCloudPrintApplyNewRequest = $paramWaybillCloudPrintApplyNewRequest;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Boolean, "need_encrypt")
	*/
	private $needEncrypt;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestSender, "sender")
	*/
	private $sender;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItem>, "trade_order_info_dtos")
	*/
	private $tradeOrderInfoDtos;

	/**
	* @JsonProperty(String, "wp_code")
	*/
	private $wpCode;

	/**
	* @JsonProperty(String, "token")
	*/
	private $token;

	/**
	* @JsonProperty(Long, "ext_id")
	*/
	private $extId;

	/**
	* @JsonProperty(String, "extendProps")
	*/
	private $extendProps;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	public function setNeedEncrypt($needEncrypt)
	{
		$this->needEncrypt = $needEncrypt;
	}

	public function setSender($sender)
	{
		$this->sender = $sender;
	}

	public function setTradeOrderInfoDtos($tradeOrderInfoDtos)
	{
		$this->tradeOrderInfoDtos = $tradeOrderInfoDtos;
	}

	public function setWpCode($wpCode)
	{
		$this->wpCode = $wpCode;
	}

	public function setToken($token)
	{
		$this->token = $token;
	}

	public function setExtId($extId)
	{
		$this->extId = $extId;
	}

	public function setExtendProps($extendProps)
	{
		$this->extendProps = $extendProps;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestSender extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestSenderAddress, "address")
	*/
	private $address;

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "phone")
	*/
	private $phone;

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestSenderAddress extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "city")
	*/
	private $city;

	/**
	* @JsonProperty(String, "detail")
	*/
	private $detail;

	/**
	* @JsonProperty(String, "district")
	*/
	private $district;

	/**
	* @JsonProperty(String, "province")
	*/
	private $province;

	/**
	* @JsonProperty(String, "town")
	*/
	private $town;

	/**
	* @JsonProperty(String, "country")
	*/
	private $country;

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function setDetail($detail)
	{
		$this->detail = $detail;
	}

	public function setDistrict($district)
	{
		$this->district = $district;
	}

	public function setProvince($province)
	{
		$this->province = $province;
	}

	public function setTown($town)
	{
		$this->town = $town;
	}

	public function setCountry($country)
	{
		$this->country = $country;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "logistics_services")
	*/
	private $logisticsServices;

	/**
	* @JsonProperty(String, "object_id")
	*/
	private $objectId;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemOrderInfo, "order_info")
	*/
	private $orderInfo;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemPackageInfo, "package_info")
	*/
	private $packageInfo;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemRecipient, "recipient")
	*/
	private $recipient;

	/**
	* @JsonProperty(String, "user_id")
	*/
	private $userId;

	/**
	* @JsonProperty(String, "template_url")
	*/
	private $templateUrl;

	public function setLogisticsServices($logisticsServices)
	{
		$this->logisticsServices = $logisticsServices;
	}

	public function setObjectId($objectId)
	{
		$this->objectId = $objectId;
	}

	public function setOrderInfo($orderInfo)
	{
		$this->orderInfo = $orderInfo;
	}

	public function setPackageInfo($packageInfo)
	{
		$this->packageInfo = $packageInfo;
	}

	public function setRecipient($recipient)
	{
		$this->recipient = $recipient;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	public function setTemplateUrl($templateUrl)
	{
		$this->templateUrl = $templateUrl;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemOrderInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "order_channels_type")
	*/
	private $orderChannelsType;

	/**
	* @JsonProperty(List<String>, "trade_order_list")
	*/
	private $tradeOrderList;

	public function setOrderChannelsType($orderChannelsType)
	{
		$this->orderChannelsType = $orderChannelsType;
	}

	public function setTradeOrderList($tradeOrderList)
	{
		$this->tradeOrderList = $tradeOrderList;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemPackageInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "goods_description")
	*/
	private $goodsDescription;

	/**
	* @JsonProperty(String, "id")
	*/
	private $id;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemPackageInfoItemsItem>, "items")
	*/
	private $items;

	/**
	* @JsonProperty(String, "packaging_description")
	*/
	private $packagingDescription;

	/**
	* @JsonProperty(String, "total_packages_count")
	*/
	private $totalPackagesCount;

	/**
	* @JsonProperty(String, "volume")
	*/
	private $volume;

	/**
	* @JsonProperty(String, "weight")
	*/
	private $weight;

	public function setGoodsDescription($goodsDescription)
	{
		$this->goodsDescription = $goodsDescription;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setItems($items)
	{
		$this->items = $items;
	}

	public function setPackagingDescription($packagingDescription)
	{
		$this->packagingDescription = $packagingDescription;
	}

	public function setTotalPackagesCount($totalPackagesCount)
	{
		$this->totalPackagesCount = $totalPackagesCount;
	}

	public function setVolume($volume)
	{
		$this->volume = $volume;
	}

	public function setWeight($weight)
	{
		$this->weight = $weight;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemPackageInfoItemsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "count")
	*/
	private $count;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemRecipient extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemRecipientAddress, "address")
	*/
	private $address;

	/**
	* @JsonProperty(String, "mobile")
	*/
	private $mobile;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	/**
	* @JsonProperty(String, "phone")
	*/
	private $phone;

	public function setAddress($address)
	{
		$this->address = $address;
	}

	public function setMobile($mobile)
	{
		$this->mobile = $mobile;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setPhone($phone)
	{
		$this->phone = $phone;
	}

}

class PddCloudWaybillGetRequest_ParamWaybillCloudPrintApplyNewRequestTradeOrderInfoDtosItemRecipientAddress extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "city")
	*/
	private $city;

	/**
	* @JsonProperty(String, "detail")
	*/
	private $detail;

	/**
	* @JsonProperty(String, "district")
	*/
	private $district;

	/**
	* @JsonProperty(String, "province")
	*/
	private $province;

	/**
	* @JsonProperty(String, "town")
	*/
	private $town;

	/**
	* @JsonProperty(String, "country")
	*/
	private $country;

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function setDetail($detail)
	{
		$this->detail = $detail;
	}

	public function setDistrict($district)
	{
		$this->district = $district;
	}

	public function setProvince($province)
	{
		$this->province = $province;
	}

	public function setTown($town)
	{
		$this->town = $town;
	}

	public function setCountry($country)
	{
		$this->country = $country;
	}

}
