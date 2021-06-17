<?php
class Dakiya_VO_Master_Email_EmailTemplateVO extends Dakiya_VO_BaseVO{
	
	public static $UPDATE_BENEFICIARY_DETAIL = 1;
	public static $RETRIEVE_CANCELLATION_AMOUNT = 2;
	public static $COD_ERS = 3;
	public static $COD_BOOKING_EPAYMENT_LINK = 4;
	public static $COD_CANCELLAION_EPAYMENT_LINK = 5;
	public static $LEGAL_EMAIL = 6;
	public static $CANCELLATION_WARNING_EMAIL = 7;
	public static $BLUEDART_SHIPMENT_REMINDER = 8;
	public static $CANCELLATION_WARNING_BULK_EMAIL = 9;
	public static $VIRTUAL_BLOCKED_BOOKING_REMINDER= 10;
	
	protected $_db;
	protected $_name;
	protected $_primary = 'TemplateID';
	
	private $_TemplateID;
	private $_TemplateName;
	private $_TemplateCode;
	private $_Subject;
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
	
	
	public function getSubject() {
		return $this->_Subject;
	}
	public function setSubject($value) {
		$this->_Subject = $value;
		$this->set('Subject' , $value);
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
		$model = Mage::getModel("dakiya/Master_Email_EmailTemplate");
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
	 
	