<?php
class Margshri_Common_VO_Donation_DonationType_DonationTypeVO extends Margshri_Common_VO_ResponseVO{
	
    public static $CASH_WITH_RECEIPT = 1;
    public static $CASH_WITHOUT_RECEIPT = 2;
    public static $MEMBERSHIP_RECEIPT = 13;
    public static $BLOOD = 30;
    public static $BLOOD_SDP = 31;
     
    
    public static $modelName = "common/Donation_DonationType_DonationType";
    public static $tableAlias = "common/mgsrdonationtype";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_TypeName;
    protected $_TypeImage;
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
	
	    
	public function getTypeName(){
	    return $this->_TypeName;
	}
	public function setTypeName($value){
	    $this->_TypeName = $value;
	  $this->set('TypeName' , $value);
	}
	
	
	public function getTypeImage() {
	    return $this->_TypeImage;
	}
	public function setTypeImage($value){
	    $this->_TypeImage = $value;
	    $this->set('TypeImage' , $value);
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
