<?php
class Margshri_WebPortal_VO_Master_SubPage_AttributeVO extends Margshri_WebPortal_VO_BaseVO{
	
	public static $HEADER_IMAGE = "header_image";
	public static $BUILDING_IMAGE = "building_image";
	public static $PERSON1_IMAGE = "person1_image";
	public static $PERSON2_IMAGE = "person2_image";
	public static $PERSON3_IMAGE = "person3_image";
	public static $PERSON4_IMAGE = "person4_image";
	public static $PERSON5_IMAGE = "person5_image";
	public static $PERSON6_IMAGE = "person6_image";
	public static $PERSON7_IMAGE = "person7_image";
	
	public static $SERVICE1_IMAGE = "service1_image";
	public static $SERVICE2_IMAGE = "service2_image";
	public static $SERVICE3_IMAGE = "service3_image";
	public static $SERVICE4_IMAGE = "service4_image";
	public static $SERVICE5_IMAGE = "service5_image";
	public static $SERVICE6_IMAGE = "service6_image";
	public static $SERVICE7_IMAGE = "service7_image";
	public static $SERVICE8_IMAGE = "service8_image";
	public static $SERVICE9_IMAGE = "service9_image";
	
	
	
	public static $FACILITIES = "facilities";
	
	
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_Value;
    protected $_Code;
    protected $_TypeID;
    protected $_DataTypeID;
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
	
	
	public function getDataTypeID()
	{
		return $this->_DataTypeID;
	}
	
	public function setDataTypeID($value)
	{
		$this->_DataTypeID = $value;
		$this->set('DataTypeID' , $value);
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
    	$model = Mage::getModel("webportal/Master_SubPage_Attribute");
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