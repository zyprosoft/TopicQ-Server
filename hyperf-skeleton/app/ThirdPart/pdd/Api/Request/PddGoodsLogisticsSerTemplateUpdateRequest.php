<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsLogisticsSerTemplateUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "template_id")
	*/
	private $templateId;

	/**
	* @JsonProperty(Integer, "template_type")
	*/
	private $templateType;

	/**
	* @JsonProperty(String, "template_name")
	*/
	private $templateName;

	/**
	* @JsonProperty(Integer, "price_unit")
	*/
	private $priceUnit;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsLogisticsSerTemplateUpdateRequest_ServiceAreaListItem>, "service_area_list")
	*/
	private $serviceAreaList;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsLogisticsSerTemplateUpdateRequest_CatListItem>, "cat_list")
	*/
	private $catList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "template_id", $this->templateId);
		$this->setUserParam($params, "template_type", $this->templateType);
		$this->setUserParam($params, "template_name", $this->templateName);
		$this->setUserParam($params, "price_unit", $this->priceUnit);
		$this->setUserParam($params, "service_area_list", $this->serviceAreaList);
		$this->setUserParam($params, "cat_list", $this->catList);

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
		return "pdd.goods.logistics.ser.template.update";
	}

	public function setTemplateId($templateId)
	{
		$this->templateId = $templateId;
	}

	public function setTemplateType($templateType)
	{
		$this->templateType = $templateType;
	}

	public function setTemplateName($templateName)
	{
		$this->templateName = $templateName;
	}

	public function setPriceUnit($priceUnit)
	{
		$this->priceUnit = $priceUnit;
	}

	public function setServiceAreaList($serviceAreaList)
	{
		$this->serviceAreaList = $serviceAreaList;
	}

	public function setCatList($catList)
	{
		$this->catList = $catList;
	}

}

class PddGoodsLogisticsSerTemplateUpdateRequest_ServiceAreaListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "value")
	*/
	private $value;

	/**
	* @JsonProperty(String, "district_id")
	*/
	private $districtId;

	/**
	* @JsonProperty(String, "city_id")
	*/
	private $cityId;

	/**
	* @JsonProperty(String, "province_id")
	*/
	private $provinceId;

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setDistrictId($districtId)
	{
		$this->districtId = $districtId;
	}

	public function setCityId($cityId)
	{
		$this->cityId = $cityId;
	}

	public function setProvinceId($provinceId)
	{
		$this->provinceId = $provinceId;
	}

}

class PddGoodsLogisticsSerTemplateUpdateRequest_CatListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsLogisticsSerTemplateUpdateRequest_CatListItemListItem>, "list")
	*/
	private $list;

	/**
	* @JsonProperty(Long, "cat_id4")
	*/
	private $catId4;

	/**
	* @JsonProperty(Long, "cat_id3")
	*/
	private $catId3;

	public function setList($list)
	{
		$this->list = $list;
	}

	public function setCatId4($catId4)
	{
		$this->catId4 = $catId4;
	}

	public function setCatId3($catId3)
	{
		$this->catId3 = $catId3;
	}

}

class PddGoodsLogisticsSerTemplateUpdateRequest_CatListItemListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsLogisticsSerTemplateUpdateRequest_CatListItemListItemContentItem>, "content")
	*/
	private $content;

	/**
	* @JsonProperty(Long, "value")
	*/
	private $value;

	/**
	* @JsonProperty(Integer, "limit_type")
	*/
	private $limitType;

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

	public function setLimitType($limitType)
	{
		$this->limitType = $limitType;
	}

}

class PddGoodsLogisticsSerTemplateUpdateRequest_CatListItemListItemContentItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Long, "price")
	*/
	private $price;

	/**
	* @JsonProperty(Long, "max_pro")
	*/
	private $maxPro;

	/**
	* @JsonProperty(Long, "min_pro")
	*/
	private $minPro;

	public function setPrice($price)
	{
		$this->price = $price;
	}

	public function setMaxPro($maxPro)
	{
		$this->maxPro = $maxPro;
	}

	public function setMinPro($minPro)
	{
		$this->minPro = $minPro;
	}

}
