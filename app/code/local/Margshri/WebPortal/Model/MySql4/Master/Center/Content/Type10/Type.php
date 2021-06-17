<?php
class Margshri_WebPortal_Model_Mysql4_Master_Center_Content_Type10_Type extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->setInIt();
	}
	
	public function setInIt($tableCode=null){
		$this->_init('webportal/'.$tableCode.'type' , 'ID');
	}
	
	public function getByCode($tableCode){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("Code =?", $tableCode);
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
	
	public function getOptions($tableCode){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $row){
			$DTO = new Margshri_WebPortal_VO_Center_Content_Type10_Type10VO($tableCode);
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= $VO->getValue();
		}
		return 	$option;
	}
	
}