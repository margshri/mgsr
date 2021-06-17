<?php
class Dakiya_VO_Master_SMS_SMSConfigVO extends Dakiya_VO_BaseVO{
	
    
    public static $CUSTOMER_REGISTRATION = 2;    
    
	protected $_db;
	protected $_name;
	protected $_primary = 'ConfigID';
	
	private $_ConfigID;
	private $_ConfigName;
	private $_AuthKey;
	private $_SenderID;
	private $_Route;
	private $_URL;
	private $_SenderMobileNO;
	private $_SenderName;
	private $_RoleIDs;
	private $_StatusID;
	private $_CreatedAt;
	private $_CreatedBy;
	private $_UpdatedAt;
	private $_UpdatedBy;
	
	
	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function getConfigID() {
	  return $this->_ConfigID;
	}
	public function setConfigID($value) {
	  $this->_ConfigID = $value;
	}
	
	
	public function getConfigName() {
	  return $this->_ConfigName;
	}
	public function setConfigName($value) {
	  $this->_ConfigName = $value;
	  $this->set('ConfigName' , $value);
	}

	
	public function getAuthKey() {
		return $this->_AuthKey;
	}
	public function setAuthKey($value) {
		$this->_AuthKey = $value;
		$this->set('AuthKey' , $value);
	}
 
	
	public function getSenderID() {
		return $this->_SenderID;
	}
	public function setSenderID($value) {
		$this->_SenderID = $value;
		$this->set('SenderID' , $value);
	}
	
	
	public function getRoute() {
		return $this->_Route;
	}
	public function setRoute($value) {
		$this->_Route = $value;
		$this->set('Route' , $value);
	}
	
	public function getURL() {
		return $this->_URL;
	}
	public function setURL($value) {
		$this->_URL = $value;
		$this->set('URL' , $value);
	}
	

	public function getSenderMobileNO() {
		return $this->_SenderMobileNO;
	}
	public function setSenderMobileNO($value) {
		$this->_SenderMobileNO = $value;
		$this->set('SenderMobileNO' , $value);
	}
	
	
	
	public function getSenderName() {
		return $this->_SenderName;
	}
	public function setSenderName($value) {
		$this->_SenderName = $value;
		$this->set('SenderName' , $value);
	}
	
	
	public function getRoleIDs() {
		return $this->_RoleIDs;
	}
	public function setRoleIDs($value) {
		$this->_RoleIDs = $value;
		$this->set('RoleIDs' , $value);
	}
	
	
	public function getStatusID() {
		return $this->_StatusID;
	}
	public function setStatusID($value) {
		$this->_StatusID = $value;
		$this->set('StatusID' , $value);
	}
	
	
	public function getCreatedAt() {
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value) {
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getCreatedBy() {
		return $this->_CreatedBy;
	}
	
	public function setCreatedBy($value) {
		$this->_CreatedBy = $value;
		$this->set('CreatedBy' , $value);
	}
	
	
	public function getUpdatedAt() {
		return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value) {
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	
	
	public function getUpdatedBy() {
		return $this->_UpdatedBy;
	}
	public function setUpdatedBy($value) {
		$this->_UpdatedBy = $value;
		$this->set('UpdatedBy' , $value);
	}
	
	
	public function __construct(){
		$model = Mage::getModel("dakiya/Master_SMS_SMSConfig");
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
	 
	