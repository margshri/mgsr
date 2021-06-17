<?php
class Margshri_Common_VO_Member_Member_MemberVO extends Margshri_Common_VO_ResponseVO{
	
    public static $modelName = "common/Member_Member_Member";
    public static $tableAlias = "common/mgsrmember";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_UserID;
    
    protected $_DesignationID;
    protected $_MemberShipDate;
    protected $_IsExecutive;
    protected $_DisplayOrder;
  
    protected $_StatusID;
	protected $_CreatedAt;
	protected $_CreatedBy;
	protected $_UpdatedAt;
	protected $_UpdatedBy;
    
	protected $_UserVO;
	protected $_DonationTypeVO;
	
	
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
	public function setID($value){
	  $this->_ID = $value;
	}
	
	
	public function getUserID() {
	  return $this->_UserID;
	}
	public function setUserID($value){
	  $this->_UserID = $value;
	  $this->set('UserID' , $value);
	}
	
	
	public function getDesignationID() {
	    return $this->_DesignationID;
	}
	public function setDesignationID($value){
	    $this->_DesignationID = $value;
	    $this->set('DesignationID' , $value);
	}
	
	
	public function getMemberShipDate() {
	    return $this->_MemberShipDate;
	}
	public function setMemberShipDate($value){
	    $this->_MemberShipDate = $value;
	    $this->set('MemberShipDate' , $value);
	}
	
	
	public function getIsExecutive() {
	    return $this->_IsExecutive;
	}
	public function setIsExecutive($value){
	    $this->_IsExecutive = $value;
	    $this->set('IsExecutive' , $value);
	}
	
	
	public function getDisplayOrder() {
	    return $this->_DisplayOrder;
	}
	public function setDisplayOrder($value){
	    $this->_DisplayOrder = $value;
	    $this->set('DisplayOrder' , $value);
	}
	
	
	public function getStatusID() {
	    return $this->_StatusID;
	}
	public function setStatusID($value){
	    $this->_StatusID = $value;
	    $this->set('StatusID' , $value);
	}
	
	
	public function getCreatedAt() {
	    return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
	    $this->_CreatedAt = $value;
	    $this->set('CreatedAt' , $value);
	}
	
	
	public function getCreatedBy() {
	    return $this->_CreatedBy;
	}
	public function setCreatedBy($value){
	    $this->_CreatedBy = $value;
	    $this->set('CreatedBy' , $value);
	}
	
	
	public function getUpdatedAt() {
	    return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value){
	    $this->_UpdatedAt = $value;
	    $this->set('UpdatedAt' , $value);
	}
	
	
	public function getUpdatedBy() {
	    return $this->_UpdatedBy;
	}
	public function setUpdatedBy($value){
	    $this->_UpdatedBy = $value;
	    $this->set('UpdatedBy' , $value);
	}
	 
	
	public function getUserVO() {
	    return $this->_UserVO;
	}
	public function setUserVO($value){
	    $this->_UserVO = $value;
	}
	
	
	public function getDesignationVO() {
	    return $this->_DesignationVO;
	}
	public function setDesignationVO($value){
	    $this->_DesignationVO = $value;
	}
	
	
    public function __construct(){
    	$model = Mage::getModel(self::$modelName);
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
