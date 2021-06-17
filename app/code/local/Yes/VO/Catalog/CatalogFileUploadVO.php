<?php

class Yes_VO_Catalog_CatalogFileUploadVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = 'CatalogFileUploadID';
	
	private $CatalogFileUploadID;
	private $FileUploadID;
	private $SKUEntityID;
	
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function setCatalogFileUploadID($CatalogFileUploadID)
	{
		$this->CatalogFileUploadID = $CatalogFileUploadID;
		$this->set('CatalogFileUploadID' , $CatalogFileUploadID);
	}
	public function getCatalogFileUploadID()
	{
		return $this->CatalogFileUploadID;
	}
	
	
	public function setFileUploadID($FileUploadID)
	{
		$this->FileUploadID = $FileUploadID;
		$this->set('FileUploadID' , $FileUploadID);
	}
	public function getFileUploadID()
	{
		return $this->FileUploadID;
	}
	
	public function setSKUEntityID($SKUEntityID)
	{
		$this->SKUEntityID = $SKUEntityID;
		$this->set('SKUEntityID' , $SKUEntityID);
	}
	public function getSKUEntityID()
	{
		return $this->SKUEntityID;
	}
	
	
	public function __construct()
	{
		$model = Mage::getModel("yescatalogupload/productUpload");
		$tableName = $model->getResource()->getTable('yescatalogupload/catalogfileupload');
		
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