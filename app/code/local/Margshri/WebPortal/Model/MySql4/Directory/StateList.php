<?php
class Margshri_WebPortal_Model_Mysql4_Directory_StateList extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctstatelist', 'ID');
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
		$stateList = $this->getList();
		$stateOption = array();
	
		foreach($stateList as $list){
			$stateOption[$list["ID"]]= array("Name"=>$list["Value"], "CountryID"=>$list["CountryID"] );
		}
		return 	$stateOption;
	}
	
	public function getGridOptions(){
		$stateList= $this->getList();
		$stateOption = array();
		
		foreach($stateList as $list){
			$stateOption[$list["ID"]]= $list["Value"];
		}
		return 	$stateOption;
	}
	
	public function getActiveList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE );
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveOptions(){
		$stateList = $this->getActiveList();
		$stateOption = array();
	
		foreach($stateList as $list){
			$stateOption[$list["ID"]]= array("Name"=>$list["Value"], "CountryID"=>$list["CountryID"] );
		}
		return 	$stateOption;
	}
	
	
}
