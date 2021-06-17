<?php
class Margshri_Common_VO_Customer_CustomerVO extends Margshri_Common_VO_BaseVO{

    
    public static $MODELPATH = 'common/Customer_Customer';
    public static $TABLEALIAS = 'common/apctcustomer';
    public static $PRIMARYKEY = 'ID';
    
    
	protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_CustomerID;
    protected $_FirstName;
    protected $_LastName;
    protected $_CustomerImage;
    protected $_MobileNumber;
    protected $_Email;
    protected $_IsShowProfile;
    protected $_IsMobileRequest;
    protected $_IsMobileOTPVerified;
    protected $_StatusID;
    protected $_CreatedAt;
    protected $_CreatedBy;
    protected $_UpdatedAt;
    protected $_UpdatedBy;
    
	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}

	public function getDataArray(){
		return $this->_data;
	}

	    
	public function getID(){
	  return $this->_ID;
	}
	public function setID($value){
	  $this->_ID = $value;
	}
	
	
	public function getCustomerID(){
		return $this->_CustomerID;
	}
	public function setCustomerID($value){
		$this->_CustomerID = $value;
		$this->set('CustomerID' , $value);
	}
	
	
	public function getFirstName(){
	    return $this->_FirstName;
	}
	public function setFirstName($value){
	    $this->_FirstName = $value;
	    $this->set('FirstName' , $value);
	}
	
	
	public function getLastName(){
	    return $this->_LastName;
	}
	public function setLastName($value){
	    $this->_LastName = $value;
	    $this->set('LastName' , $value);
	}
	
	
	public function getCustomerImage(){
		return $this->_CustomerImage;
	}
	public function setCustomerImage($value){
		$this->_CustomerImage = $value;
		$this->set('CustomerImage' , $value);
	}

	
	public function getMobileNumber(){
	    return $this->_MobileNumber;
	}
	public function setMobileNumber($value){
	    $this->_MobileNumber = $value;
	    $this->set('MobileNumber' , $value);
	}
	
	
	public function getEmailID(){
	    return $this->_EmailID;
	}
	public function setEmailID($value){
	    $this->_EmailID = $value;
	    $this->set('EmailID' , $value);
	}
	
	
	public function getIsShowProfile(){
		return $this->_IsShowProfile;
	}
	public function setIsShowProfile($value){
		$this->_IsShowProfile = $value;
		$this->set('IsShowProfile' , $value);
	}
	
	
	public function getIsMobileRequest(){
	    return $this->_IsMobileRequest;
	}
	public function setIsMobileRequest($value){
	    $this->_IsMobileRequest = $value;
	    $this->set('IsMobileRequest' , $value);
	}
	
	public function getIsMobileOTPVerified(){
	    return $this->_IsMobileOTPVerified;
	}
	public function setIsMobileOTPVerified($value){
	    $this->_IsMobileOTPVerified = $value;
	    $this->set('IsMobileOTPVerified' , $value);
	}
	
	
	
	public function getStatusID(){
		return $this->_StatusID;
	}
	public function setStatusID($value){
		$this->_StatusID = $value;
		$this->set('StatusID' , $value);
	}
	
	
	public function getCreatedAt(){
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getCreatedBy(){
		return $this->_CreatedBy;
	}
	public function setCreatedBy($value){
		$this->_CreatedBy = $value;
		$this->set('CreatedBy' , $value);
	}
	
	public function getUpdatedAt(){
		return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value){
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	
	public function getUpdatedBy(){
		return $this->_UpdatedBy;
	}
	public function setUpdatedBy($value){
		$this->_UpdatedBy = $value;
		$this->set('UpdatedBy' , $value);
	}
	
	
	public function __construct(){
		$model = Mage::getModel("common/Customer_Customer");
		$tableName = $model->getResource()->getMainTable();
	
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($tableName);
		 
	}
	
	
	public function setTableName($tableName)
	{
		$this->_name =$tableName;
		parent::_setupTableName();
	}
	
	public function getTableName(){
		return $this->_name;
	}

}