<?php
class Margshri_MedicalCamp_VO_RegistrationVO extends Margshri_MedicalCamp_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
   
    private $_ID;
    private $_Name;
    private $_FirstName;
    private $_MotherName;
    private $_LastName;
    private $_FatherName;
    private $_Caste;
    private $_Gender;
    private $_Age;
    private $_AgeGroupID;
    private $_DOB;
    private $_DateOfBirth;
    private $_PaymentResponse;
    private $_Address;
    private $_Pincode;
    private $_MobileNumber;
    private $_ContactNumber;
    private $_Email;
    private $_Qualification;
    private $_Percentage;
    private $_CurrentSchool;

    private $_ClassID;
    private $_SubjectID;
    private $_BoardID;

    private $_DesireSchool;
    private $_DesireCourse;
    private $_FamilyBusiness;
    private $_YearlyIncome;
    private $_BPLAPL;
    private $_ImageURL;
    private $_RationCardURL;
    private $_QualificationURL;
    private $_CreatedAt;
    private $_UpdatedAt;
    private $_AddharCardNumber;
    private $_AddharCardURL;
    private $_RollNo;
	private $_CountryID;
    private $_StateID;
    private $_DistrictID;
    private $_CityID;
    
    private $_ProgrammeID;
    private $_UserID;

    private $_CityName;
    private $_ClassName;

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
	public function setID($value) {
		$this->_ID = $value;
	}

	
	public function getName() {
		return $this->_Name;
	}
	public function setName($value) {
		$this->_Name = $value;
		$this->set('Name' , $value);
	}
	
	
	public function getFirstName() {
		return $this->_FirstName;
	}
	public function setFirstName($value) {
		$this->_FirstName = $value;
		$this->set('FirstName' , $value);
	}
	
	
	public function getMotherName() {
		return $this->_MotherName;
	}
	public function setMotherName($value) {
		$this->_MotherName = $value;
		$this->set('MotherName' , $value);
	}
	
	
	public function getLastName() {
		return $this->_LastName;
	}
	public function setLastName($value) {
		$this->_LastName= $value;
		$this->set('LastName' , $value);
	}
	
	
	public function getFatherName() {
		return $this->_FatherName;
	}
	public function setFatherName($value) {
		$this->_FatherName = $value;
		$this->set('FatherName' , $value);
	}
	
	
	public function getCaste() {
		return $this->_Caste;
	}
	public function setCaste($value) {
		$this->_Caste = $value;
		$this->set('Caste' , $value);
	}
	
	
	public function getGender() {
		return $this->_Gender;
	}
	public function setGender($value) {
		$this->_Gender = $value;
		$this->set('Gender' , $value);
	}
	
	
	public function getAge() {
		return $this->_Age;
	}
	public function setAge($value) {
		$this->_Age = $value;
		$this->set('Age' , $value);
	}
	
	
	public function getAgeGroupID() {
		return $this->_AgeGroupID;
	}
	public function setAgeGroupID($value) {
		$this->_AgeGroupID = $value;
		$this->set('AgeGroupID' , $value);
	}
	
	
	public function getDOB() {
		return $this->_DOB;
	}
	public function setDOB($value) {
		$this->_DOB = $value;
		$this->set('DOB' , $value);
	}

	
	public function getAddress() {
		return $this->_Address;
	}
	public function setAddress($value) {
		$this->_Address = $value;
		$this->set('Address' , $value);
	}
	
	
	public function getPincode() {
		return $this->_Pincode;
	}
	public function setPincode($value) {
		$this->_Pincode = $value;
		$this->set('Pincode' , $value);
	}
	
	
	public function getMobileNumber() {
		return $this->_MobileNumber;
	}
	public function setMobileNumber($value) {
		$this->_MobileNumber = $value;
		$this->set('MobileNumber' , $value);
	}
	
	
	public function getContactNumber() {
		return $this->_ContactNumber;
	}
	public function setContactNumber($value) {
		$this->_ContactNumber = $value;
		$this->set('ContactNumber' , $value);
	}
	
	
	public function getEmail() {
		return $this->_Email;
	}
	public function setEmail($value) {
		$this->_Email = $value;
		$this->set('Email' , $value);
	}
	
	
	public function getQualification() {
		return $this->_Qualification;
	}
	public function setQualification($value) {
		$this->_Qualification = $value;
		$this->set('Qualification' , $value);
	}
	
	
	public function getPercentage() {
		return $this->_Percentage;
	}
	public function setPercentage($value) {
		$this->_Percentage = $value;
		$this->set('Percentage' , $value);
	}
	
	
	public function getCurrentSchool() {
		return $this->_CurrentSchool;
	}
	public function setCurrentSchool($value) {
		$this->_CurrentSchool = $value;
		$this->set('CurrentSchool' , $value);
	}


	public function getClassID() {
		return $this->_ClassID;
	}
	public function setClassID($value) {
		$this->_ClassID = $value;
		$this->set('ClassID' , $value);
	}
	

	public function getSubjectID() {
		return $this->_SubjectID;
	}
	public function setSubjectID($value) {
		$this->_SubjectID = $value;
		$this->set('SubjectID' , $value);
	}


	public function getBoardID() {
		return $this->_BoardID;
	}
	public function setBoardID($value) {
		$this->_BoardID = $value;
		$this->set('BoardID' , $value);
	}

	
	public function getDesireSchool() {
		return $this->_DesireSchool;
	}
	public function setDesireSchool($value) {
		$this->_DesireSchool = $value;
		$this->set('DesireSchool' , $value);
	}
	
	
	public function getDesireCourse() {
		return $this->_DesireCourse;
	}
	public function setDesireCourse($value) {
		$this->_DesireCourse = $value;
		$this->set('DesireCourse' , $value);
	}
	
	
	public function getFamilyBusiness() {
		return $this->_FamilyBusiness;
	}
	public function setFamilyBusiness($value) {
		$this->_FamilyBusiness = $value;
		$this->set('FamilyBusiness' , $value);
	}
	
	
	public function getYearlyIncome() {
		return $this->_YearlyIncome;
	}
	public function setYearlyIncome($value) {
		$this->_YearlyIncome = $value;
		$this->set('YearlyIncome' , $value);
	}
	
	
	public function getBPLAPL() {
		return $this->_BPLAPL;
	}
	public function setBPLAPL($value) {
		$this->_BPLAPL = $value;
		$this->set('BPLAPL' , $value);
	}
	
	
	public function getImageURL() {
		return $this->_ImageURL;
	}
	public function setImageURL($value) {
		$this->_ImageURL = $value;
		$this->set('ImageURL' , $value);
	}
	
	
	public function getRationCardURL() {
		return $this->_RationCardURL;
	}
	public function setRationCardURL($value) {
		$this->_RationCardURL = $value;
		$this->set('RationCardURL' , $value);
	}
	
	
	public function getQualificationURL() {
		return $this->_QualificationURL;
	}
	public function setQualificationURL($value) {
		$this->_QualificationURL = $value;
		$this->set('QualificationURL' , $value);
	}
	
	
	public function getCreatedAt() {
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value) {
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getUpdatedAt() {
		return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value) {
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	
	public function getAddharCardNumber() {
		return $this->_AddharCardNumber;
	}
	public function setAddharCardNumber($value) {
		$this->_AddharCardNumber = $value;
		$this->set('AddharCardNumber' , $value);
	}
	
	public function getAddharCardURL() {
		return $this->_AddharCardURL;
	}
	public function setAddharCardURL($value) {
		$this->_AddharCardURL = $value;
		$this->set('AddharCardURL' , $value);
	}
	
	public function getRollNo() {
		return $this->_RollNo;
	}
	public function setRollNo($value) {
		$this->_RollNo= $value;
		$this->set('RollNo' , $value);
	}
	
	public function getTransactionID() {
		return $this->_TransactionID;
	}
	public function setTransactionID($value) {
		$this->_TransactionID= $value;
		$this->set('TransactionID' , $value);
	}
	
	public function getDateOfBirth() {
		return $this->_DateOfBirth;
	}
	public function setDateOfBirth($value) {
		$this->_DateOfBirth= $value;
		$this->set('DateOfBirth' , $value);
	}
	
	public function getPaymentResponse() {
		return $this->_PaymentResponse;
	}
	public function setPaymentResponse($value) {
		$this->_PaymentResponse= $value;
		$this->set('PaymentResponse' , $value);
	}
	
	
	public function getIsPaid() {
		return $this->_IsPaid;
	}
	public function setIsPaid($value) {
		$this->_IsPaid= $value;
		$this->set('IsPaid' , $value);
	}
	
	
	public function getCountryID() {
		return $this->_CountryID;
	}
	public function setCountryID($value) {
		$this->_CountryID= $value;
		$this->set('CountryID' , $value);
	}


	public function getStateID() {
		return $this->_StateID;
	}
	public function setStateID($value) {
		$this->_StateID= $value;
		$this->set('StateID' , $value);
	}


	public function getDistrictID() {
		return $this->_DistrictID;
	}
	public function setDistrictID($value) {
		$this->_DistrictID= $value;
		$this->set('DistrictID' , $value);
	}


	public function getCityID() {
		return $this->_CityID;
	}
	public function setCityID($value) {
		$this->_CityID = $value;
		$this->set('CityID' , $value);
	}
	
	public function getProgrammeID() {
	    return $this->_ProgrammeID;
	}
	public function setProgrammeID($value) {
	    $this->_ProgrammeID = $value;
	    $this->set('ProgrammeID' , $value);
	}
	
	public function getUserID() {
	    return $this->_UserID;
	}
	public function setUserID($value) {
	    $this->_UserID = $value;
	    $this->set('UserID' , $value);
	}
	
	 
	
	public function getCityName() {
	    return $this->_CityName;
	}
	public function setCityName($value) {
	    $this->_CityName = $value;
	}
	
	public function getClassName() {
	    return $this->_ClassName;
	}
	public function setClassName($value) {
	    $this->_ClassName = $value;
	}
	
	
    public function __construct(){
    	
    	$model = Mage::getModel("medicalcamp/Registration_Registration");
    	//$tableName = $model->getResource()->getMainTable();
    	$tableName = 'student_registration';
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
