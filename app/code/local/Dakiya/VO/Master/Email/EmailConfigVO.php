<?php
class Dakiya_VO_Master_Email_EmailConfigVO extends Dakiya_VO_BaseVO{
	
	public static $SUPPORT_TEAM = 1;
	public static $LEGAL_TEAM = 2;
	public static $PAYONDELIVERY_TEAM = 3;
	public static $ANURAG_TEAM = 4;
	public static $PAYONDELIVERY_IRCTC_TEAM = 5;
	
	protected $_db;
	protected $_name;
	protected $_primary = 'ConfigID';
	
	private $_ConfigID;
	private $_ConfigName;
	private $_HostName;
	private $_UserEmail;
	private $_UserPass;
	private $_SMTPSecure;
	private $_Port;
	private $_SenderEmail;
	private $_ReplyToEmail;
	private $_RoleIDs;
	private $_SenderName;
	private $_ReplyToName;
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
	 
	
    public function getHostName() {
	  return $this->_HostName;
	}
	public function setHostName($value) {
	  $this->_HostName = $value;
	  $this->set('HostName' , $value);
	}
	
	
	public function getUserEmail() {
		return $this->_UserEmail;
	}
	public function setUserEmail($value) {
		$this->_UserEmail = $value;
		$this->set('UserEmail' , $value);
	}
	
	
	public function getUserPass() {
		return $this->_UserPass;
	}
	public function setUserPass($value) {
		$this->_UserPass = $value;
		$this->set('UserPass' , $value);
	}
	
	
	public function getSMTPSecure() {
		return $this->_SMTPSecure;
	}
	public function setSMTPSecure($value) {
		$this->_SMTPSecure = $value;
		$this->set('SMTPSecure' , $value);
	}
	
	
	public function getPort() {
		return $this->_Port;
	}
	public function setPort($value) {
		$this->_Port = $value;
		$this->set('Port' , $value);
	}
	
	
	
	
	
	public function getSenderEmail() {
		return $this->_SenderEmail;
	}
	public function setSenderEmail($value) {
		$this->_SenderEmail = $value;
		$this->set('SenderEmail' , $value);
	}
	
	
	public function getReplyToEmail() {
		return $this->_ReplyToEmail;
	}
	public function setReplyToEmail($value) {
		$this->_ReplyToEmail = $value;
		$this->set('ReplyToEmail' , $value);
	}
	
	
	public function getRoleIDs() {
		return $this->_RoleIDs;
	}
	public function setRoleIDs($value) {
		$this->_RoleIDs = $value;
		$this->set('RoleIDs' , $value);
	}

	
	public function getSenderName() {
		return $this->_SenderName;
	}
	public function setSenderName($value) {
		$this->_SenderName = $value;
		$this->set('SenderName' , $value);
	}
	
	
	public function getReplyToName() {
		return $this->_ReplyToName;
	}
	public function setReplyToName($value) {
		$this->_ReplyToName = $value;
		$this->set('ReplyToName' , $value);
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
		$model = Mage::getModel("dakiya/Master_Email_EmailConfig");
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
	 
	