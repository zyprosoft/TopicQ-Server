<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddTicketSkuRuleGetRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "out_rule_id")
	*/
	private $outRuleId;

	/**
	* @JsonProperty(String, "rule_id")
	*/
	private $ruleId;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "out_rule_id", $this->outRuleId);
		$this->setUserParam($params, "rule_id", $this->ruleId);

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
		return "pdd.ticket.sku.rule.get";
	}

	public function setOutRuleId($outRuleId)
	{
		$this->outRuleId = $outRuleId;
	}

	public function setRuleId($ruleId)
	{
		$this->ruleId = $ruleId;
	}

}
