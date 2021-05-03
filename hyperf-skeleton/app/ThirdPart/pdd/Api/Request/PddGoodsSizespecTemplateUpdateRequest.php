<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddGoodsSizespecTemplateUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSizespecTemplateUpdateRequest_SizeSpecDto, "size_spec_dto")
	*/
	private $sizeSpecDto;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "size_spec_dto", $this->sizeSpecDto);

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
		return "pdd.goods.sizespec.template.update";
	}

	public function setSizeSpecDto($sizeSpecDto)
	{
		$this->sizeSpecDto = $sizeSpecDto;
	}

}

class PddGoodsSizespecTemplateUpdateRequest_SizeSpecDto extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "class_id")
	*/
	private $classId;

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContent, "content")
	*/
	private $content;

	/**
	* @JsonProperty(Long, "id")
	*/
	private $id;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	public function setClassId($classId)
	{
		$this->classId = $classId;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

}

class PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContent extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentMeta, "meta")
	*/
	private $meta;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentRecordsItem>, "records")
	*/
	private $records;

	public function setMeta($meta)
	{
		$this->meta = $meta;
	}

	public function setRecords($records)
	{
		$this->records = $records;
	}

}

class PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentMeta extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentMetaElementsItem>, "elements")
	*/
	private $elements;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentMetaGroupsItem>, "groups")
	*/
	private $groups;

	public function setElements($elements)
	{
		$this->elements = $elements;
	}

	public function setGroups($groups)
	{
		$this->groups = $groups;
	}

}

class PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentMetaElementsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "id")
	*/
	private $id;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

}

class PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentMetaGroupsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "id")
	*/
	private $id;

	/**
	* @JsonProperty(String, "name")
	*/
	private $name;

	public function setId($id)
	{
		$this->id = $id;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

}

class PddGoodsSizespecTemplateUpdateRequest_SizeSpecDtoContentRecordsItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddGoodsSizespecTemplateUpdateRequest_tring, String>, "values")
	*/
	private $values;

	public function setValues($values)
	{
		$this->values = $values;
	}

}
