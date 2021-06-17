<?php

class Yes_VO_Core_CoreStoreVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = 'store_id';
	
	
	private $store_id;
	private $code;
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function setStoreId($store_id)
	{
		$this->store_id = $store_id;
		$this->set('store_id' , $store_id);
	}
	public function getStoreId()
	{
		return $this->store_id;
	}
	
	
	public function setStoreCode($code)
	{
		$this->code = $code;
		$this->set('code' , $code);
	}
	public function getStoreCode()
	{
		return $this->code;
	}
	
	
	public function __construct()
	{
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($this->getTableName('yescatalogupload/corestore'));
	
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