<?php
class Margshri_WebPortal_VO_Footer_VisitorCounterVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';
    
    protected $_ID;
    protected $_VisitorIP;
    protected $_CreatedAt;
    
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
	
	
	public function getVisitorIP(){
		return $this->_VisitorIP;
	}
	public function setVisitorIP($value){
		$this->_VisitorIP = $value;
		$this->set('VisitorIP' , $value);
	}
 
		
	public function getCreatedAt(){
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	 
	
    public function __construct(){
    	$model = Mage::getModel("webportal/Footer_VisitorCounter");
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