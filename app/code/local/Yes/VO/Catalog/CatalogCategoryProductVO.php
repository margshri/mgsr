<?php

class Yes_VO_Catalog_CatalogCategoryProductVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = array('category_id','product_id');
	
	
	private $category_id;
	private $product_id;
	private $position;
	
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function setCategoryId($category_id)
	{
		$this->category_id = $category_id;
		$this->set('category_id' , $category_id);
	}
	public function getCategoryId()
	{
		return $this->category_id;
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
	
	public function setPosition($position)
	{
		$this->position = $position;
		$this->set('position' , $position);
	}
	public function getPosition()
	{
		return $this->position;
	}
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/productUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/catalogcategoryproduct');
		
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($tableName);
	
	}
	
	public function setTableName($tableName)
	{
		//$entityObj = new Mage_Core_Model_Mysql4_Abstract();
		//$this->$_name = $entityObj->getTable('Yeswms/goodsreceiptrectifylog');
		$this->_name =$tableName;
		parent::_setupTableName();
	}
	
	public function getTableName(){
		return $this->_name;
	}
	
	
	

        
}