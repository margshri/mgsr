<?php
class Margshri_WebPortal_VO_Master_Right_EntityVO extends Margshri_WebPortal_VO_BaseVO{
	
	public static $CLP_JOINING = 1;
	public static $CLP_PAGE_VISIT = 2;
	public static $SUB_PAGE_VISIT = 3;
	public static $PLAY_BIDDING = 4;
	
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

	    
	public function getID(){
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
    	$model = Mage::getModel("webportal/Master_Right_Entity");
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