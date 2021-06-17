<?php

class Yes_VO_Core_CoreWebsiteVO extends Zend_Db_Table_Abstract
{
	protected $_db;
	protected $_name;
	protected $_primary = 'website_id';
	
	private $website_id;
	private $code;
	
	protected $_data = array();
	
	protected function set($name, $value)
	{
		$this->_data[$name]=$value;
	
	}
	public function getDataArray(){
		return $this->_data;
	}
	
	
	public function setWebsiteCode($code)
	{
		$this->code = $code;
		$this->set('code' , $code);
	}
	public function getWebsiteCode()
	{
		return $this->code;
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
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($this->getTableName('yescatalogupload/corewebsite'));
	
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