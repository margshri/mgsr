<?php
class Margshri_WebPortal_Model_Mysql4_Directory_CityList extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctcitylist', 'ID');
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
		$cityList = $this->getList();
		$cityOption = array();
	
		foreach($cityList as $list){
			$cityOption[$list["ID"]]= array("Name"=>$list["Value"], "DistrictID"=>$list["DistrictID"] );
		}
		return 	$cityOption;
	}
	
	public function getActiveList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveOptions(){
		$cityList = $this->getActiveList();
		$cityOption = array();
	
		foreach($cityList as $list){
			$cityOption[$list["ID"]]= array("Name"=>$list["Value"], "DistrictID"=>$list["DistrictID"] );
		}
		return 	$cityOption;
	}
	
	
	public function getGridOptions(){
		$cityList= $this->getList();
		$cityOption = array();
		
		foreach($cityList as $list){
			$cityOption[$list["ID"]]= $list["Value"];
		}
		return 	$cityOption;
	}
	
	public function getByDistrictID($districtID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("DistrictID =?", $districtID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
}
