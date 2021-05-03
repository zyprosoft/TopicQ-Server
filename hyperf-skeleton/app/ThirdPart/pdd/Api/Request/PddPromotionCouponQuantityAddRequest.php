<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPromotionCouponQuantityAddRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(Long, "batch_id")
	*/
	private $batchId;

	/**
	* @JsonProperty(Long, "add_quantity")
	*/
	private $addQuantity;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "batch_id", $this->batchId);
		$this->setUserParam($params, "add_quantity", $this->addQuantity);

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
		return "pdd.promotion.coupon.quantity.add";
	}

	public function setBatchId($batchId)
	{
		$this->batchId = $batchId;
	}

	public function setAddQuantity($addQuantity)
	{
		$this->addQuantity = $addQuantity;
	}

}
