<?php
class Margshri_Common_VO_Customer_AddressVO extends Margshri_Common_VO_BaseVO{

	protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_CustomerID;
    protected $_TypeID;
    protected $_MobileNumber;
    protected $_StatusID;
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
	
	public function setID($value) 
	{
	  $this->_ID = $value;
	}
	
	
	public function getCustomerID()
	{
		return $this->_CustomerID;
	}
	
	public function setCustomerID($value)
	{
		$this->_CustomerID = $value;
		$this->set('CustomerID' , $value);
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
	
	
	public function getMobileNumber()
	{
		return $this->_MobileNumber;
	}
	
	public function setMobileNumber($value)
	{
		$this->_MobileNumber = $value;
		$this->set('MobileNumber' , $value);
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
    	$model = Mage::getModel("common/Customer_Address");
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