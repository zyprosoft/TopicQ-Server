<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudWaybillUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequest, "waybill_cloud_print_update_request")
	*/
	private $waybillCloudPrintUpdateRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "waybill_cloud_print_update_request", $this->waybillCloudPrintUpdateRequest);

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
		return "pdd.cloud.waybill.update";
	}

	public function setWaybillCloudPrintUpdateRequest($waybillCloudPrintUpdateRequest)
	{
		$this->waybillCloudPrintUpdateRequest = $waybillCloudPrintUpdateRequest;
	}

}

class PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "object_id")
	*/
	private $objectId;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestPackageInfo, "package_info")
	*/
	private $packageInfo;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestRecipient, "recipient")
	*/
	private $recipient;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestSender, "sender")
	*/
	private $sender;

	/**
	* @JsonProperty(String, "template_url")
	*/
	private $templateUrl;

	/**
	* @JsonProperty(String, "waybill_code")
	*/
	private $waybillCode;

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
	* @JsonProperty(String, "ext_fields")
	*/
	private $extFields;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	public function setObjectId($objectId)
	{
		$this->objectId = $objectId;
	}

	public function setPackageInfo($packageInfo)
	{
		$this->packageInfo = $packageInfo;
	}

	public function setRecipient($recipient)
	{
		$this->recipient = $recipient;
	}

	public function setSender($sender)
	{
		$this->sender = $sender;
	}

	public function setTemplateUrl($templateUrl)
	{
		$this->templateUrl = $templateUrl;
	}

	public function setWaybillCode($waybillCode)
	{
		$this->waybillCode = $waybillCode;
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

	public function setExtFields($extFields)
	{
		$this->extFields = $extFields;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

}

class PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestPackageInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestPackageInfoItemsItem>, "items")
	*/
	private $items;

	/**
	* @JsonProperty(Long, "volume")
	*/
	private $volume;

	/**
	* @JsonProperty(Long, "weight")
	*/
	private $weight;

	public function setItems($items)
	{
		$this->items = $items;
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

class PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestPackageInfoItemsItem extends PopBaseJsonEntity
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

	/**
	* @JsonProperty(String, "ext_json")
	*/
	private $extJson;

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	public function setExtJson($extJson)
	{
		$this->extJson = $extJson;
	}

}

class PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestRecipient extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestRecipientAddress, "address")
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

class PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestRecipientAddress extends PopBaseJsonEntity
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

class PddCloudWaybillUpdateRequest_WaybillCloudPrintUpdateRequestSender extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

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
