<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddCloudWmsOrderSendRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWmsOrderSendRequest_WmsOrderSendRequest, "wms_order_send_request")
	*/
	private $wmsOrderSendRequest;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "wms_order_send_request", $this->wmsOrderSendRequest);

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
		return "pdd.cloud.wms.order.send";
	}

	public function setWmsOrderSendRequest($wmsOrderSendRequest)
	{
		$this->wmsOrderSendRequest = $wmsOrderSendRequest;
	}

}

class PddCloudWmsOrderSendRequest_WmsOrderSendRequest extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "owner_code")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(String, "owner_name")
	*/
	private $ownerName;

	/**
	* @JsonProperty(String, "warehouse_code")
	*/
	private $warehouseCode;

	/**
	* @JsonProperty(String, "warehouse_type")
	*/
	private $warehouseType;

	/**
	* @JsonProperty(String, "order_type")
	*/
	private $orderType;

	/**
	* @JsonProperty(String, "delivery_order_code")
	*/
	private $deliveryOrderCode;

	/**
	* @JsonProperty(String, "source_order_code")
	*/
	private $sourceOrderCode;

	/**
	* @JsonProperty(String, "source_platform_code")
	*/
	private $sourcePlatformCode;

	/**
	* @JsonProperty(String, "shop_nick")
	*/
	private $shopNick;

	/**
	* @JsonProperty(String, "seller_nick")
	*/
	private $sellerNick;

	/**
	* @JsonProperty(String, "buyer_nick")
	*/
	private $buyerNick;

	/**
	* @JsonProperty(String, "create_time")
	*/
	private $createTime;

	/**
	* @JsonProperty(String, "order_time")
	*/
	private $orderTime;

	/**
	* @JsonProperty(String, "pay_time")
	*/
	private $payTime;

	/**
	* @JsonProperty(String, "operate_time")
	*/
	private $operateTime;

	/**
	* @JsonProperty(String, "order_flag")
	*/
	private $orderFlag;

	/**
	* @JsonProperty(Integer, "total_amount")
	*/
	private $totalAmount;

	/**
	* @JsonProperty(Integer, "discount_amount")
	*/
	private $discountAmount;

	/**
	* @JsonProperty(Integer, "freight")
	*/
	private $freight;

	/**
	* @JsonProperty(Integer, "actual_amount")
	*/
	private $actualAmount;

	/**
	* @JsonProperty(String, "logistics_code")
	*/
	private $logisticsCode;

	/**
	* @JsonProperty(String, "logistics_no")
	*/
	private $logisticsNo;

	/**
	* @JsonProperty(String, "seller_message")
	*/
	private $sellerMessage;

	/**
	* @JsonProperty(String, "buyer_message")
	*/
	private $buyerMessage;

	/**
	* @JsonProperty(Boolean, "invoice_flag")
	*/
	private $invoiceFlag;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWmsOrderSendRequest_WmsOrderSendRequestInvoiceInfo, "invoice_info")
	*/
	private $invoiceInfo;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	/**
	* @JsonProperty(String, "no_stack_tag")
	*/
	private $noStackTag;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWmsOrderSendRequest_WmsOrderSendRequestSenderInfo, "senderInfo")
	*/
	private $senderInfo;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWmsOrderSendRequest_WmsOrderSendRequestReceiverInfo, "receiverInfo")
	*/
	private $receiverInfo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWmsOrderSendRequest_WmsOrderSendRequestOrderLineListItem>, "order_line_list")
	*/
	private $orderLineList;

	/**
	* @JsonProperty(String, "extendProps")
	*/
	private $extendProps;

	/**
	* @JsonProperty(String, "token")
	*/
	private $token;

	/**
	* @JsonProperty(String, "customerId")
	*/
	private $customerId;

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setOwnerName($ownerName)
	{
		$this->ownerName = $ownerName;
	}

	public function setWarehouseCode($warehouseCode)
	{
		$this->warehouseCode = $warehouseCode;
	}

	public function setWarehouseType($warehouseType)
	{
		$this->warehouseType = $warehouseType;
	}

	public function setOrderType($orderType)
	{
		$this->orderType = $orderType;
	}

	public function setDeliveryOrderCode($deliveryOrderCode)
	{
		$this->deliveryOrderCode = $deliveryOrderCode;
	}

	public function setSourceOrderCode($sourceOrderCode)
	{
		$this->sourceOrderCode = $sourceOrderCode;
	}

	public function setSourcePlatformCode($sourcePlatformCode)
	{
		$this->sourcePlatformCode = $sourcePlatformCode;
	}

	public function setShopNick($shopNick)
	{
		$this->shopNick = $shopNick;
	}

	public function setSellerNick($sellerNick)
	{
		$this->sellerNick = $sellerNick;
	}

	public function setBuyerNick($buyerNick)
	{
		$this->buyerNick = $buyerNick;
	}

	public function setCreateTime($createTime)
	{
		$this->createTime = $createTime;
	}

	public function setOrderTime($orderTime)
	{
		$this->orderTime = $orderTime;
	}

	public function setPayTime($payTime)
	{
		$this->payTime = $payTime;
	}

	public function setOperateTime($operateTime)
	{
		$this->operateTime = $operateTime;
	}

	public function setOrderFlag($orderFlag)
	{
		$this->orderFlag = $orderFlag;
	}

	public function setTotalAmount($totalAmount)
	{
		$this->totalAmount = $totalAmount;
	}

	public function setDiscountAmount($discountAmount)
	{
		$this->discountAmount = $discountAmount;
	}

	public function setFreight($freight)
	{
		$this->freight = $freight;
	}

	public function setActualAmount($actualAmount)
	{
		$this->actualAmount = $actualAmount;
	}

	public function setLogisticsCode($logisticsCode)
	{
		$this->logisticsCode = $logisticsCode;
	}

	public function setLogisticsNo($logisticsNo)
	{
		$this->logisticsNo = $logisticsNo;
	}

	public function setSellerMessage($sellerMessage)
	{
		$this->sellerMessage = $sellerMessage;
	}

	public function setBuyerMessage($buyerMessage)
	{
		$this->buyerMessage = $buyerMessage;
	}

	public function setInvoiceFlag($invoiceFlag)
	{
		$this->invoiceFlag = $invoiceFlag;
	}

	public function setInvoiceInfo($invoiceInfo)
	{
		$this->invoiceInfo = $invoiceInfo;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	public function setNoStackTag($noStackTag)
	{
		$this->noStackTag = $noStackTag;
	}

	public function setSenderInfo($senderInfo)
	{
		$this->senderInfo = $senderInfo;
	}

	public function setReceiverInfo($receiverInfo)
	{
		$this->receiverInfo = $receiverInfo;
	}

	public function setOrderLineList($orderLineList)
	{
		$this->orderLineList = $orderLineList;
	}

	public function setExtendProps($extendProps)
	{
		$this->extendProps = $extendProps;
	}

	public function setToken($token)
	{
		$this->token = $token;
	}

	public function setCustomerId($customerId)
	{
		$this->customerId = $customerId;
	}

}

class PddCloudWmsOrderSendRequest_WmsOrderSendRequestInvoiceInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "invoice_type")
	*/
	private $invoiceType;

	/**
	* @JsonProperty(String, "invoice_head")
	*/
	private $invoiceHead;

	/**
	* @JsonProperty(String, "invoice_content")
	*/
	private $invoiceContent;

	/**
	* @JsonProperty(String, "invoice_tax_number")
	*/
	private $invoiceTaxNumber;

	/**
	* @JsonProperty(String, "invoice_ext_fields")
	*/
	private $invoiceExtFields;

	public function setInvoiceType($invoiceType)
	{
		$this->invoiceType = $invoiceType;
	}

	public function setInvoiceHead($invoiceHead)
	{
		$this->invoiceHead = $invoiceHead;
	}

	public function setInvoiceContent($invoiceContent)
	{
		$this->invoiceContent = $invoiceContent;
	}

	public function setInvoiceTaxNumber($invoiceTaxNumber)
	{
		$this->invoiceTaxNumber = $invoiceTaxNumber;
	}

	public function setInvoiceExtFields($invoiceExtFields)
	{
		$this->invoiceExtFields = $invoiceExtFields;
	}

}

class PddCloudWmsOrderSendRequest_WmsOrderSendRequestSenderInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWmsOrderSendRequest_WmsOrderSendRequestSenderInfoAddress, "address")
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

	/**
	* @JsonProperty(String, "zipcode")
	*/
	private $zipcode;

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

	public function setZipcode($zipcode)
	{
		$this->zipcode = $zipcode;
	}

}

class PddCloudWmsOrderSendRequest_WmsOrderSendRequestSenderInfoAddress extends PopBaseJsonEntity
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

class PddCloudWmsOrderSendRequest_WmsOrderSendRequestReceiverInfo extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddCloudWmsOrderSendRequest_WmsOrderSendRequestReceiverInfoAddress, "address")
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

	/**
	* @JsonProperty(String, "zipcode")
	*/
	private $zipcode;

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

	public function setZipcode($zipcode)
	{
		$this->zipcode = $zipcode;
	}

}

class PddCloudWmsOrderSendRequest_WmsOrderSendRequestReceiverInfoAddress extends PopBaseJsonEntity
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

class PddCloudWmsOrderSendRequest_WmsOrderSendRequestOrderLineListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "order_line_no")
	*/
	private $orderLineNo;

	/**
	* @JsonProperty(String, "source_order_code")
	*/
	private $sourceOrderCode;

	/**
	* @JsonProperty(String, "sub_source_order_code")
	*/
	private $subSourceOrderCode;

	/**
	* @JsonProperty(String, "owner_code")
	*/
	private $ownerCode;

	/**
	* @JsonProperty(String, "item_id")
	*/
	private $itemId;

	/**
	* @JsonProperty(String, "item_code")
	*/
	private $itemCode;

	/**
	* @JsonProperty(String, "item_name")
	*/
	private $itemName;

	/**
	* @JsonProperty(Integer, "item_quantity")
	*/
	private $itemQuantity;

	/**
	* @JsonProperty(String, "retail_price")
	*/
	private $retailPrice;

	/**
	* @JsonProperty(String, "actual_price")
	*/
	private $actualPrice;

	/**
	* @JsonProperty(String, "discount_amount")
	*/
	private $discountAmount;

	/**
	* @JsonProperty(String, "batch_code")
	*/
	private $batchCode;

	/**
	* @JsonProperty(String, "remark")
	*/
	private $remark;

	/**
	* @JsonProperty(String, "order_ext_fields")
	*/
	private $orderExtFields;

	public function setOrderLineNo($orderLineNo)
	{
		$this->orderLineNo = $orderLineNo;
	}

	public function setSourceOrderCode($sourceOrderCode)
	{
		$this->sourceOrderCode = $sourceOrderCode;
	}

	public function setSubSourceOrderCode($subSourceOrderCode)
	{
		$this->subSourceOrderCode = $subSourceOrderCode;
	}

	public function setOwnerCode($ownerCode)
	{
		$this->ownerCode = $ownerCode;
	}

	public function setItemId($itemId)
	{
		$this->itemId = $itemId;
	}

	public function setItemCode($itemCode)
	{
		$this->itemCode = $itemCode;
	}

	public function setItemName($itemName)
	{
		$this->itemName = $itemName;
	}

	public function setItemQuantity($itemQuantity)
	{
		$this->itemQuantity = $itemQuantity;
	}

	public function setRetailPrice($retailPrice)
	{
		$this->retailPrice = $retailPrice;
	}

	public function setActualPrice($actualPrice)
	{
		$this->actualPrice = $actualPrice;
	}

	public function setDiscountAmount($discountAmount)
	{
		$this->discountAmount = $discountAmount;
	}

	public function setBatchCode($batchCode)
	{
		$this->batchCode = $batchCode;
	}

	public function setRemark($remark)
	{
		$this->remark = $remark;
	}

	public function setOrderExtFields($orderExtFields)
	{
		$this->orderExtFields = $orderExtFields;
	}

}
