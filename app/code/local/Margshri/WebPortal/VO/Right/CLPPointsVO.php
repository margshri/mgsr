<?php
class Margshri_WebPortal_VO_Right_CLPPointsVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_CustomerID;
    protected $_DailyPoints;
    protected $_WeeklyPoints;
    protected $_MonthlyPoints;
    protected $_SpecialPoints;
    protected $_EarnedPoints;
    protected $_RedeemedPoints;
    protected $_CreatedAt;
    protected $_UpdatedAt;
    
    
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

	public function getDailyPoints(){
		return $this->_DailyPoints;
	}
	public function setDailyPoints($value){
		$this->_DailyPoints = $value;
		$this->set('DailyPoints' , $value);
	}
	
	
	public function getWeeklyPoints(){
		return $this->_WeeklyPoints;
	}
	public function setWeeklyPoints($value){
		$this->_WeeklyPoints = $value;
		$this->set('WeeklyPoints' , $value);
	}
	
	
	public function getMonthlyPoints(){
		return $this->_MonthlyPoints;
	}
	public function setMonthlyPoints($value){
		$this->_MonthlyPoints = $value;
		$this->set('MonthlyPoints' , $value);
	}
	
	
	
	public function getSpecialPoints(){
		return $this->_SpecialPoints;
	}
	public function setSpecialPoints($value){
		$this->_SpecialPoints = $value;
		$this->set('SpecialPoints' , $value);
	}
	
	
	public function getEarnedPoints(){
		return $this->_EarnedPoints;
	}
	public function setEarnedPoints($value){
		$this->_EarnedPoints = $value;
		$this->set('EarnedPoints' , $value);
	}
	
	
	public function getRedeemedPoints(){
		return $this->_RedeemedPoints;
	}
	public function setRedeemedPoints($value){
		$this->_RedeemedPoints = $value;
		$this->set('RedeemedPoints' , $value);
	}
	
	
	public function getCreatedAt(){
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getUpdatedAt(){
		return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value){
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	 
	
    public function __construct(){
    	$model = Mage::getModel("webportal/Right_CLPPoints");
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