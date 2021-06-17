<?php

class Yes_VO_Catalog_CatalogProductEntityVarcharVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = 'value_id';
	
	
	private $value_id;
	private $entity_type_id;
	private $attribute_id;
	private $store_id;
	private $entity_id;
	private $value;
	
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
	
	
	public function setEntityTypeId($entityTypeId)
	{
		$this->entity_type_id = $entityTypeId;
		$this->set('entity_type_id' , $entityTypeId);
	}
	public function getEntityTypeId()
	{
		return $this->entity_type_id;
	}
	
	
	public function setAttributeId($attributeId)
	{
		$this->attribute_id = $attributeId;
		$this->set('attribute_id' , $attributeId);
	}
	public function getAttributeId()
	{
		return $this->attribute_id;
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
	
	
	public function setEntityId($entityId)
	{
		$this->entity_id = $entityId;
		$this->set('entity_id' , $entityId);
	}
	public function getEntityId()
	{
		return $this->entity_id;
	}
	
	
	public function setValue($value)
	{
		$this->value = $value;
		$this->set('value' , $value);
	}
	public function getValue()
	{
		return $this->value;
	}
	
	
	
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/productUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/catalogproductentityvarchar'); 
		
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