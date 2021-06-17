<?php
class  Margshri_WebPortal_VO_BaseVO extends Zend_Db_Table_Abstract{
	 
	private $_ErrorKey;
	private $_ErrorMessage = array();
	private $_SuccessMessage = array();
	private $_ResponseData = array();
	protected $_data = array();
	
	public function __construct()
	{
		$this->setBaseData('ErrorMessage' , null);
		$this->setBaseData('SuccessMessage' , null);
	}
	
	
	protected function setBaseData($name, $value)
	{
		$this->_baseData[$name]=$value;
	
	}
	public function getBaseDataArray(){
		return $this->_baseData;
	}
	
	
	public function setErrorKey($value)
	{
		$this->_ErrorKey = $value;
		$this->setBaseData('ErrorKey' , $value);
	}
	public function getErrorKey(){
		return $this->_ErrorKey;
	}
	
	
	public function setErrorMessage($errorMessageArray)
	{
		$this->_ErrorMessage = $errorMessageArray;
		$this->setBaseData('ErrorMessage' , $errorMessageArray);
	}
	public function getErrorMessage(){
		return $this->_ErrorMessage;
	}
 
	
	
	public function setSuccessMessage($successMessageArray)
	{
		$this->_SuccessMessage = $successMessageArray;
		$this->setBaseData('SuccessMessage' , $successMessageArray);
	}
	public function getSuccessMessage(){
		return $this->_SuccessMessage;
	}
	 
	
	public function setResponseData($value){
		$this->_ResponseData = $value;
		$this->setBaseData('ResponseData' , $value);
	}
	public function getResponseData(){
		return $this->_ResponseData;
	}
	
}