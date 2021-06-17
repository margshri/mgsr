<?php
class Margshri_WebPortal_VO_Search_SearchVO extends Margshri_WebPortal_VO_BaseVO{
	
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
    protected $_CountryName;
    protected $_StateName;
    protected $_DistrictName;
    protected $_CityName;
    protected $_DistrictCode;
    protected $_CityCode;
    protected $_DynamicColumn1Name;
    protected $_DynamicColumn2Name;
    protected $_DynamicColumn3Name;
    protected $_DynamicColumn1Value;
    protected $_DynamicColumn2Value;
    protected $_DynamicColumn3Value;
    protected $_IFSCCode;
    protected $_MICRCode;
    protected $_TableCode;
    protected $_SubPageTableCode;
    protected $_TableTypeID;
    protected $_Branch;
    protected $_ATM;
    protected $_CustomerCareNumber;
    protected $_EmergencyNumber;
    protected $_TollFree;
    protected $_ContactPersonName;
    protected $_BusinessDay;
    protected $_BusinessHours;
    protected $_SortName;
    protected $_PaymentMethod;
    protected $_Area;

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
	
	public function getCountryName()
	{
		return $this->_CountryName;
	}
	
	public function setCountryName($value)
	{
		$this->_CountryName = $value;
		$this->set('CountryName' , $value);
	}

	
	public function getStateName()
	{
		return $this->_StateName;
	}
	
	public function setStateName($value)
	{
		$this->_StateName = $value;
		$this->set('StateName' , $value);
	}
	

	public function getDistrictName()
	{
		return $this->_DistrictName;
	}
	
	public function setDistrictName($value)
	{
		$this->_DistrictName = $value;
		$this->set('DistrictName' , $value);
	}
	
	
	public function getCityName()
	{
		return $this->_CityName;
	}
	
	public function setCityName($value)
	{
		$this->_CityName = $value;
		$this->set('CityName' , $value);
	}
	
	
	public function getDistrictCode()
	{
		return $this->_DistrictCode;
	}
	
	public function setDistrictCode($value)
	{
		$this->_DistrictCode = $value;
		$this->set('DistrictCode' , $value);
	}
	
	
	public function getCityCode()
	{
		return $this->_CityCode;
	}
	
	public function setCityCode($value)
	{
		$this->_CityCode = $value;
		$this->set('CityCode' , $value);
	}
	
	
	public function getDynamicColumn1Name()
	{
		return $this->_DynamicColumn1Name;
	}
	
	public function setDynamicColumn1Name($value)
	{
		$this->_DynamicColumn1Name = $value;
		$this->set('DynamicColumn1Name' , $value);
	}
	
	
	public function getDynamicColumn2Name()
	{
		return $this->_DynamicColumn2Name;
	}
	
	public function setDynamicColumn2Name($value)
	{
		$this->_DynamicColumn2Name = $value;
		$this->set('DynamicColumn2Name' , $value);
	}
	
	
	public function getDynamicColumn3Name()
	{
		return $this->_DynamicColumn3Name;
	}
	
	public function setDynamicColumn3Name($value)
	{
		$this->_DynamicColumn3Name = $value;
		$this->set('DynamicColumn3Name' , $value);
	}
	
	
	public function getDynamicColumn1Value()
	{
		return $this->_DynamicColumn1Value;
	}
	
	public function setDynamicColumn1Value($value)
	{
		$this->_DynamicColumn1Value = $value;
		$this->set('DynamicColumn1Value' , $value);
	}
	
	
	public function getDynamicColumn2Value()
	{
		return $this->_DynamicColumn2Value;
	}
	
	public function setDynamicColumn2Value($value)
	{
		$this->_DynamicColumn2Value = $value;
		$this->set('DynamicColumn2Value' , $value);
	}
	
	
	public function getDynamicColumn3Value()
	{
		return $this->_DynamicColumn3Value;
	}
	
	public function setDynamicColumn3Value($value)
	{
		$this->_DynamicColumn3Value = $value;
		$this->set('DynamicColumn3Value' , $value);
	}
	
	
	public function getIFSCCode()
	{
		return $this->_IFSCCode;
	}
	
	public function setIFSCCode($value)
	{
		$this->_IFSCCode = $value;
		$this->set('IFSCCode' , $value);
	}
	
	
	public function getMICRCode()
	{
		return $this->_MICRCode;
	}
	
	public function setMICRCode($value)
	{
		$this->_MICRCode = $value;
		$this->set('MICRCode' , $value);
	}
	
	
	
	public function getTableCode()
	{
		return $this->_TableCode;
	}
	
	public function setTableCode($value)
	{
		$this->_TableCode = $value;
		$this->set('TableCode' , $value);
	}
	
	
	public function getSubPageTableCode()
	{
		return $this->_SubPageTableCode;
	}
	
	public function setSubPageTableCode($value)
	{
		$this->_SubPageTableCode = $value;
		$this->set('SubPageTableCode' , $value);
	}


	public function getTableTypeID()
	{
		return $this->_TableTypeID;
	}
	
	public function setTableTypeID($value)
	{
		$this->_TableTypeID = $value;
		$this->set('TableTypeID' , $value);
	}
	
	public function getBranch()
	{
		return $this->_Branch;
	}
	
	public function setBranch($value)
	{
		$this->_Branch = $value;
		$this->set('Branch' , $value);
	}
	
	
	public function getATM()
	{
		return $this->_ATM;
	}
	
	public function setATM($value)
	{
		$this->_ATM = $value;
		$this->set('ATM' , $value);
	}
	

	public function getCustomerCareNumber()
	{
		return $this->_CustomerCareNumber;
	}
	
	public function setCustomerCareNumber($value)
	{
		$this->_CustomerCareNumber = $value;
		$this->set('CustomerCareNumber' , $value);
	}

	public function getEmergencyNumber()
	{
		return $this->_EmergencyNumber;
	}
	
	public function setEmergencyNumber($value)
	{
		$this->_EmergencyNumber = $value;
		$this->set('EmergencyNumber' , $value);
	}

	public function getTollFree()
	{
		return $this->_TollFree;
	}
	
	public function setTollFree($value)
	{
		$this->_TollFree = $value;
		$this->set('TollFree' , $value);
	}

	
	public function getContactPersonName(){
		return $this->_ContactPersonName;
	}
	public function setContactPersonName($value){
		$this->_ContactPersonName= $value;
		$this->set('ContactPersonName' , $value);
	}
	
	
	public function getBusinessDay(){
		return $this->_BusinessDay;
	}
	public function setBusinessDay($value){
		$this->_BusinessDay= $value;
		$this->set('BusinessDay' , $value);
	}
	
	
	public function getBusinessHours(){
		return $this->_BusinessHours;
	}
	public function setBusinessHours($value){
		$this->_BusinessHours= $value;
		$this->set('BusinessHours' , $value);
	}
	
	
	public function getSortName(){
		return $this->_SortName;
	}
	public function setSortName($value){
		$this->_SortName= $value;
		$this->set('SortName' , $value);
	}
	
	
	public function getPaymentMethod(){
		return $this->_PaymentMethod;
	}
	public function setPaymentMethod($value){
		$this->_PaymentMethod= $value;
		$this->set('PaymentMethod' , $value);
	}

	public function getArea(){
		return $this->_Area;
	}
	public function setArea($value){
		$this->_Area= $value;
		$this->set('Area' , $value);
	}
	
	
	
	
}
