<?php
class Margshri_WebPortal_Model_Mysql4_Master_Right_BidStatus extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctwebbidstatus', 'ID');
	}
	
	
	public function getAll(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
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
		$lists = $this->getList();
		$option = array();
	
		foreach($lists as $list){
			$option[$list["ID"]]= $list["Value"];
		}
		return 	$option;
	}
	
	
	public function getActiveList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getActiveOptions(){
		$activeList = $this->getActiveList();
		$activeOption = array();
	
		foreach($activeList as $list){
			$activeOption[$list["ID"]]= $list["Value"];
		}
		return 	$activeOption;
	}
	   
}