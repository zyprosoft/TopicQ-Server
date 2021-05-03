<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddOrderNoteUpdateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "note")
	*/
	private $note;

	/**
	* @JsonProperty(Integer, "tag")
	*/
	private $tag;

	/**
	* @JsonProperty(String, "tag_name")
	*/
	private $tagName;

	/**
	* @JsonProperty(String, "order_sn")
	*/
	private $orderSn;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "note", $this->note);
		$this->setUserParam($params, "tag", $this->tag);
		$this->setUserParam($params, "tag_name", $this->tagName);
		$this->setUserParam($params, "order_sn", $this->orderSn);

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
		return "pdd.order.note.update";
	}

	public function setNote($note)
	{
		$this->note = $note;
	}

	public function setTag($tag)
	{
		$this->tag = $tag;
	}

	public function setTagName($tagName)
	{
		$this->tagName = $tagName;
	}

	public function setOrderSn($orderSn)
	{
		$this->orderSn = $orderSn;
	}

}
