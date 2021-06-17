<?php
class Margshri_Common_VO_Donation_Donation_DonationVO extends Margshri_Common_VO_ResponseVO{
	
    public static $modelName = "common/Donation_Donation_Donation";
    public static $tableAlias = "common/mgsrdonation";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_DonorName;
    protected $_FatherName;
    protected $_ContactNumber;
    protected $_Address;
    protected $_UserID;
    protected $_DonationTypeID;
    protected $_ReceiptBookID;
    protected $_ProgrammeID;
    protected $_ReceiptNumber;
    protected $_DonatedAmount;
    protected $_DonationYear;
    protected $_DonationDate;
    protected $_DonationTime;
    protected $_Description;
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
	
	
	public function getDonorName() {
	    return $this->_DonorName;
	}
	public function setDonorName($value){
	    $this->_DonorName = $value;
	    $this->set('DonorName' , $value);
	}
	
	
	public function getFatherName() {
	    return $this->_FatherName;
	}
	public function setFatherName($value){
	    $this->_FatherName = $value;
	    $this->set('FatherName' , $value);
	}
	
	
	public function getContactNumber() {
	    return $this->_ContactNumber;
	}
	public function setContactNumber($value){
	    $this->_ContactNumber = $value;
	    $this->set('ContactNumber' , $value);
	}
	
	
	public function getAddress() {
	    return $this->_Address;
	}
	public function setAddress($value){
	    $this->_Address = $value;
	    $this->set('Address' , $value);
	}
	
	
	public function getUserID() {
	  return $this->_UserID;
	}
	public function setUserID($value){
	  $this->_UserID = $value;
	  $this->set('UserID' , $value);
	}
	
	
	public function getDonationTypeID() {
	    return $this->_DonationTypeID;
	}
	public function setDonationTypeID($value){
	    $this->_DonationTypeID = $value;
	    $this->set('DonationTypeID' , $value);
	}
	
	
	public function getReceiptBookID() {
	    return $this->_ReceiptBookID;
	}
	public function setReceiptBookID($value){
	    $this->_ReceiptBookID = $value;
	    $this->set('ReceiptBookID' , $value);
	}
	
	
	public function getProgrammeID() {
	    return $this->_ProgrammeID;
	}
	public function setProgrammeID($value){
	    $this->_ProgrammeID = $value;
	    $this->set('ProgrammeID' , $value);
	}
	

	public function getReceiptNumber() {
	    return $this->_ReceiptNumber;
	}
	public function setReceiptNumber($value){
	    $this->_ReceiptNumber = $value;
	    $this->set('ReceiptNumber' , $value);
	}
	
	
	public function getDonatedAmount() {
	    return $this->_DonatedAmount;
	}
	public function setDonatedAmount($value){
	    $this->_DonatedAmount = $value;
	    $this->set('DonatedAmount' , $value);
	}
	
	
	public function getDonationYear() {
	    return $this->_DonationYear;
	}
	public function setDonationYear($value){
	    $this->_DonationYear = $value;
	    $this->set('DonationYear' , $value);
	}
	
	
	public function getDonationDate() {
	    return $this->_DonationDate;
	}
	public function setDonationDate($value){
	    $this->_DonationDate = $value;
	    $this->set('DonationDate' , $value);
	}
	
	
	public function getDonationTime() {
	    return $this->_DonationTime;
	}
	public function setDonationTime($value){
	    $this->_DonationTime = $value;
	    $this->set('DonationTime' , $value);
	}
	
	
	public function getDescription() {
	    return $this->_Description;
	}
	public function setDescription($value){
	    $this->_Description = $value;
	    $this->set('Description' , $value);
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
	
	
	public function getDonationTypeVO() {
	    return $this->_DonationTypeVO;
	}
	public function setDonationTypeVO($value){
	    $this->_DonationTypeVO = $value;
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
