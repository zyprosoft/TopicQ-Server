<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTraceSourceUploadPlanInfoRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "arrive_time")
	*/
	private $arriveTime;

	/**
	* @JsonProperty(String, "bill_no")
	*/
	private $billNo;

	/**
	* @JsonProperty(String, "ciq_date")
	*/
	private $ciqDate;

	/**
	* @JsonProperty(String, "ciq_no")
	*/
	private $ciqNo;

	/**
	* @JsonProperty(String, "dealer_org")
	*/
	private $dealerOrg;

	/**
	* @JsonProperty(String, "declare_org")
	*/
	private $declareOrg;

	/**
	* @JsonProperty(String, "desp_port_name")
	*/
	private $despPortName;

	/**
	* @JsonProperty(String, "entry_date")
	*/
	private $entryDate;

	/**
	* @JsonProperty(String, "entry_no")
	*/
	private $entryNo;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddTraceSourceUploadPlanInfoRequest_GoodsItem>, "goods")
	*/
	private $goods;

	/**
	* @JsonProperty(String, "list_date")
	*/
	private $listDate;

	/**
	* @JsonProperty(String, "list_no")
	*/
	private $listNo;

	/**
	* @JsonProperty(String, "load_port")
	*/
	private $loadPort;

	/**
	* @JsonProperty(Long, "mall_id")
	*/
	private $mallId;

	/**
	* @JsonProperty(String, "mall_name")
	*/
	private $mallName;

	/**
	* @JsonProperty(String, "plan_active_time")
	*/
	private $planActiveTime;

	/**
	* @JsonProperty(String, "plan_created_time")
	*/
	private $planCreatedTime;

	/**
	* @JsonProperty(String, "plan_no")
	*/
	private $planNo;

	/**
	* @JsonProperty(String, "port")
	*/
	private $port;

	/**
	* @JsonProperty(String, "transport_mode")
	*/
	private $transportMode;

	/**
	* @JsonProperty(String, "warehouse_name")
	*/
	private $warehouseName;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "arrive_time", $this->arriveTime);
		$this->setUserParam($params, "bill_no", $this->billNo);
		$this->setUserParam($params, "ciq_date", $this->ciqDate);
		$this->setUserParam($params, "ciq_no", $this->ciqNo);
		$this->setUserParam($params, "dealer_org", $this->dealerOrg);
		$this->setUserParam($params, "declare_org", $this->declareOrg);
		$this->setUserParam($params, "desp_port_name", $this->despPortName);
		$this->setUserParam($params, "entry_date", $this->entryDate);
		$this->setUserParam($params, "entry_no", $this->entryNo);
		$this->setUserParam($params, "goods", $this->goods);
		$this->setUserParam($params, "list_date", $this->listDate);
		$this->setUserParam($params, "list_no", $this->listNo);
		$this->setUserParam($params, "load_port", $this->loadPort);
		$this->setUserParam($params, "mall_id", $this->mallId);
		$this->setUserParam($params, "mall_name", $this->mallName);
		$this->setUserParam($params, "plan_active_time", $this->planActiveTime);
		$this->setUserParam($params, "plan_created_time", $this->planCreatedTime);
		$this->setUserParam($params, "plan_no", $this->planNo);
		$this->setUserParam($params, "port", $this->port);
		$this->setUserParam($params, "transport_mode", $this->transportMode);
		$this->setUserParam($params, "warehouse_name", $this->warehouseName);

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
		return "pdd.trace.source.upload.plan.info";
	}

	public function setArriveTime($arriveTime)
	{
		$this->arriveTime = $arriveTime;
	}

	public function setBillNo($billNo)
	{
		$this->billNo = $billNo;
	}

	public function setCiqDate($ciqDate)
	{
		$this->ciqDate = $ciqDate;
	}

	public function setCiqNo($ciqNo)
	{
		$this->ciqNo = $ciqNo;
	}

	public function setDealerOrg($dealerOrg)
	{
		$this->dealerOrg = $dealerOrg;
	}

	public function setDeclareOrg($declareOrg)
	{
		$this->declareOrg = $declareOrg;
	}

	public function setDespPortName($despPortName)
	{
		$this->despPortName = $despPortName;
	}

	public function setEntryDate($entryDate)
	{
		$this->entryDate = $entryDate;
	}

	public function setEntryNo($entryNo)
	{
		$this->entryNo = $entryNo;
	}

	public function setGoods($goods)
	{
		$this->goods = $goods;
	}

	public function setListDate($listDate)
	{
		$this->listDate = $listDate;
	}

	public function setListNo($listNo)
	{
		$this->listNo = $listNo;
	}

	public function setLoadPort($loadPort)
	{
		$this->loadPort = $loadPort;
	}

	public function setMallId($mallId)
	{
		$this->mallId = $mallId;
	}

	public function setMallName($mallName)
	{
		$this->mallName = $mallName;
	}

	public function setPlanActiveTime($planActiveTime)
	{
		$this->planActiveTime = $planActiveTime;
	}

	public function setPlanCreatedTime($planCreatedTime)
	{
		$this->planCreatedTime = $planCreatedTime;
	}

	public function setPlanNo($planNo)
	{
		$this->planNo = $planNo;
	}

	public function setPort($port)
	{
		$this->port = $port;
	}

	public function setTransportMode($transportMode)
	{
		$this->transportMode = $transportMode;
	}

	public function setWarehouseName($warehouseName)
	{
		$this->warehouseName = $warehouseName;
	}

}

class PddTraceSourceUploadPlanInfoRequest_GoodsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "code_amount")
	*/
	private $codeAmount;

	/**
	* @JsonProperty(String, "end_serial_no")
	*/
	private $endSerialNo;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	/**
	* @JsonProperty(String, "goods_image_url")
	*/
	private $goodsImageUrl;

	/**
	* @JsonProperty(String, "goods_name")
	*/
	private $goodsName;

	/**
	* @JsonProperty(String, "goods_origin")
	*/
	private $goodsOrigin;

	/**
	* @JsonProperty(String, "goods_property")
	*/
	private $goodsProperty;

	/**
	* @JsonProperty(String, "goods_sku_no")
	*/
	private $goodsSkuNo;

	/**
	* @JsonProperty(String, "hs_code")
	*/
	private $hsCode;

	/**
	* @JsonProperty(String, "hs_name")
	*/
	private $hsName;

	/**
	* @JsonProperty(String, "start_serial_no")
	*/
	private $startSerialNo;

	public function setCodeAmount($codeAmount)
	{
		$this->codeAmount = $codeAmount;
	}

	public function setEndSerialNo($endSerialNo)
	{
		$this->endSerialNo = $endSerialNo;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

	public function setGoodsImageUrl($goodsImageUrl)
	{
		$this->goodsImageUrl = $goodsImageUrl;
	}

	public function setGoodsName($goodsName)
	{
		$this->goodsName = $goodsName;
	}

	public function setGoodsOrigin($goodsOrigin)
	{
		$this->goodsOrigin = $goodsOrigin;
	}

	public function setGoodsProperty($goodsProperty)
	{
		$this->goodsProperty = $goodsProperty;
	}

	public function setGoodsSkuNo($goodsSkuNo)
	{
		$this->goodsSkuNo = $goodsSkuNo;
	}

	public function setHsCode($hsCode)
	{
		$this->hsCode = $hsCode;
	}

	public function setHsName($hsName)
	{
		$this->hsName = $hsName;
	}

	public function setStartSerialNo($startSerialNo)
	{
		$this->startSerialNo = $startSerialNo;
	}

}
