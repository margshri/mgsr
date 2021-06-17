<?php
class Margshri_WebPortal_VO_Right_BidTranVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_CustomerID;
    protected $_BidID;
    protected $_BidValue;
    protected $_IsWin;
    protected $_CreatedAt;
    
    
	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}

	public function getDataArray(){
		return $this->_data;
	}

	    
	public function getID(){
	  return $this->_ID;
	}
	public function setID($value){
	  $this->_ID = $value;
	}
	
	
	public function getCustomerID(){
		return $this->_CustomerID;
	}
	public function setCustomerID($value){
		$this->_CustomerID = $value;
		$this->set('CustomerID' , $value);
	}


	public function getBidID(){
		return $this->_BidID;
	}
	public function setBidID($value){
		$this->_BidID = $value;
		$this->set('BidID' , $value);
	}
	
	
	public function getBidValue(){
		return $this->_BidValue;
	}
	public function setBidValue($value){
		$this->_BidValue = $value;
		$this->set('BidValue' , $value);
	}
	
	
	public function getIsWin(){
		return $this->_IsWin;
	}
	public function setIsWin($value){
		$this->_IsWin = $value;
		$this->set('IsWin' , $value);
	}
	
		
	public function getCreatedAt(){
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	 
	
    public function __construct(){
    	$model = Mage::getModel("webportal/Right_BidTran");
    	$tableName = $model->getResource()->getMainTable();

    	$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
    	$this->setDefaultAdapter($con);
    	$this->_db = $con;
    	$this->setTableName($tableName);
    }
    

    public function setTableName($tableName)
    {
    	$this->_name =$tableName;
    	parent::_setupTableName();
    }

    public function getTableName(){
    	return $this->_name;
    }

}