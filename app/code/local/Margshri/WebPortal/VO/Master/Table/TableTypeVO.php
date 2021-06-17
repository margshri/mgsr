<?php
class Margshri_WebPortal_VO_Master_Table_TableTypeVO extends Margshri_WebPortal_VO_BaseVO{

	public static $TYPE1 = 1;
	public static $TYPE2 = 2;
	public static $TYPE3 = 3;
	public static $TYPE4 = 4;
	public static $TYPE5 = 5;
	public static $TYPE6 = 6;
	public static $TYPE7 = 7;
	public static $TYPE8 = 8;
	public static $TYPE9 = 9;
	public static $TYPE10 = 10;
	public static $TYPE11 = 11;
	public static $TYPE12 = 12;
	public static $TYPE13 = 13;
	
	public static $TYPE7_EVENT  = "apct_web_event";
	public static $TYPE7_ACHIVEMENT  = "apct_web_achivement";
	public static $TYPE7_NEWS  = "apct_web_news";
	
	public static $TYPE2_CITY_DIAMONDS = "apct_web_city_diamonds";
	public static $TYPE2_BLOOD_DONOR = "apct_web_blood_donor";
	
	public static $TYPE3_PERSONAL_PHONEBOOK  = "apct_web_personal_phone_book";  
	public static $TYPE3_GENERAL_PHONEBOOK  = "apct_web_general_phone_book";
	
	
	
	public static $TYPE10_HOSPITAL  = "apct_web_hospital";
	public static $TYPE10_RECRUITMENT  = "apct_web_recruitment";
	
	public static $TYPE10_UNIVERSITY  = "apct_web_university";
	public static $TYPE10_SCHOOL  = "apct_web_school";
	public static $TYPE10_ACADEMY_INSTITUTE  = "apct_web_academy_institute";
	public static $TYPE10_VEHICALS  = "apct_web_vehicals";
	public static $TYPE10_FINANCE  = "apct_web_finance";
	public static $TYPE10_LOAN  = "apct_web_loan";
	public static $TYPE10_GODPLACE  = "apct_web_god_place";
	public static $TYPE10_NEWSPAPER = "apct_web_newspaper";
	public static $TYPE10_MOBILE_SERVICE = "apct_web_mobileservice";
	public static $TYPE10_GOVT_DEPARTMENT = "apct_web_govt_department";
	public static $TYPE10_SURGICAL = "apct_web_surgical";
	public static $TYPE10_SCIENTIFIC= "apct_web_scientific";
	public static $TYPE10_LABORATORY = "apct_web_laboratory";
	
	
	
	
	
	protected $_db;
	protected $_name;
	protected $_primary = 'ID';
	
	protected $_ID;
	protected $_Value;
	protected $_Code;
	protected $_Discription;
	protected $_StatusID;
	protected $_CreatedAt;
	protected $_CreatedBy;
	protected $_UpdatedAt;
	protected $_UpdatedBy;
	

	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}
	
	public function getDataArray(){
		return $this->_data;
	}
	
	    
	public function getID() 
	{
	  return $this->_ID;
	}
	
	public function setID($value) 
	{
	  $this->_ID = $value;
	}
	

	public function getValue()
	{
		return $this->_Value;
	}
	
	public function setValue($value)
	{
		$this->_Value = $value;
		$this->set('Value' , $value);
	}
	
	
	public function getCode() 
	{
	  return $this->_Code;
	}
	
	public function setCode($value) 
	{
	  $this->_Code = $value;
	  $this->set('Code' , $value);
	}
	
	
	public function getDiscription() 
	{
	  return $this->_Discription;
	}
	
	public function setDiscription($value) 
	{
	  $this->_Discription = $value;
	  $this->set('Discription' , $value);
	}
	
	
	public function getStatusID() 
	{
	  return $this->_StatusID;
	}
	
	public function setStatusID($value) 
	{
	  $this->_StatusID = $value;
	  $this->set('StatusID' , $value);
	}
	
	 
	public function getCreatedAt()
	{
		return $this->_CreatedAt;
	}
	
	public function setCreatedAt($value)
	{
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	

	public function getCreatedBy() 
	{
	  return $this->_CreatedBy;
	}
	
	public function setCreatedBy($value) 
	{
	  $this->_CreatedBy = $value;
	  $this->set('CreatedBy' , $value);
	}
	 
	
	public function getUpdatedAt()
	{
		return $this->_UpdatedAt;
	}
	
	public function setUpdatedAt($value)
	{
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	
	 
	public function getUpdatedBy() 
	{
	  return $this->_UpdatedBy;
	}
	
	public function setUpdatedBy($value) 
	{
	  $this->_UpdatedBy = $value;
	  $this->set('UpdatedBy' , $value);
	}
	
	public function __construct(){
		$model = Mage::getModel("webportal/Master_Table_TableType");
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
