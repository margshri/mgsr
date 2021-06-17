<?php
class Margshri_MedicalCamp_VO_DoctorListVO extends Margshri_MedicalCamp_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
   
    protected $_ID;
    protected $_Name;
    protected $_Address;
    protected $_MobileNumber;
    protected $_Email;
    protected $_Qualification;    
    protected $_Designation;
    protected $_Department;
    protected $_Specialisation;
    
    
    

	protected $_data = array();
	
	protected function set($name, $value){
		$this->_data[$name]=$value;
	}

	public function getDataArray(){
		return $this->_data;
	}

	    
	public function getID() 
	{
	  return $this->_ID;
	}
	
	public function setID($value) 
	{
	  $this->_ID = $value;
	}
	
	
	public function getName()
	{
		return $this->_Name;
	}
	
	public function setName($value)
	{
		$this->_Name = $value;
		$this->set('Name' , $value);
	}
	   
	
	public function getAddress()
	{
		return $this->_Address;
	}
	
	public function setAddress($value)
	{
		$this->_Address = $value;
		$this->set('Address' , $value);
	}
	
	
	public function getMobileNumber()
	{
		return $this->_MobileNumber;
	}
	
	public function setMobileNumber($value)
	{
		$this->_MobileNumber = $value;
		$this->set('MobileNumber' , $value);
	}
	
	
	public function getEmail()
	{
		return $this->_Email;
	}
	
	public function setEmail($value)
	{
		$this->_Email = $value;
		$this->set('Email' , $value);
	}
	
	
	public function getQualification()
	{
		return $this->_Qualification;
	}
	
	public function setQualification($value)
	{
		$this->_Qualification = $value;
		$this->set('Qualification' , $value);
	}
	
	
	public function getDesignation()
	{
		return $this->_Designation;
	}
	
	public function setDesignation($value)
	{
		$this->_Designation = $value;
		$this->set('Designation' , $value);
	}
	
	public function getDepartment()
	{
		return $this->_Department;
	}
	
	public function setDepartment($value)
	{
		$this->_Department = $value;
		$this->set('Department' , $value);
	}
	
	
	public function getSpecialisation()
	{
		return $this->_Specialisation;
	}
	
	public function setSpecialisation($value)
	{
		$this->_Specialisation = $value;
		$this->set('Specialisation' , $value);
	}
	 
	
    public function __construct(){
    	$model = Mage::getModel("medicalcamp/Registration_DoctorList");
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