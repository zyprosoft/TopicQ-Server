<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionGoodsCouponCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "batch_desc")
	*/
	private $batchDesc;

	/**
	* @JsonProperty(Long, "batch_start_time")
	*/
	private $batchStartTime;

	/**
	* @JsonProperty(Long, "batch_end_time")
	*/
	private $batchEndTime;

	/**
	* @JsonProperty(Long, "discount")
	*/
	private $discount;

	/**
	* @JsonProperty(Long, "init_quantity")
	*/
	private $initQuantity;

	/**
	* @JsonProperty(Long, "user_limit")
	*/
	private $userLimit;

	/**
	* @JsonProperty(Long, "goods_id")
	*/
	private $goodsId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "batch_desc", $this->batchDesc);
		$this->setUserParam($params, "batch_start_time", $this->batchStartTime);
		$this->setUserParam($params, "batch_end_time", $this->batchEndTime);
		$this->setUserParam($params, "discount", $this->discount);
		$this->setUserParam($params, "init_quantity", $this->initQuantity);
		$this->setUserParam($params, "user_limit", $this->userLimit);
		$this->setUserParam($params, "goods_id", $this->goodsId);

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
		return "pdd.promotion.goods.coupon.create";
	}

	public function setBatchDesc($batchDesc)
	{
		$this->batchDesc = $batchDesc;
	}

	public function setBatchStartTime($batchStartTime)
	{
		$this->batchStartTime = $batchStartTime;
	}

	public function setBatchEndTime($batchEndTime)
	{
		$this->batchEndTime = $batchEndTime;
	}

	public function setDiscount($discount)
	{
		$this->discount = $discount;
	}

	public function setInitQuantity($initQuantity)
	{
		$this->initQuantity = $initQuantity;
	}

	public function setUserLimit($userLimit)
	{
		$this->userLimit = $userLimit;
	}

	public function setGoodsId($goodsId)
	{
		$this->goodsId = $goodsId;
	}

}
