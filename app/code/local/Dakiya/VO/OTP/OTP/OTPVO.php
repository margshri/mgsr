<?php
class Dakiya_VO_OTP_OTP_OTPVO extends Dakiya_VO_BaseVO{
	
    
    public static $MODELPATH = 'dakiya/OTP_OTP_OTP';
    public static $TABLEALIAS = 'dakiya/dakiyaotp';
    public static $PRIMARYKEY = 'ID';
    
	protected $_db;
	protected $_name;
	protected $_primary = 'ID';
	
	private $_ID;
	private $_OTP;
	private $_MobileNumber;
	private $_EmailID;
	private $_CreatedAt;
	private $_ExpiredAt;
	private $_FirstName;
	private $_LastName;
	
	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function getID() {
		return $this->_ID;
	}
	public function setID($value) {
		$this->_ID = $value;
	}
	
	
	public function getOTP() {
		return $this->_OTP;
	}
	public function setOTP($value) {
		$this->_OTP = $value;
		$this->set('OTP' , $value);
	}
	
	
	public function getMobileNumber() {
		return $this->_MobileNumber;
	}
	public function setMobileNumber($value) {
		$this->_MobileNumber = $value;
		$this->set('MobileNumber' , $value);
	}
	
	
	public function getEmailID() {
		return $this->_EmailID;
	}
	public function setEmailID($value) {
		$this->_EmailID = $value;
		$this->set('EmailID' , $value);
	}
	
	
	public function getCreatedAt() {
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value) {
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getExpiredAt() {
		return $this->_ExpiredAt;
	}
	public function setExpiredAt($value) {
		$this->_ExpiredAt = $value;
		$this->set('ExpiredAt' , $value);
	}
	
	
	public function getFirstName(){
	    return $this->_FirstName;
	}
	public function setFirstName($value){
	    $this->_FirstName = $value;
	}
	
	
	public function getLastName(){
	    return $this->_LastName;
	}
	public function setLastName($value){
	    $this->_LastName = $value;
	}
	
	
	public function __construct(){
		$model = Mage::getModel("dakiya/OTP_OTP_OTP");
		$tableName = $model->getResource()->getMainTable();
	
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($tableName);
	}
	
	
	public function setTableName($tableName){
		$this->_name =$tableName;
		parent::_setupTableName();
	}
	
	public function getTableName(){
		return $this->_name;
	}
	
	
}	
	 
	