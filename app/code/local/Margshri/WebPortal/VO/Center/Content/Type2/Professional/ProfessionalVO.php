<?php
class Margshri_WebPortal_VO_Center_Content_Type2_Professional_ProfessionalVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_CustomerID;
    protected $_ProfessionID;
    protected $_IsPaid;
    protected $_StatusID;
    protected $_CreatedAt;
    protected $_CreatedBy;
    protected $_UpdatedAt;
    protected $_UpdatedBy;
    
    
    protected $_FirstName;
    protected $_LastName;
        
    
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
	
		    
	public function getProfessionID() 
	{
	  return $this->_ProfessionID;
	}
	
	public function setProfessionID($value) 
	{
	  $this->_ProfessionID = $value;
	  $this->set('ProfessionID' , $value);
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
	
	
	    
	public function getFirstName() 
	{
	  return $this->_FirstName;
	}
	
	public function setFirstName($value) 
	{
	  $this->_FirstName = $value;
	}
	
	
	
	    
	public function getLastName() 
	{
	  return $this->_LastName;
	}
	
	public function setLastName($value) 
	{
	  $this->_LastName = $value;
	}
	
	public function __construct(){
		$model = Mage::getModel("webportal/Center_Content_Type2_Professional_Professional");
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