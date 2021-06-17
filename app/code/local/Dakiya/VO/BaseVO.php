<?php
class  Dakiya_VO_BaseVO extends Zend_Db_Table_Abstract{
	 
    private $_ErrorKey = null;
    private $_ErrorMessage = null;
	private $_SuccessMessage = null;
	private $_ResponseData = null;
	private $_BaseData = null;
	protected $_data = array();
	
	public function __construct(){
	    $this->setBaseData('ErrorKey' , null);
	    $this->setBaseData('ErrorMessage' , null);
		$this->setBaseData('SuccessMessage' , null);
		$this->setBaseData('ResponseData' , null);
		$this->setBaseData('BaseData' , null);
	}
	
	
	protected function setBaseData($name, $value){
	    $this->_BaseData[$name]=$value;
	
	}
	public function getBaseDataArray(){
	    return $this->_BaseData;
	}
	
	
	public function setErrorKey($value){
	    $this->_ErrorKey = $value;
	    $this->setBaseData('ErrorKey', $value);
	}
	public function getErrorKey(){
	    return $this->_ErrorKey;
	}
	
	
	public function setErrorMessage($value){
	    $this->_ErrorMessage = $value;
	    $this->setBaseData('ErrorMessage', $value);
	}
	public function getErrorMessage(){
		return $this->_ErrorMessage;
	}
 
		
	public function setSuccessMessage($value){
	    $this->_SuccessMessage = $value;
	    $this->setBaseData('SuccessMessage', $value);
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