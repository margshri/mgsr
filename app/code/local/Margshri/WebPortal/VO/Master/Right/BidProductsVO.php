<?php
class Margshri_WebPortal_VO_Master_Right_BidProductsVO extends Margshri_WebPortal_VO_BaseVO{
	
    protected $_db;
    protected $_name;
    protected $_primary = 'ID';

    protected $_ID;
    protected $_BidID;
    protected $_ProductID;
    protected $_StatusID;
    protected $_CreatedAt;
    protected $_CreatedBy;
    protected $_UpdatedAt;
    protected $_UpdatedBy;
    
    protected $_ProductName;
    protected $_ProductCode;
    protected $_ProductImage;
    protected $_ProductDescription;
    protected $_ProductPrice;
    protected $_ProductWeight;
    protected $_ProductWeightUnit;
    
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
	 
	
	public function getBidID(){
		return $this->_BidID;
	}
	public function setBidID($value){
		$this->_BidID = $value;
		$this->set('BidID' , $value);
	}
	
	public function getProductID(){
		return $this->_ProductID;
	}
	public function setProductID($value){
		$this->_ProductID = $value;
		$this->set('ProductID' , $value);
	}
	
	
	public function getStatusID(){
		return $this->_StatusID;
	}
	public function setStatusID($value){
		$this->_StatusID = $value;
		$this->set('StatusID' , $value);
	}
	
	
	public function getCreatedAt(){
		return $this->_CreatedAt;
	}
	public function setCreatedAt($value){
		$this->_CreatedAt = $value;
		$this->set('CreatedAt' , $value);
	}
	
	
	public function getCreatedBy(){
		return $this->_CreatedBy;
	}
	public function setCreatedBy($value){
		$this->_CreatedBy = $value;
		$this->set('CreatedBy' , $value);
	}
	
	
	public function getUpdatedAt(){
		return $this->_UpdatedAt;
	}
	public function setUpdatedAt($value){
		$this->_UpdatedAt = $value;
		$this->set('UpdatedAt' , $value);
	}
	
	
	public function getUpdatedBy(){
		return $this->_UpdatedBy;
	}
	public function setUpdatedBy($value){
		$this->_UpdatedBy = $value;
		$this->set('UpdatedBy' , $value);
	}

	public function getProductName(){
		return $this->_ProductName;
	}
	public function setProductName($value){
		$this->_ProductName = $value;
	}
	
	
	public function getProductCode(){
		return $this->_ProductCode;
	}
	public function setProductCode($value){
		$this->_ProductCode = $value;
	}
	
	
	public function getProductImage(){
		return $this->_ProductImage;
	}
	public function setProductImage($value){
		$this->_ProductImage = $value;
	}

	
	public function getProductDescription(){
		return $this->_ProductDescription;
	}
	public function setProductDescription($value){
		$this->_ProductDescription = $value;
	}
	
	
	public function getProductPrice(){
		return $this->_ProductPrice;
	}
	public function setProductPrice($value){
		$this->_ProductPrice = $value;
	}
	
	
	public function getProductWeight(){
		return $this->_ProductWeight;
	}
	public function setProductWeight($value){
		$this->_ProductWeight = $value;
	}
	
	public function getProductWeightUnit(){
		return $this->_ProductWeightUnit;
	}
	public function setProductWeightUnit($value){
		$this->_ProductWeightUnit = $value;
	}
	
	
    public function __construct(){
    	$model = Mage::getModel("webportal/Master_Right_BidProducts");
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