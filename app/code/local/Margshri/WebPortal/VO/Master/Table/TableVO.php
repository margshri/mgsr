<?php
class Margshri_WebPortal_VO_Master_Table_TableVO extends Margshri_WebPortal_VO_BaseVO{

	public static $ACTIVE   = 1;
	public static $INACTIVE = 2;
	public static $ARCHIVE  = 3;
	
	protected $_db;
	protected $_name;
	protected $_primary = 'ID';
	
	protected $_ID;
	protected $_Value;
	protected $_Code;
	protected $_Discription;
	protected $_TableTypeID;
	protected $_FileName;
	protected $_IsFileName;
	protected $_UseInSearch;
	protected $_UseInCLP;
	protected $_MinCLPPoint;
	protected $_MaxCLPPoint;
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
	
	
	public function getTableTypeID() 
	{
	  return $this->_TableTypeID;
	}
	
	public function setTableTypeID($value) 
	{
	  $this->_TableTypeID = $value;
	  $this->set('TableTypeID' , $value);
	}
	
	
	public function getFileName() 
	{
	  return $this->_FileName;
	}
	
	public function setFileName($value) 
	{
	  $this->_FileName = $value;
	  $this->set('FileName' , $value);
	}
	
	
	public function getIsFileName() 
	{
	  return $this->_IsFileName;
	}
	
	public function setIsFileName($value) 
	{
	  $this->_IsFileName = $value;
	  $this->set('IsFileName' , $value);
	}
	
	public function getUseInSearch() 
	{
	  return $this->_UseInSearch;
	}
	
	public function setUseInSearch($value) 
	{
	  $this->_UseInSearch = $value;
	  $this->set('UseInSearch' , $value);
	}
	
	public function getUseInCLP()
	{
		return $this->_UseInCLP;
	}
	
	public function setUseInCLP($value)
	{
		$this->_UseInCLP = $value;
		$this->set('UseInCLP' , $value);
	}
	
	
	public function getMinCLPPoint()
	{
		return $this->_MinCLPPoint;
	}
	
	public function setMinCLPPoint($value)
	{
		$this->_MinCLPPoint = $value;
		$this->set('MinCLPPoint' , $value);
	}
	
	
	
	public function getMaxCLPPoint()
	{
		return $this->_MaxCLPPoint;
	}
	
	public function setMaxCLPPoint($value)
	{
		$this->_MaxCLPPoint = $value;
		$this->set('MaxCLPPoint' , $value);
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
		$model = Mage::getModel("webportal/Master_Table_Table");
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