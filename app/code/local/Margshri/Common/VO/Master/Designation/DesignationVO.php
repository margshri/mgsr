<?php
class Margshri_Common_VO_Master_Designation_DesignationVO extends Margshri_Common_VO_ResponseVO{
    
    public static $modelName = "common/Master_Designation_Designation";
    public static $tableAlias = "common/mgsrdesignation";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_Code;
    protected $_Value;
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

	    
	public function getID() {
	  return $this->_ID;
	}
	public function setID($value){
	  $this->_ID = $value;
	}
	
	public function getCode(){
	    return $this->_Code;
	}
	public function setCode($value){
	    $this->_Code = $value;
	    $this->set('Code' , $value);
	}
	    
	public function getValue(){
	    return $this->_Value;
	}
	public function setValue($value){
	    $this->_Value = $value;
	  $this->set('Value' , $value);
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
