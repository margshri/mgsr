<?php
class Dakiya_Model_Mysql4_Master_Email_EmailEntity extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct(){
		$this->_init('dakiya/localemailentity', 'EntityID');
	}
	
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("EntityID=?", $id);
		$rowSet =  $read->fetchRow($select);
	 	return $rowSet;
	}
	
	
	public function getAuthorisedActiveRecordByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("EntityID=?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
}