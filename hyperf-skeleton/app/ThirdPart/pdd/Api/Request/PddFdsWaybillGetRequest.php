<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddFdsWaybillGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequest, "param_fds_waybill_get_request")
	*/
	private $paramFdsWaybillGetRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "param_fds_waybill_get_request", $this->paramFdsWaybillGetRequest);

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
		return "pdd.fds.waybill.get";
	}

	public function setParamFdsWaybillGetRequest($paramFdsWaybillGetRequest)
	{
		$this->paramFdsWaybillGetRequest = $paramFdsWaybillGetRequest;
	}

}

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestSender, "sender")
	*/
	private $sender;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItem>, "trade_order_info_dtos")
	*/
	private $tradeOrderInfoDtos;

	/**
	* @JsonProperty(String, "wp_code")
	*/
	private $wpCode;

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

}

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestSender extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestSenderAddress, "address")
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

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestSenderAddress extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "city")
	*/
	private $city;

	/**
	* @JsonProperty(String, "country")
	*/
	private $country;

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

	public function setCity($city)
	{
		$this->city = $city;
	}

	public function setCountry($country)
	{
		$this->country = $country;
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

}

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItem extends PopBaseJsonEntity
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
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemOrderInfo, "order_info")
	*/
	private $orderInfo;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemPackageInfo, "package_info")
	*/
	private $packageInfo;

	/**
	* @JsonProperty(String, "template_url")
	*/
	private $templateUrl;

	/**
	* @JsonProperty(Long, "user_id")
	*/
	private $userId;

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

	public function setTemplateUrl($templateUrl)
	{
		$this->templateUrl = $templateUrl;
	}

	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

}

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemOrderInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "order_channels_type")
	*/
	private $orderChannelsType;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemOrderInfoTradeOrderListItem>, "trade_order_list")
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

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemOrderInfoTradeOrderListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "mall_mask_id")
	*/
	private $mallMaskId;

	/**
	* @JsonProperty(String, "order_mask_sn")
	*/
	private $orderMaskSn;

	public function setMallMaskId($mallMaskId)
	{
		$this->mallMaskId = $mallMaskId;
	}

	public function setOrderMaskSn($orderMaskSn)
	{
		$this->orderMaskSn = $orderMaskSn;
	}

}

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemPackageInfo extends PopBaseJsonEntity
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
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemPackageInfoItemsItem>, "items")
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
	* @JsonProperty(Integer, "volume")
	*/
	private $volume;

	/**
	* @JsonProperty(Integer, "weight")
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

class PddFdsWaybillGetRequest_ParamFdsWaybillGetRequestTradeOrderInfoDtosItemPackageInfoItemsItem extends PopBaseJsonEntity
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
