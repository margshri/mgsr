<?php
class Margshri_WebPortal_VO_Master_Office_OfficeVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_Value;
    protected $_Code;    
    protected $_UserID;
    protected $_Order;
    protected $_WebsiteLink;
    protected $_IsPaid;
    protected $_TinNumber;
    protected $_PANNumber;
    protected $_Category1ID;
    protected $_Category1Value;
    protected $_Category2ID;
    protected $_Category2Value;
    protected $_Category3ID;
    protected $_Category3Value;
    protected $_TypeID;
    protected $_StoreID;
    protected $_StatusID;
    protected $_LandLineNumber;
    protected $_MobileNumber1;
    protected $_MobileNumber2;
    protected $_Email;
    protected $_PinCode;
    protected $_Address;    
    protected $_CountryID;
    protected $_StateID;
    protected $_DistrictID;
    protected $_CityID;
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
	
	public function setId($value) 
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
	
	
	
	    
	public function getUserID() 
	{
	  return $this->_UserID;
	}
	
	public function setUserID($value) 
	{
	  $this->_UserID = $value;
	  $this->set('UserID' , $value);
	}
	
	
	public function getOrder()
	{
		return $this->_Order;
	}
	
	public function setOrder($value)
	{
		$this->_Order = $value;
		$this->set('Order' , $value);
	}
	
	
	
	 
	public function getWebsiteLink()
	{
		return $this->_WebsiteLink;
	}
	
	public function setWebsiteLink($value)
	{
		$this->_WebsiteLink = $value;
		$this->set('WebsiteLink' , $value);
	}
	
	
	
	 
	public function getIsPaid()
	{
		return $this->_IsPaid;
	}
	
	public function setIsPaid($value)
	{
		$this->_IsPaid = $value;
		$this->set('IsPaid' , $value);
	}
	
	
	
	
	    
	public function getTinNumber() 
	{
	  return $this->_TinNumber;
	}
	
	public function setTinNumber($value) 
	{
	  $this->_TinNumber = $value;
	  $this->set('TinNumber' , $value);
	}
	
	
	    
	public function getPANNumber() 
	{
	  return $this->_PANNumber;
	}
	
	public function setPANNumber($value) 
	{
	  $this->_PANNumber = $value;
	  $this->set('PANNumber' , $value);
	}
	
	
	
	
	    
	public function getCategory1ID() 
	{
	  return $this->_Category1ID;
	}
	
	public function setCategory1ID($value) 
	{
	  $this->_Category1ID = $value;
	  $this->set('Category1ID' , $value);
	}
	
	
	
	
	    
	public function getCategory1Value() 
	{
	  return $this->_Category1Value;
	}
	
	public function setCategory1Value($value) 
	{
	  $this->_Category1Value = $value;
	  $this->set('Category1Value' , $value);
	}
	
	
	
	
	    
	public function getCategory2ID() 
	{
	  return $this->_Category2ID;
	}
	
	public function setCategory2ID($value) 
	{
	  $this->_Category2ID = $value;
	  $this->set('Category2ID' , $value);
	}
	
	
	
	
	    
	public function getCategory2Value() 
	{
	  return $this->_Category2Value;
	}
	
	public function setCategory2Value($value) 
	{
	  $this->_Category2Value = $value;
	  $this->set('Category2Value' , $value);
	}
	
	
	
	
	    
	public function getCategory3ID() 
	{
	  return $this->_Category3ID;
	}
	
	public function setCategory3ID($value) 
	{
	  $this->_Category3ID = $value;
	  $this->set('Category3ID' , $value);
	}
	
	
	
	
	    
	public function getCategory3Value() 
	{
	  return $this->_Category3Value;
	}
	
	public function setCategory3Value($value) 
	{
	  $this->_Category3Value = $value;
	  $this->set('Category3Value' , $value);
	}
	
	
	
	
	    
	public function getTypeID() 
	{
	  return $this->_TypeID;
	}
	
	public function setTypeID($value) 
	{
	  $this->_TypeID = $value;
	  $this->set('TypeID' , $value);
	}
	
	
	
	public function getStoreID() 
	{
	  return $this->_StoreID;
	}
	
	public function setStoreID($value) 
	{
	  $this->_StoreID = $value;
	  $this->set('StoreID' , $value);
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
	
	
	
	    
	public function getLandLineNumber() 
	{
	  return $this->_LandLineNumber;
	}
	
	public function setLandLineNumber($value) 
	{
	  $this->_LandLineNumber = $value;
	  $this->set('LandLineNumber' , $value);
	}
	
	
	
	    
	public function getMobileNumber1() 
	{
	  return $this->_MobileNumber1;
	}
	
	public function setMobileNumber1($value) 
	{
	  $this->_MobileNumber1 = $value;
	  $this->set('MobileNumber1' , $value);
	}
	
	
	
	    
	public function getMobileNumber2() 
	{
	  return $this->_MobileNumber2;
	}
	
	public function setMobileNumber2($value) 
	{
	  $this->_MobileNumber2 = $value;
	  $this->set('MobileNumber2' , $value);
	}
	
	
	
	    
	public function getEmail() 
	{
	  return $this->_Email;
	}
	
	public function setEmail($value) 
	{
	  $this->_Email = $value;
	  $this->set('Email' , $value);
	}
	
	
	
	    
	public function getPinCode() 
	{
	  return $this->_PinCode;
	}
	
	public function setPinCode($value) 
	{
	  $this->_PinCode = $value;
	  $this->set('PinCode' , $value);
	}
	
	
	public function getAddress()
	{
		return $this->_Address;
	}
	
	public function setAddress($value)
	{
		$this->_Address = $value;
		$this->set('Address' , $value);
	}
	
	
	
	
	public function getCountryID() 
	{
	  return $this->_CountryID;
	}
	
	public function setCountryID($value) 
	{
	  $this->_CountryID = $value;
	  $this->set('CountryID' , $value);
	}
	
	
	public function getStateID() 
	{
	  return $this->_StateID;
	}
	
	public function setStateID($value) 
	{
	  $this->_StateID = $value;
	  $this->set('StateID' , $value);
	}
	
	    
	public function getDistrictID() 
	{
	  return $this->_DistrictID;
	}
	
	public function setDistrictID($value) 
	{
	  $this->_DistrictID = $value;
	  $this->set('DistrictID' , $value);
	}

	
	public function getCityID() 
	{
	  return $this->_CityID;
	}
	
	public function setCityID($value) 
	{
	  $this->_CityID = $value;
	  $this->set('CityID' , $value);
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
    	$model = Mage::getModel("webportal/Master_Office_Office_Office");
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