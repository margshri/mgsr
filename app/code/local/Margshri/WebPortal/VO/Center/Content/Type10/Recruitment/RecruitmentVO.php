<?php
class Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_Value;
    protected $_Code;
    protected $_Department;
    protected $_PostName;
    protected $_NoOfPost;
    protected $_Qualification;
    protected $_OpeningDate;
    protected $_LastDate;
    protected $_ExamDate;
    protected $_ApplyOnlineLink;
    protected $_MoreDetailLink;
    protected $_RecruitmentTypeID;
    protected $_AgeLimit;
    protected $_Fees;
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
	
	
	
	    
	public function getDepartment() 
	{
	  return $this->_Department;
	}
	
	public function setDepartment($value) 
	{
	  $this->_Department = $value;
	  $this->set('Department' , $value);
	}
 
	
	
	public function getPostName() 
	{
	  return $this->_PostName;
	}
	
	public function setPostName($value) 
	{
	  $this->_PostName = $value;
	  $this->set('PostName' , $value);
	}
	
	
	    
	public function getNoOfPost() 
	{
	  return $this->_NoOfPost;
	}
	
	public function setNoOfPost($value) 
	{
	  $this->_NoOfPost = $value;
	  $this->set('NoOfPost' , $value);
	}
	
	
	
	
	    
	public function getQualification() 
	{
	  return $this->_Qualification;
	}
	
	public function setQualification($value) 
	{
	  $this->_Qualification = $value;
	  $this->set('Qualification' , $value);
	}
	
	
	
	    
	public function getOpeningDate() 
	{
	  return $this->_OpeningDate;
	}
	
	public function setOpeningDate($value) 
	{
	  $this->_OpeningDate = $value;
	  $this->set('OpeningDate' , $value);
	}
	

	
	    
	public function getLastDate() 
	{
	  return $this->_LastDate;
	}
	
	public function setLastDate($value) 
	{
	  $this->_LastDate = $value;
	  $this->set('LastDate' , $value);
	}
	
	
	
	    
	public function getExamDate() 
	{
	  return $this->_ExamDate;
	}
	
	public function setExamDate($value) 
	{
	  $this->_ExamDate = $value;
	  $this->set('ExamDate' , $value);
	}
	
	
	
	
	    
	public function getApplyOnlineLink() 
	{
	  return $this->_ApplyOnlineLink;
	}
	
	public function setApplyOnlineLink($value) 
	{
	  $this->_ApplyOnlineLink = $value;
	  $this->set('ApplyOnlineLink' , $value);
	}
	
	
	
	    
	public function getMoreDetailLink() 
	{
	  return $this->_MoreDetailLink;
	}
	
	public function setMoreDetailLink($value) 
	{
	  $this->_MoreDetailLink = $value;
	  $this->set('MoreDetailLink' , $value);
	}
		
	
	
	
	
	
	public function getRecruitmentTypeID() 
	{
	  return $this->_RecruitmentTypeID;
	}
	
	public function setRecruitmentTypeID($value) 
	{
	  $this->_RecruitmentTypeID = $value;
	  $this->set('RecruitmentTypeID' , $value);
	}
	
	
	public function getAgeLimit()
	{
		return $this->_AgeLimit;
	}
	
	public function setAgeLimit($value)
	{
		$this->_AgeLimit = $value;
		$this->set('AgeLimit' , $value);
	}
	
	
	public function getFees()
	{
		return $this->_Fees;
	}
	
	public function setFees($value)
	{
		$this->_Fees = $value;
		$this->set('Fees' , $value);
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
    	$model = Mage::getModel("webportal/Center_Content_Type10_Recruitment_Recruitment");
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