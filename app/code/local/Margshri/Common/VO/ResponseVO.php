<?php
class  Margshri_Common_VO_ResponseVO extends Zend_Db_Table_Abstract{
	 
    private $_ErrorKey = null;
    private $_ErrorMessage = null;
    private $_SuccessKey = null;
    private $_SuccessMessage = null;
	private $_ResponseData = array();
	
	public function __construct(){
	    $this->setResponseData('ErrorKey' , null);
	    $this->setResponseData('ErrorMessage' , null);
	    $this->setResponseData('SuccessKey' , null);
	    $this->setResponseData('SuccessMessage' , null);
	}
	
	
	public function setResponseData($name, $value){
	    $this->_ResponseData[$name]=$value;
	
	}
	public function getResponseData(){
	    return $this->_ResponseData;
	}
	
	
	public function setErrorKey($value){
	    $this->_ErrorKey = $value;
	    $this->setResponseData('ErrorKey', $value);
	}
	public function getErrorKey(){
	    return $this->_ErrorKey;
	}
	
	
	public function setErrorMessage($value){
	    $this->_ErrorMessage = $value;
	    $this->setResponseData('ErrorMessage', $value);
	}
	public function getErrorMessage(){
		return $this->_ErrorMessage;
	}

	
	public function setSuccessKey($value){
	    $this->_SuccessKey = $value;
	    $this->setResponseData('SuccessKey', $value);
	}
	public function getSuccessKey(){
	    return $this->_SuccessKey;
	}
	
	
	public function setSuccessMessage($value){
	    $this->_SuccessMessage = $value;
	    $this->setResponseData('SuccessMessage', $value);
	}
	public function getSuccessMessage(){
		return $this->_SuccessMessage;
	}
	
}