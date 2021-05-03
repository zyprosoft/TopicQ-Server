<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddPopAuthTokenCreateRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "code")
	*/
	private $code;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "code", $this->code);

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
		return "pdd.pop.auth.token.create";
	}

	public function setCode($code)
	{
		$this->code = $code;
	}

}
