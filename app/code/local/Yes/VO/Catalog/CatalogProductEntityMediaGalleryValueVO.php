<?php

class Yes_VO_Catalog_CatalogProductEntityMediaGalleryValueVO extends Zend_Db_Table_Abstract
{
	
	protected $_db;
	protected $_name;
	protected $_primary = 'value_id';
	
	public static $LABEL = 'Product Image';
	public static $POSITION = 0;
	public static $DISABLED = 0;
	
	
	
	private $value_id;
	private $store_id;
	private $label;
	private $position;
	private $disabled;
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	
	public function setValueId($valueId)
	{
		$this->value_id = $valueId;
		$this->set('value_id' , $valueId);
	}
	public function getValueId()
	{
		return $this->value_id;
	}
	
	
	public function setStoreId($storeId)
	{
		$this->store_id = $storeId;
		$this->set('store_id' , $storeId);
	}
	public function getStoreId()
	{
		return $this->store_id;
	}
	
	public function setLabel($label)
	{
		$this->label = $label;
		$this->set('label' , $label);
	}
	public function getLabel()
	{
		return $this->label;
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
	
	public function setDisabled($disabled)
	{
		$this->disabled = $disabled;
		$this->set('disabled' , $disabled);
	}
	public function getDisabled()
	{
		return $this->disabled;
	}
	
	
	
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/productUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/catalogproductentitymediagalleryvalue');
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