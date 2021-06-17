<?php
class Margshri_WebPortal_Model_Mysql4_Master_SubPage_Post1 extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebsubpagepost1', 'ID');
	}
	 
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getActiveRecordByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id)
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $type){
			/* @var $typeVO Margshri_WebPortal_VO_Master_SubPage_Post1VO */
			$typeDTO = new Margshri_WebPortal_VO_Master_SubPage_Post1VO();
			$typeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($typeDTO, $type);
			$option[$typeVO->getID()]= $typeVO->getValue();
		}
		return 	$option;
	}
}