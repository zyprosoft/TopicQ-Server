<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsLogisticsTemplateCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsLogisticsTemplateCreateRequest_CostTemplateListItem>, "cost_template_list")
	*/
	private $costTemplateList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsLogisticsTemplateCreateRequest_FreeProvinceListItem>, "free_province_list")
	*/
	private $freeProvinceList;

	/**
	* @JsonProperty(Integer, "cost_type")
	*/
	private $costType;

	/**
	* @JsonProperty(String, "template_name")
	*/
	private $templateName;

	/**
	* @JsonProperty(Integer, "province_id")
	*/
	private $provinceId;

	/**
	* @JsonProperty(Integer, "city_id")
	*/
	private $cityId;

	/**
	* @JsonProperty(Integer, "district_id")
	*/
	private $districtId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "cost_template_list", $this->costTemplateList);
		$this->setUserParam($params, "free_province_list", $this->freeProvinceList);
		$this->setUserParam($params, "cost_type", $this->costType);
		$this->setUserParam($params, "template_name", $this->templateName);
		$this->setUserParam($params, "province_id", $this->provinceId);
		$this->setUserParam($params, "city_id", $this->cityId);
		$this->setUserParam($params, "district_id", $this->districtId);

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
		return "pdd.goods.logistics.template.create";
	}

	public function setCostTemplateList($costTemplateList)
	{
		$this->costTemplateList = $costTemplateList;
	}

	public function setFreeProvinceList($freeProvinceList)
	{
		$this->freeProvinceList = $freeProvinceList;
	}

	public function setCostType($costType)
	{
		$this->costType = $costType;
	}

	public function setTemplateName($templateName)
	{
		$this->templateName = $templateName;
	}

	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
	}

	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
	}

	public function setDistrictId($districtId)
	{
		$this->districtId = $districtId;
	}

}

class PddGoodsLogisticsTemplateCreateRequest_CostTemplateListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "first_standard")
	*/
	private $firstStandard;

	/**
	* @JsonProperty(Long, "first_cost")
	*/
	private $firstCost;

	/**
	* @JsonProperty(Long, "add_standard")
	*/
	private $addStandard;

	/**
	* @JsonProperty(Long, "add_cost")
	*/
	private $addCost;

	/**
	* @JsonProperty(Boolean, "is_have_free_min_count")
	*/
	private $isHaveFreeMinCount;

	/**
	* @JsonProperty(Integer, "have_free_min_count")
	*/
	private $haveFreeMinCount;

	/**
	* @JsonProperty(Boolean, "is_have_free_min_amount")
	*/
	private $isHaveFreeMinAmount;

	/**
	* @JsonProperty(Long, "have_free_min_amount")
	*/
	private $haveFreeMinAmount;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsLogisticsTemplateCreateRequest_CostTemplateListItemCostProvinceListItem>, "cost_province_list")
	*/
	private $costProvinceList;

	public function setFirstStandard($firstStandard)
	{
		$this->firstStandard = $firstStandard;
	}

	public function setFirstCost($firstCost)
	{
		$this->firstCost = $firstCost;
	}

	public function setAddStandard($addStandard)
	{
		$this->addStandard = $addStandard;
	}

	public function setAddCost($addCost)
	{
		$this->addCost = $addCost;
	}

	public function setIsHaveFreeMinCount($isHaveFreeMinCount)
	{
		$this->isHaveFreeMinCount = $isHaveFreeMinCount;
	}

	public function setHaveFreeMinCount($haveFreeMinCount)
	{
		$this->haveFreeMinCount = $haveFreeMinCount;
	}

	public function setIsHaveFreeMinAmount($isHaveFreeMinAmount)
	{
		$this->isHaveFreeMinAmount = $isHaveFreeMinAmount;
	}

	public function setHaveFreeMinAmount($haveFreeMinAmount)
	{
		$this->haveFreeMinAmount = $haveFreeMinAmount;
	}

	public function setCostProvinceList($costProvinceList)
	{
		$this->costProvinceList = $costProvinceList;
	}

}

class PddGoodsLogisticsTemplateCreateRequest_CostTemplateListItemCostProvinceListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "province_id")
	*/
	private $provinceId;

	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
	}

}

class PddGoodsLogisticsTemplateCreateRequest_FreeProvinceListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "province_id")
	*/
	private $provinceId;

	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
	}

}
