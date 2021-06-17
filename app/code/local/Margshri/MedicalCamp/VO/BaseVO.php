<?php
class  Margshri_MedicalCamp_VO_BaseVO extends Zend_Db_Table_Abstract{
	 
	private $_ErrorMessage=array();
	private $_SuccessMessage=array();
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
	 
	
	
	
}