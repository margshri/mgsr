<?php
class Yes_VO_FileUpload_FileUploadStatusVO extends Zend_Db_Table_Abstract
{
	
	public static $PENDING=1;
	public static $FAILED=2;
	public static $COMPLETED=3;
	
	protected $_db;
	protected $_name;
	protected $_primary = 'StatusID';
	
	public function __construct($tableName){
	
		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		$this->setDefaultAdapter($con);
		$this->_db = $con;
		$this->setTableName($tableName);
	}
	
	public function setTableName($tableName){
		$this->_name =$tableName;
		parent::_setupTableName();
	}
	
	public function getTableName(){
		return $this->_name;
	}
}