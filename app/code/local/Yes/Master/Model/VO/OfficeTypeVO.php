<?php
class Yes_Master_Model_VO_OfficeTypeVO extends Zend_Db_Table_Abstract {

	  protected $_db;
	  protected $_name;
	  protected $_primary = 'OfficeTypeId';

	  
	  protected $_typeCode;
      protected $_typeName;
	  protected $_createdAt;
	  protected $_createdBy;

	  protected $_data = array();
	/*  
    public function __set($name, $value);
    public function __get($name);
    */

	protected function set($name, $value){
		$this->_data[$name]=$value;	
	}
	
	public function getDataArray(){
		return $this->_data;
	}
	
    public function setTypeCode($typeCode){
    	   $this->_typeCode =$typeCode;
    	   $this->set('TypeCode' , $typeCode);
    }
    public function getTypeCode(){
    	   return $this->_typeCode;
    }

    public function setTypeName($typeName){
    	   $this->_typeCode =$typeName;
    	   $this->set('TypeName' , $typeName);
    }
    public function getTypeName(){
    	   return $this->_typeName;
    }
    
     public function setCreatedAt($createdAt){
    	  $this->_createdAt = $createdAt;
    	  $this->set('createdAt' , $createdAt);
    	  
    }
    public function getCreatedAt(){
    	  return $this->_createdAt;
    }
    
    public function setCreatedBy($createdBy){
    	      $this->_createdBy= $createdBy;
    		  $this->set('createdBy' , $createdBy);
    	      
    }
    
    public function getCreatedBy(){
    		return $this->_createdBy;	
    }
    
 
	   
	  public function __construct($tableName){
	  		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
	  		$this->setDefaultAdapter($con);
	  		$this->_db = $con;
	  		$this->setTableName($tableName);	
	  		$this->_typeCode="TypeCode";
	  		$this->_typeName="TypeName";
	  		$this->_createdAt="CreatedAt";
	  		$this->_createdBy="CreatedBy";
	  		
	  }
	  
	  public function setTableName($tableName){
	  		
	  		//$entityObj = new Mage_Core_Model_Mysql4_Abstract();	
	  		//$this->$_name = $entityObj->getTable('Yeswms/goodsreceiptrectifylog');
	  		$this->_name =$tableName;
	  		parent::_setupTableName();
	  }
	  
	  public function getTableName(){
	  	   return $this->$_name;
	  }
	  

	    
}