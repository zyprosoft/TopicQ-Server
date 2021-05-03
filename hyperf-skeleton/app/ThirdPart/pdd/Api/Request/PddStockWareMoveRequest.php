<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddStockWareMoveRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(\Com\Pdd\Pop\Sdk\Api\Request\PddStockWareMoveRequest_StockMoveOrderActionDto, "stock_move_order_action_dto")
	*/
	private $stockMoveOrderActionDto;

	/**
	* @JsonProperty(List<\Com\Pdd\Pop\Sdk\Api\Request\PddStockWareMoveRequest_StockMoveRecordActionDtoListItem>, "stock_move_record_action_dto_list")
	*/
	private $stockMoveRecordActionDtoList;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "stock_move_order_action_dto", $this->stockMoveOrderActionDto);
		$this->setUserParam($params, "stock_move_record_action_dto_list", $this->stockMoveRecordActionDtoList);

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
		return "pdd.stock.ware.move";
	}

	public function setStockMoveOrderActionDto($stockMoveOrderActionDto)
	{
		$this->stockMoveOrderActionDto = $stockMoveOrderActionDto;
	}

	public function setStockMoveRecordActionDtoList($stockMoveRecordActionDtoList)
	{
		$this->stockMoveRecordActionDtoList = $stockMoveRecordActionDtoList;
	}

}

class PddStockWareMoveRequest_StockMoveOrderActionDto extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(Integer, "move_direction")
	*/
	private $moveDirection;

	/**
	* @JsonProperty(String, "order_note")
	*/
	private $orderNote;

	/**
	* @JsonProperty(Integer, "business_type")
	*/
	private $businessType;

	/**
	* @JsonProperty(String, "warehouse_sn")
	*/
	private $warehouseSn;

	/**
	* @JsonProperty(Long, "move_time")
	*/
	private $moveTime;

	/**
	* @JsonProperty(String, "move_order_sn")
	*/
	private $moveOrderSn;

	public function setMoveDirection($moveDirection)
	{
		$this->moveDirection = $moveDirection;
	}

	public function setOrderNote($orderNote)
	{
		$this->orderNote = $orderNote;
	}

	public function setBusinessType($businessType)
	{
		$this->businessType = $businessType;
	}

	public function setWarehouseSn($warehouseSn)
	{
		$this->warehouseSn = $warehouseSn;
	}

	public function setMoveTime($moveTime)
	{
		$this->moveTime = $moveTime;
	}

	public function setMoveOrderSn($moveOrderSn)
	{
		$this->moveOrderSn = $moveOrderSn;
	}

}

class PddStockWareMoveRequest_StockMoveRecordActionDtoListItem extends PopBaseJsonEntity
{

	public function __construct()
	{

	}

	/**
	* @JsonProperty(String, "note")
	*/
	private $note;

	/**
	* @JsonProperty(Long, "move_num")
	*/
	private $moveNum;

	/**
	* @JsonProperty(String, "ware_sn")
	*/
	private $wareSn;

	public function setNote($note)
	{
		$this->note = $note;
	}

	public function setMoveNum($moveNum)
	{
		$this->moveNum = $moveNum;
	}

	public function setWareSn($wareSn)
	{
		$this->wareSn = $wareSn;
	}

}
