<?php

class Yes_VO_Catalog_CatalogProductWebsiteVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = array('product_id', 'website_id');
	
	
	private $product_id;
	private $website_id;
	
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function setProductId($product_id)
	{
		$this->product_id = $product_id;
		$this->set('product_id' , $product_id);
	}
	public function getProductId()
	{
		return $this->product_id;
	}
	
	
	public function setWebsiteId($website_id)
	{
		$this->website_id = $website_id;
		$this->set('website_id' , $website_id);
	}
	public function getWebsiteId()
	{
		return $this->website_id;
	}
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/productUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/catalogproductwebsite');
		
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