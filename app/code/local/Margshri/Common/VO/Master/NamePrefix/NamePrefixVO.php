<?php
class Margshri_Common_VO_Master_NamePrefix_NamePrefixVO extends Margshri_Common_VO_ResponseVO{
    
    public static $modelName = "common/Master_NamePrefix_NamePrefix";
    public static $tableAlias = "common/mgsrnameprefix";
    public static $primaryKey = "ID";
    
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_Value;
	
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
	
	    
	public function getValue(){
	    return $this->_Value;
	}
	public function setValue($value){
	    $this->_Value = $value;
	  $this->set('Value' , $value);
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
