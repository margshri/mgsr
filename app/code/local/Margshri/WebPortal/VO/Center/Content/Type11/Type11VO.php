<?php
class Margshri_WebPortal_VO_Center_Content_Type11_Type11VO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_Value;
    protected $_WebsiteLink;
    protected $_StatusID;
    protected $_HelpLineNumber;
    protected $_Email;
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
	
	 
	public function getWebsiteLink()
	{
		return $this->_WebsiteLink;
	}
	
	public function setWebsiteLink($value)
	{
		$this->_WebsiteLink = $value;
		$this->set('WebsiteLink' , $value);
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
	
	
	
	    
	public function getHelpLineNumber() 
	{
	  return $this->_HelpLineNumber;
	}
	
	public function setHelpLineNumber($value) 
	{
	  $this->_HelpLineNumber = $value;
	  $this->set('HelpLineNumber' , $value);
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
	
	
    public function __construct($tableCode){
    	$model = Mage::helper('webportal/Data')->getType11Model($tableCode);
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