<?php
class Margshri_WebPortal_VO_Right_CLPPointsTranVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_CustomerID;
    protected $_CLPPointID;
    protected $_TypeID;
    protected $_ModeID;
    protected $_EntityID;
    protected $_EntityTransactionID;
    
    protected $_MinCLPPoints;
    protected $_MaxCLPPoints;
    protected $_RandomPoints;
    protected $_Points;
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
	
	
	public function getCustomerID(){
		return $this->_CustomerID;
	}
	public function setCustomerID($value){
		$this->_CustomerID = $value;
		$this->set('CustomerID' , $value);
	}

	
	
	public function getCLPPointID(){
		return $this->_CLPPointID;
	}
	public function setCLPPointID($value){
		$this->_CLPPointID = $value;
		$this->set('CLPPointID' , $value);
	}
	
	
	public function getTypeID(){
		return $this->_TypeID;
	}
	public function setTypeID($value){
		$this->_TypeID = $value;
		$this->set('TypeID' , $value);
	}
	 
	
	public function getModeID(){
		return $this->_ModeID;
	}
	public function setModeID($value){
		$this->_ModeID = $value;
		$this->set('ModeID' , $value);
	}
	
	public function getEntityID(){
		return $this->_EntityID;
	}
	public function setEntityID($value){
		$this->_EntityID = $value;
		$this->set('EntityID' , $value);
	}
	
	
	public function getEntityTransactionID(){
		return $this->_EntityTransactionID;
	}
	public function setEntityTransactionID($value){
		$this->_EntityTransactionID = $value;
		$this->set('EntityTransactionID' , $value);
	}
	
	
	
	public function getMinCLPPoints(){
		return $this->_MinCLPPoints;
	}
	public function setMinCLPPoints($value){
		$this->_MinCLPPoints = $value;
		$this->set('MinCLPPoints' , $value);
	}

	
	public function getMaxCLPPoints(){
		return $this->_MaxCLPPoints;
	}
	public function setMaxCLPPoints($value){
		$this->_MaxCLPPoints = $value;
		$this->set('MaxCLPPoints' , $value);
	}
	

	public function getRandomPoints(){
		return $this->_RandomPoints;
	}
	public function setRandomPoints($value){
		$this->_RandomPoints = $value;
		$this->set('RandomPoints' , $value);
	}
	
	
	public function getPoints(){
		return $this->_Points;
	}
	public function setPoints($value){
		$this->_Points = $value;
		$this->set('Points' , $value);
	}
	
		
	public function getCreatedAt(){
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	 
	
    public function __construct(){
    	$model = Mage::getModel("webportal/Right_CLPPointsTran");
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