<?php
class Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_EntityID;
    protected $_AttributeID;
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
	
	public function getEntityID()
	{
		return $this->_EntityID;
	}
	
	public function setEntityID($value)
	{
		$this->_EntityID = $value;
		$this->set('EntityID' , $value);
	}
	
	
	public function getAttributeID()
	{
		return $this->_AttributeID;
	}
	
	public function setAttributeID($value)
	{
		$this->_AttributeID = $value;
		$this->set('AttributeID' , $value);
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
    	$model = Mage::getModel("webportal/Master_SubPage_EntityAttribute");
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