<?php
class Margshri_Common_VO_Programme_Programme_ProgrammeVO extends Margshri_Common_VO_ResponseVO{
	
    public static $modelName = "common/Programme_Programme_Programme";
    public static $tableAlias = "common/mgsrprogramme";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_ProgrammeName;
    protected $_ProgrammeYear;
    protected $_ProgrammeDate;
    protected $_TypeID;
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
	
	    
	public function getProgrammeName() {
	    return $this->_ProgrammeName;
	}
	public function setProgrammeName($value){
	    $this->_ProgrammeName = $value;
	    $this->set('ProgrammeName' , $value);
	}
	
	
	public function getProgrammeYear() {
	    return $this->_ProgrammeYear;
	}
	public function setProgrammeYear($value){
	    $this->_ProgrammeYear = $value;
	    $this->set('ProgrammeYear' , $value);
	}
	
	
	public function getProgrammeDate() {
	    return $this->_ProgrammeDate;
	}
	public function setProgrammeDate($value){
	    $this->_ProgrammeDate = $value;
	    $this->set('ProgrammeDate' , $value);
	}
	
	
	public function getTypeID() {
	    return $this->_TypeID;
	}
	public function setTypeID($value){
	    $this->_TypeID = $value;
	    $this->set('TypeID' , $value);
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
