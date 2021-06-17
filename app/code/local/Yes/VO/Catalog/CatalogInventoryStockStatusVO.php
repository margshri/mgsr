<?php

class Yes_VO_Catalog_CatalogInventoryStockStatusVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = array('product_id','website_id','stock_id');
	
	
	public  static $STOCK_ID = 1;
	public  static $STOCK_STATUS = 1;
	
	private $product_id;
	private $website_id;
	private $stock_id;
	private $qty;
	private $stock_status;
	
	
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
	
	
	
	public function setStockId($stock_id)
	{
		$this->stock_id = $stock_id;
		$this->set('stock_id' , $stock_id);
	}
	public function getStockId()
	{
		return $this->stock_id;
	}
	
	public function setQty($qty)
	{
		$this->qty = $qty;
		$this->set('qty' , $qty);
	}
	public function getQty()
	{
		return $this->qty;
	}
	
	
	public function setStockStatus($stock_status)
	{
		$this->stock_status = $stock_status;
		$this->set('stock_status' , $stock_status);
	}
	public function getStockStatus()
	{
		return $this->stock_status;
	}
	
	
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/productUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/cataloginventorystockstatus');
		
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