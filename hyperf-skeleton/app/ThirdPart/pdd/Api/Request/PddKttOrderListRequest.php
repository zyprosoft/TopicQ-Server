<?php
namespace Com\Pdd\Pop\Sdk\Api\Request;

use Com\Pdd\Pop\Sdk\PopBaseHttpRequest;
use Com\Pdd\Pop\Sdk\PopBaseJsonEntity;

class PddKttOrderListRequest extends PopBaseHttpRequest
{
    public function __construct()
	{

	}
	/**
	* @JsonProperty(String, "activity_no")
	*/
	private $activityNo;

	/**
	* @JsonProperty(Integer, "after_sales_status")
	*/
	private $afterSalesStatus;

	/**
	* @JsonProperty(Integer, "cancel_status")
	*/
	private $cancelStatus;

	/**
	* @JsonProperty(Long, "confirm_at_begin")
	*/
	private $confirmAtBegin;

	/**
	* @JsonProperty(Long, "confirm_at_end")
	*/
	private $confirmAtEnd;

	/**
	* @JsonProperty(Integer, "page_number")
	*/
	private $pageNumber;

	/**
	* @JsonProperty(Integer, "page_size")
	*/
	private $pageSize;

	/**
	* @JsonProperty(Integer, "shipping_status")
	*/
	private $shippingStatus;

	/**
	* @JsonProperty(Integer, "verification_status")
	*/
	private $verificationStatus;

	protected function setUserParams(&$params)
	{
		$this->setUserParam($params, "activity_no", $this->activityNo);
		$this->setUserParam($params, "after_sales_status", $this->afterSalesStatus);
		$this->setUserParam($params, "cancel_status", $this->cancelStatus);
		$this->setUserParam($params, "confirm_at_begin", $this->confirmAtBegin);
		$this->setUserParam($params, "confirm_at_end", $this->confirmAtEnd);
		$this->setUserParam($params, "page_number", $this->pageNumber);
		$this->setUserParam($params, "page_size", $this->pageSize);
		$this->setUserParam($params, "shipping_status", $this->shippingStatus);
		$this->setUserParam($params, "verification_status", $this->verificationStatus);

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
		return "pdd.ktt.order.list";
	}

	public function setActivityNo($activityNo)
	{
		$this->activityNo = $activityNo;
	}

	public function setAfterSalesStatus($afterSalesStatus)
	{
		$this->afterSalesStatus = $afterSalesStatus;
	}

	public function setCancelStatus($cancelStatus)
	{
		$this->cancelStatus = $cancelStatus;
	}

	public function setConfirmAtBegin($confirmAtBegin)
	{
		$this->confirmAtBegin = $confirmAtBegin;
	}

	public function setConfirmAtEnd($confirmAtEnd)
	{
		$this->confirmAtEnd = $confirmAtEnd;
	}

	public function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}

	public function setPageSize($pageSize)
	{
		$this->pageSize = $pageSize;
	}

	public function setShippingStatus($shippingStatus)
	{
		$this->shippingStatus = $shippingStatus;
	}

	public function setVerificationStatus($verificationStatus)
	{
		$this->verificationStatus = $verificationStatus;
	}

}
