<?php
class Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO extends Margshri_Common_VO_ResponseVO{
	
    public static $modelName = "common/Donation_ReceiptBook_ReceiptBook";
    public static $tableAlias = "common/mgsrreceiptbook";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_BookName;
    protected $_BookCode;
    protected $_TotalAmount;
    protected $_Description;
    protected $_SocietyID;
    protected $_OfficeID;
    protected $_StatusID;
	protected $_CreatedAt;
	protected $_CreatedBy;
	protected $_UpdatedAt;
	protected $_UpdatedBy;
    
	protected $_UserVO;
	
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
	
	
	public function getBookName(){
	    return $this->_BookName;
	}
	public function setBookName($value){
	    $this->_BookName = $value;
	  $this->set('BookName' , $value);
	}

	
	public function getBookCode(){
	    return $this->_BookCode;
	}
	public function setBookCode($value){
	    $this->_BookCode = $value;
	    $this->set('BookCode' , $value);
	}
	
	
	public function getTotalAmount(){
	    return $this->_TotalAmount;
	}
	public function setTotalAmount($value){
	    $this->_TotalAmount = $value;
	    $this->set('TotalAmount' , $value);
	}
	
	
	public function getDescription(){
	    return $this->_Description;
	}
	public function setDescription($value){
	    $this->_Description = $value;
	    $this->set('Description' , $value);
	}
	
	
	public function getSocietyID() {
	    return $this->_SocietyID;
	}
	public function setSocietyID($value){
	    $this->_SocietyID = $value;
	    $this->set('SocietyID' , $value);
	}
	
	
	public function getOfficeID() {
	    return $this->_OfficeID;
	}
	public function setOfficeID($value){
	    $this->_OfficeID = $value;
	    $this->set('OfficeID' , $value);
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
	    $this->set('UserVO' , $value);
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
