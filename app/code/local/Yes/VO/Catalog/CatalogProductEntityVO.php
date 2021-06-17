<?php

class Yes_VO_Catalog_CatalogProductEntityVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = 'entity_id';
	
	
	private $entity_id;
	private $entity_type_id;
	private $attribute_set_id;
	private $type_id;
	private $sku;
	private $has_options;
	private $required_options;
	private $created_at;
	private $updated_at;
	
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function setEntityId($entity_id)
	{
		$this->entity_id = $entity_id;
		$this->set('entity_id' , $entity_id);
	}
	public function getEntityId()
	{
		return $this->entity_id;
	}
	
	
	public function setEntityTypeId($entity_type_id)
	{
		$this->entity_type_id = $entity_type_id;
		$this->set('entity_type_id' , $entity_type_id);
	}
	public function getEntityTypeId()
	{
		return $this->entity_type_id;
	}
	
	
	public function setAttributeSetId($attribute_set_id)
	{
		$this->attribute_set_id = $attribute_set_id;
		$this->set('attribute_set_id' , $attribute_set_id);
	}
	public function getAttributeSetId()
	{
		return $this->attribute_set_id;
	}
	
	
	public function setTypeId($type_id)
	{
		$this->type_id = $type_id;
		$this->set('type_id' , $type_id);
	}
	public function getTypeId()
	{
		return $this->type_id;
	}
	
	
	public function setSku($sku)
	{
		$this->sku = $sku;
		$this->set('sku' , $sku);
	}
	public function getSku()
	{
		return $this->sku;
	}
	
	
	public function setHasOptions($has_options)
	{
		$this->has_options = $has_options;
		$this->set('has_options' , $has_options);
	}
	public function getHasOptions()
	{
		return $this->has_options;
	}
	
	
	public function setRequiredOptions($required_options)
	{
		$this->required_options = $required_options;
		$this->set('required_options' , $required_options);
	}
	public function getRequiredOptions()
	{
		return $this->required_options;
	}
	
	
	public function setCreatedAt($created_at)
	{
		$this->created_at = $created_at;
		$this->set('created_at' , $created_at);
	}
	public function getCreatedAt()
	{
		return $this->created_at;
	}
	
	public function setUpdatedAt($updated_at)
	{
		$this->updated_at = $updated_at;
		$this->set('updated_at' , $updated_at);
	}
	public function getUpdatedAt()
	{
		return $this->updated_at;
	}
	
	
	
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/productUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/catalogproductentity');
		
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($tableName);
	
		/*
		$this->value_id="value_id";
		$this->entity_type_id="entity_type_id";
		$this->attribute_id="attribute_id";
		$this->store_id="store_id";
		$this->entity_id="entity_id";
		$this->value="value";
		*/
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