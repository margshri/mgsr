<?php
class Margshri_WebPortal_VO_SystemConfigVO extends Margshri_WebPortal_VO_BaseVO{

	public static $MAX_ADVERTISEMENT_ORDER = 5;
	public static $MAX_TOP_HEADER_ADVERTISEMENT = 5;
	public static $MAX_LEFT_SIDEBAR_ADVERTISEMENT = 5;
	public static $MAX_MIDDLE_HEADER_ADVERTISEMENT = 5;
	public static $MAX_RIGHT_SIDEBAR_ADVERTISEMENT = 5;
	public static $MAX_FOOTER_BAR_ADVERTISEMENT = 5;

	protected $_db;
	protected $_name;
	protected $_primary = 'ID';
	
	protected $_ID;
	protected $_ConfigName;
	protected $_ConfigCode;
	protected $_ConfigValue;
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
	
	public function getStatusID()
	{
		return $this->_StatusID;
	}
	
	
	 
	public function getID()
	{
		return $this->_ID;
	}
	
	public function setID($value)
	{
		$this->_ID = $value;
	}
	
	
	public function getConfigName()
	{
		return $this->_ConfigName;
	}
	
	public function setConfigName($value)
	{
		$this->_ConfigName = $value;
		$this->set('ConfigName' , $value);
	}
	
	
	public function getConfigCode()
	{
		return $this->_ConfigCode;
	}
	
	public function setConfigCode($value)
	{
		$this->_ConfigCode = $value;
		$this->set('ConfigCode' , $value);
	}
	
	
	
	public function getConfigValue()
	{
		return $this->_ConfigValue;
	}
	
	public function setConfigValue($value)
	{
		$this->_ConfigValue = $value;
		$this->set('ConfigValue' , $value);
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
		$model = Mage::getModel("webportal/Status_Status");
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
