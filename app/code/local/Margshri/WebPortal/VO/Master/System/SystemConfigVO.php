<?php
class Margshri_WebPortal_VO_Master_System_SystemConfigVO extends Margshri_WebPortal_VO_BaseVO{
	
    public static $MODELPATH = 'webportal/Master_System_SystemConfig';
    public static $TABLEALIAS = 'webportal/apctwebsystemconfig';
    public static $PRIMARYKEY = 'ID';
    
    
	public static $MAX_ADVERTISEMENT_ORDER = "MAX_ADVERTISEMENT_ORDER";
	public static $MAX_TOP_HEADER_ADVERTISEMENT = "MAX_TOP_HEADER_ADVERTISEMENT";
	public static $MAX_LEFT_SIDEBAR_ADVERTISEMENT = "MAX_LEFT_SIDEBAR_ADVERTISEMENT";
	public static $MAX_MIDDLE_HEADER_ADVERTISEMENT = "MAX_MIDDLE_HEADER_ADVERTISEMENT";
	public static $MAX_RIGHT_SIDEBAR_ADVERTISEMENT = "MAX_RIGHT_SIDEBAR_ADVERTISEMENT";
	public static $MAX_FOOTER_BAR_ADVERTISEMENT = "MAX_FOOTER_BAR_ADVERTISEMENT";
	
	public static $BID_NUMBER_OF_RECORD_SHOW = "BID_NUMBER_OF_RECORD_SHOW";	
	public static $BID_REFRESH_TIME_IN_SEC = "BID_REFRESH_TIME_IN_SEC";
	public static $BID_COMPLETE_TIME_IN_SEC = "BID_COMPLETE_TIME_IN_SEC";
	public static $BID_DAILY_TO_SPECIAL_CONVERT_POINT = "BID_DAILY_TO_SPECIAL_CONVERT_POINT";
	public static $BID_WEEKLY_TO_SPECIAL_CONVERT_POINT = "BID_WEEKLY_TO_SPECIAL_CONVERT_POINT";
	public static $BID_MONTHLY_TO_SPECIAL_CONVERT_POINT = "BID_MONTHLY_TO_SPECIAL_CONVERT_POINT";
	public static $BID_AUTO_FIRST_STARTING_MIN_POINT = "BID_AUTO_FIRST_STARTING_MIN_POINT";
	public static $BID_AUTO_FIRST_STARTING_MAX_POINT = "BID_AUTO_FIRST_STARTING_MAX_POINT"; 
	public static $BID_PLAY_WITH_MIN_POINT = "BID_PLAY_WITH_MIN_POINT";
	public static $BID_PLAY_WITH_MAX_POINT = "BID_PLAY_WITH_MAX_POINT";
	public static $BID_PRODUCT_CATAGORY_URL_KEY = "BID_PRODUCT_CATAGORY_URL_KEY";
	public static $BID_GRACE_PERIOD_TIME_IN_SEC = "BID_GRACE_PERIOD_TIME_IN_SEC";
	
	public static $CUSTOMER_REGISTRATION_OTP_EXPIRED_TIME_IN_SEC = "CUSTOMER_REGISTRATION_OTP_EXPIRED_TIME_IN_SEC";
	public static $BID_DEMO_ALLOWED_CUSTOMER_IDS = "BID_DEMO_ALLOWED_CUSTOMER_IDS";
	public static $BID_SHOW_TO_ALL = "BID_SHOW_TO_ALL";
	
	
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
		$model = Mage::getModel("webportal/Master_System_SystemConfig");
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
