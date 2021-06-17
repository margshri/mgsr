<?php
class Margshri_WebPortal_Model_Mysql4_Directory_DistrictList extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctdistrictlist', 'ID');
	}

	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
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
		$districtList = $this->getList();
		$districtOption = array();
	
		foreach($districtList as $list){
			$districtOption[$list["ID"]]= array("Name"=>$list["Value"], "StateID"=>$list["StateID"] );
		}
		return 	$districtOption;
	}
	
	public function getActiveList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE );;
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveOptions(){
		$districtList = $this->getActiveList();
		$districtOption = array();
	
		foreach($districtList as $list){
			$districtOption[$list["ID"]]= array("Name"=>$list["Value"], "StateID"=>$list["StateID"] );
		}
		return 	$districtOption;
	}
	
	public function getGridOptions(){
		$districtList = $this->getList();
		$districtOption = array();
	
		foreach($districtList as $list){
			$districtOption[$list["ID"]]= $list["Value"];
		}
		return 	$districtOption;
	}
	
	public function getByStateID($stateID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StateID =?", $stateID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
}
