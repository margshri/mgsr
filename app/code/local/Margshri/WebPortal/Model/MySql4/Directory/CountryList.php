<?php
class Margshri_WebPortal_Model_Mysql4_Directory_CountryList extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctcountrylist', 'ID');
	}
	
	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$countryList = $this->getList();
		$countryOption = array();
	
		foreach($countryList as $list){
			$countryOption[$list["ID"]]= $list["Value"];
		}
		return 	$countryOption;
	}
}