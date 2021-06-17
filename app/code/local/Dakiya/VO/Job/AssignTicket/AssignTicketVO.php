<?php
class Dakiya_VO_Job_AssignTicket_AssignTicketVO extends Dakiya_VO_BaseVO{
	
	protected $_db;
	protected $_name;
	protected $_primary = 'AssignTicketID';
	
	private $_AssignTicketID;
	private $_RequestID;
	private $_AssignTo;
	private $_AssignBy;
	private $_AssignAt;
	private $_FilterString;
	private $_isReAssign;
	private $_AssignCount;
	private $_VisitedAt;
	private $_Remarks;
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
	
	
	public function getAssignTicketID() {
		return $this->_AssignTicketID;
	}
	public function setAssignTicketID($value) {
		$this->_AssignTicketID= $value;
	}
	
	
	public function getRequestID() {
		return $this->_RequestID;
	}
	public function setRequestID($value) {
		$this->_RequestID = $value;
		$this->set('RequestID' , $value);
	}
	
	public function getAssignTo() {
		return $this->_AssignTo;
	}
	public function setAssignTo($value) {
		$this->_AssignTo= $value;
		$this->set('AssignTo' , $value);
	}
	
	
	public function getAssignBy() {
		return $this->_AssignBy;
	}
	public function setAssignBy($value) {
		$this->_AssignBy= $value;
		$this->set('AssignBy' , $value);
	}
	
	
	public function getAssignAt() {
		return $this->_AssignAt;
	}
	public function setAssignAt($value) {
		$this->_AssignAt= $value;
		$this->set('AssignAt' , $value);
	}
	
	public function getFilterString() {
		return $this->_FilterString;
	}
	public function setFilterString($value) {
		$this->_FilterString = $value;
		$this->set('FilterString' , $value);
	}
	
	public function getIsReAssign() {
		return $this->_IsReAssign;
	}
	public function setIsReAssign($value) {
		$this->_IsReAssign= $value;
		$this->set('IsReAssign' , $value);
	}
	
	public function getAssignCount() {
		return $this->_AssignCount;
	}
	public function setAssignCount($value) {
		$this->_AssignCount= $value;
		$this->set('AssignCount' , $value);
	}
	
	public function getVisitedAt() {
		return $this->_VisitedAt;
	}
	public function setVisitedAt($value) {
		$this->_VisitedAt= $value;
		$this->set('VisitedAt' , $value);
	}
	
	public function getVisitedBy() {
		return $this->_VisitedBy;
	}
	public function setVisitedBy($value) {
		$this->_VisitedBy= $value;
		$this->set('VisitedBy' , $value);
	}
	
	
	public function getRemarks() {
		return $this->_Remarks;
	}
	public function setRemarks($value) {
		$this->_Remarks= $value;
		$this->set('Remarks' , $value);
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
		$model = Mage::getModel("dakiya/Job_AssignTicket_AssignTicket");
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
	 
	