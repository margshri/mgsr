<?php
class Dakiya_VO_Master_SMS_SMSTemplateVO extends Dakiya_VO_BaseVO{
	
	public static $MANUAL_SMS_CONTENT = 1;
	
	public static $CUSTOMER_REGISTRATION_OTP = 2;
	
	protected $_db;
	protected $_name;
	protected $_primary = 'TemplateID';
	
	private $_TemplateID;
	private $_TemplateName;
	private $_TemplateCode;
	private $_Query;
	private $_Content;
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
	
	
	public function getTemplateID() {
		return $this->_TemplateID;
	}
	public function setTemplateID($value) {
		$this->_TemplateID = $value;
	}
	
	
	public function getTemplateName() {
		return $this->_TemplateName;
	}
	public function setTemplateName($value) {
		$this->_TemplateName = $value;
		$this->set('TemplateName' , $value);
	}
	

	public function getTemplateCode() {
		return $this->_TemplateCode;
	}
	public function setTemplateCode($value) {
		$this->_TemplateCode = $value;
		$this->set('TemplateCode' , $value);
	}
	
	public function getQuery() {
		return $this->_Query;
	}
	public function setQuery($value) {
		$this->_Query = $value;
		$this->set('Query' , $value);
	}
	
	public function getContent() {
		return $this->_Content;
	}
	public function setContent($value) {
		$this->_Content = $value;
		$this->set('Content' , $value);
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
		$model = Mage::getModel("dakiya/Master_SMS_SMSTemplate");
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
	 
	