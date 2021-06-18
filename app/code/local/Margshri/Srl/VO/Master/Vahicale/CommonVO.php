<?php
class Margshri_Transport_VO_Master_Vahicale_CommonVO extends Margshri_Common_VO_ResponseVO{
	
    public static $modelName = "transport/Master_Vahicale_Common";
    public static $tableAlias = "transport/mgsrvahicalecommon";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    
    protected $_VahicaleID;
    protected $_OwnerID;
    protected $_DriverID;
    protected $_StatusID;
	protected $_CreatedAt;
	protected $_CreatedBy;
	protected $_UpdatedAt;
	protected $_UpdatedBy;
	
	
	protected $_VahicaleVO;
	protected $_OwnerVO;
	protected $_DriverVO;
	
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
	
	
	public function getVahicaleID() {
	    return $this->_VahicaleID;
	}
	public function setVahicaleID($value){
	    $this->_VahicaleID = $value;
	    $this->set('VahicaleID' , $value);
	}
	
	
	public function getOwnerID() {
	    return $this->_OwnerID;
	}
	public function setOwnerID($value){
	    $this->_OwnerID = $value;
	    $this->set('OwnerID' , $value);
	}
	
	public function getDriverID() {
	    return $this->_DriverID;
	}
	public function setDriverID($value){
	    $this->_DriverID = $value;
	    $this->set('DriverID' , $value);
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
	
	 
	public function getVahicaleVO() {
	    return $this->_VahicaleVO;
	}
	public function setVahicaleVO($value){
	    $this->_VahicaleVO = $value;
	}
	
	
	public function getOwnerVO() {
	    return $this->_OwnerVO;
	}
	public function setOwnerVO($value){
	    $this->_OwnerVO = $value;
	}
	
	
	public function getDriverVO() {
	    return $this->_DriverVO;
	}
	public function setDriverVO($value){
	    $this->_DriverVO = $value;
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
