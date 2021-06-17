<?php
class Margshri_WebPortal_VO_Master_Right_BidVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    
    protected $_BidName;
    protected $_BidCode;
    protected $_BiddingDate;
    protected $_BiddingTime;
    protected $_CounterTime;
    protected $_TypeID;
    protected $_WinnerID;
    protected $_ProductID;
    
    protected $_StatusID;
    protected $_CreatedAt;
    protected $_CreatedBy;
    protected $_UpdatedAt;
    protected $_UpdatedBy;
    
    protected $_CustomerCLPPoints;
    protected $_BidTypeName;
    protected $_BidProductVOs;
    
    
    
    
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
	 
	
	public function getBidName(){
		return $this->_BidName;
	}
	public function setBidName($value){
		$this->_BidName = $value;
		$this->set('BidName' , $value);
	}
	
	
	public function getBidCode(){
		return $this->_BidCode;
	}
	public function setBidCode($value){
		$this->_BidCode = $value;
		$this->set('BidCode' , $value);
	}
	
	
	public function getBiddingDate(){
		return $this->_BiddingDate;
	}
	public function setBiddingDate($value){
		$this->_BiddingDate = $value;
		$this->set('BiddingDate' , $value);
	}
	
	
	public function getBiddingTime(){
		return $this->_BiddingTime;
	}
	public function setBiddingTime($value){
		$this->_BiddingTime = $value;
		$this->set('BiddingTime' , $value);
	}
	
	
	public function getCounterTime(){
		return $this->_CounterTime;
	}
	public function setCounterTime($value){
		$this->_CounterTime = $value;
		$this->set('CounterTime' , $value);
	}
	
	
	public function getTypeID(){
		return $this->_TypeID;
	}
	public function setTypeID($value){
		$this->_TypeID = $value;
		$this->set('TypeID' , $value);
	}
	
	
	public function getWinnerID(){
		return $this->_WinnerID;
	}
	public function setWinnerID($value){
		$this->_WinnerID = $value;
		$this->set('WinnerID' , $value);
	}
	
	
	public function getProductID(){
		return $this->_ProductID;
	}
	public function setProductID($value){
		$this->_ProductID = $value;
		$this->set('ProductID' , $value);
	}
	
	
	 
	
	
	public function getStatusID(){
		return $this->_StatusID;
	}
	public function setStatusID($value){
		$this->_StatusID = $value;
		$this->set('StatusID' , $value);
	}
	
	
	public function getCreatedAt(){
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getCreatedBy(){
		return $this->_CreatedBy;
	}
	public function setCreatedBy($value){
		$this->_CreatedBy = $value;
		$this->set('CreatedBy' , $value);
	}
	
	
	public function getUpdatedAt(){
		return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value){
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	
	
	public function getUpdatedBy(){
		return $this->_UpdatedBy;
	}
	public function setUpdatedBy($value){
		$this->_UpdatedBy = $value;
		$this->set('UpdatedBy' , $value);
	}
	
	
	public function getBidTypeName(){
		return $this->_BidTypeName;
	}
	public function setBidTypeName($value){
		$this->_BidTypeName = $value;
	}
	
	
	public function getBidProductVOs(){
		return $this->_BidProductVOs;
	}
	public function setBidProductVOs($value){
		$this->_BidProductVOs = $value;
	}
	
	
	public function getCustomerCLPPoints(){
		return $this->_CustomerCLPPoints;
	}
	public function setCustomerCLPPoints($value){
		$this->_CustomerCLPPoints = $value;
	}
	
    public function __construct(){
    	$model = Mage::getModel("webportal/Master_Right_Bid");
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