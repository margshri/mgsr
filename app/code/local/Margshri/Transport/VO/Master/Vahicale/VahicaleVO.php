<?php
class Margshri_Transport_VO_Master_Vahicale_VahicaleVO extends Margshri_Common_VO_ResponseVO{
	
    public static $modelName = "transport/Master_Vahicale_Vahicale";
    public static $tableAlias = "transport/mgsrvahicale";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    
    protected $_VahicaleNumber;
    protected $_ChasisNumber;
    protected $_EngineNumber;
    protected $_WeightCapacity;
    protected $_VahicaleSizeID;
    protected $_TypeID;
    protected $_OwnerID;
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
	
	
	public function getVahicaleNumber() {
	    return $this->_VahicaleNumber;
	}
	public function setVahicaleNumber($value){
	    $this->_VahicaleNumber = $value;
	    $this->set('VahicaleNumber' , $value);
	}
	
	
	public function getChasisNumber() {
	    return $this->_ChasisNumber;
	}
	public function setChasisNumber($value){
	    $this->_ChasisNumber = $value;
	    $this->set('ChasisNumber' , $value);
	}
	
	public function getEngineNumber() {
	    return $this->_EngineNumber;
	}
	public function setEngineNumber($value){
	    $this->_EngineNumber = $value;
	    $this->set('EngineNumber' , $value);
	}
	
	
	public function getWeightCapacity() {
	    return $this->_WeightCapacity;
	}
	public function setWeightCapacity($value){
	    $this->_WeightCapacity = $value;
	    $this->set('WeightCapacity' , $value);
	}
	
	
	public function getVahicaleSizeID() {
	    return $this->_VahicaleSizeID;
	}
	public function setVahicaleSizeID($value){
	    $this->_VahicaleSizeID = $value;
	    $this->set('VahicaleSizeID' , $value);
	}
	
	
	public function getTypeID() {
	    return $this->_TypeID;
	}
	public function setTypeID($value){
	    $this->_TypeID = $value;
	    $this->set('TypeID' , $value);
	}
	
	
	public function getOwnerID() {
	    return $this->_OwnerID;
	}
	public function setOwnerID($value){
	    $this->_OwnerID = $value;
	    $this->set('OwnerID' , $value);
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
