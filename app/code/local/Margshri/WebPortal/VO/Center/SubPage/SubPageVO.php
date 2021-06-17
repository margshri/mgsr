<?php
class Margshri_WebPortal_VO_Center_SubPage_SubPageVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_RecordID;
    protected $_EntityAttributeID;
    
    protected $_PersonName;
    protected $_Post1ID;
    protected $_Post2ID;
    
    
    protected $_Value;
    protected $_StatusID;
    protected $_CreatedAt;
    protected $_CreatedBy;
    protected $_UpdatedAt;
    protected $_UpdatedBy;
    
    protected $_AttributeCode;
    protected $_AttributeName;
    protected $_AttributeTypeID;
    protected $_AttributeDataTypeID;
    
    protected $_MobileNumber;
    protected $_CustomerName;
    protected $_Post1Name;
    protected $_Post2Name;
    
    

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
	
	
	public function getRecordID()
	{
		return $this->_RecordID;
	}
	
	public function setRecordID($value)
	{
		$this->_RecordID = $value;
		$this->set('RecordID' , $value);
	}
	
	
	public function getEntityAttributeID()
	{
		return $this->_EntityAttributeID;
	}
	
	public function setEntityAttributeID($value)
	{
		$this->_EntityAttributeID = $value;
		$this->set('EntityAttributeID' , $value);
	}
	
	
	public function getPersonName()
	{
		return $this->_PersonName;
	}
	
	public function setPersonName($value)
	{
		$this->_PersonName = $value;
		$this->set('PersonName' , $value);
	}
	
	
	public function getPost1ID()
	{
		return $this->_Post1ID;
	}
	
	public function setPost1ID($value)
	{
		$this->_Post1ID = $value;
		$this->set('Post1ID' , $value);
	}
	
	public function getPost2ID()
	{
		return $this->_Post2ID;
	}
	
	public function setPost2ID($value)
	{
		$this->_Post2ID = $value;
		$this->set('Post2ID' , $value);
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
	
	public function getAttributeCode()
	{
		return $this->_AttributeCode;
	}
	
	public function setAttributeCode($value)
	{
		$this->_AttributeCode = $value;
	}
	
	public function getAttributeName()
	{
		return $this->_AttributeName;
	}
	
	public function setAttributeName($value)
	{
		$this->_AttributeName = $value;
	}
	
	public function getAttributeTypeID()
	{
		return $this->_AttributeTypeID;
	}
	
	public function setAttributeTypeID($value)
	{
		$this->_AttributeTypeID = $value;
	}

	public function getAttributeDataTypeID()
	{
		return $this->_AttributeDataTypeID;
	}
	
	public function setAttributeDataTypeID($value)
	{
		$this->_AttributeDataTypeID = $value;
	}
	
	public function getMobileNumber()
	{
		return $this->_MobileNumber;
	}
	
	public function setMobileNumber($value)
	{
		$this->_MobileNumber = $value;
	}
	
	public function getCustomerName()
	{
		return $this->_CustomerName;
	}
	
	public function setCustomerName($value)
	{
		$this->_CustomerName = $value;
	}
	
	
	public function getPost1Name()
	{
		return $this->_Post1Name;
	}
	
	public function setPost1Name($value)
	{
		$this->_Post1Name = $value;
	}
	
	
	public function getPost2Name()
	{
		return $this->_Post2Name;
	}
	
	public function setPost2Name($value)
	{
		$this->_Post2Name = $value;
	}
	
	
    public function __construct(){
    	$model = Mage::getModel("webportal/Center_SubPage_SubPage");
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