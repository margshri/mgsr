<?php
class Dakiya_VO_SMS_SendSMS_SendSMSVO extends Dakiya_VO_BaseVO{
	
    public static $MODELPATH = 'dakiya/SMS_SendSMS_SendSMS';
    public static $TABLEALIAS = 'dakiya/dakiyasentsms';
    public static $PRIMARYKEY = 'ID';
    
    
	protected $_db;
	protected $_name;
	protected $_primary = 'SentSMSID';
	
	private $_SentSMSID;
	private $_SMSTemplateID;
	private $_SMSConfigID;
	private $_UserID;
	private $_ReceiverMobileNO;
	private $_Remarks;
	private $_SMSContent;
	private $_StatusID;
	private $_CreatedAt;
	private $_CreatedBy;
	private $_UpdatedAt;
	private $_UpdatedBy;
	
	private $_AuthKey;
	private $_SenderID;
	private $_Route;
	private $_URL;
	private $_SenderMobileNO;
	private $_SenderName;
	
	
	
	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function getSentSMSID() {
		return $this->_SentSMSID;
	}
	public function setSentSMSID($value) {
		$this->_SentSMSID = $value;
	}
	
	
	public function getSMSTemplateID() {
		return $this->_SMSTemplateID;
	}
	public function setSMSTemplateID($value) {
		$this->_SMSTemplateID = $value;
		$this->set('SMSTemplateID' , $value);
	}
	
	
	public function getSMSConfigID() {
		return $this->_SMSConfigID;
	}
	public function setSMSConfigID($value) {
		$this->_SMSConfigID = $value;
		$this->set('SMSConfigID' , $value);
	}
	
	
	public function getUserID() {
		return $this->_UserID;
	}
	public function setUserID($value) {
		$this->_UserID = $value;
		$this->set('UserID' , $value);
	}
	
	
	public function getReceiverMobileNO() {
		return $this->_ReceiverMobileNO;
	}
	public function setReceiverMobileNO($value) {
		$this->_ReceiverMobileNO = $value;
		$this->set('ReceiverMobileNO' , $value);
	}
	
	
	public function getRemarks() {
		return $this->_Remarks;
	}
	public function setRemarks($value) {
		$this->_Remarks = $value;
		$this->set('Remarks' , $value);
	}
	
	public function getSMSContent() {
		return $this->_SMSContent;
	}
	public function setSMSContent($value) {
		$this->_SMSContent = $value;
		$this->set('SMSContent' , $value);
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
	
	
	public function getAuthKey() {
		return $this->_AuthKey;
	}
	public function setAuthKey($value) {
		$this->_AuthKey = $value;
	}
	
	
	public function getSenderID() {
		return $this->_SenderID;
	}
	public function setSenderID($value) {
		$this->_SenderID = $value;
	}
	
	
	public function getRoute() {
		return $this->_Route;
	}
	public function setRoute($value) {
		$this->_Route = $value;
	}
	
	public function getURL() {
		return $this->_URL;
	}
	public function setURL($value) {
		$this->_URL = $value;
	}
	
	public function getSenderMobileNO() {
		return $this->_SenderMobileNO;
	}
	public function setSenderMobileNO($value) {
		$this->_SenderMobileNO = $value;
	}
	
	public function getSenderName() {
		return $this->_SenderName;
	}
	public function setSenderName($value) {
		$this->_SenderName = $value;
	}
	
	
	public function __construct(){
		$model = Mage::getModel("dakiya/SMS_SendSMS_SendSMS");
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
	 
	