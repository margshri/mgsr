<?php
class Margshri_WebPortal_Model_Mysql4_Center_Center extends Mage_Core_Model_Mysql4_Abstract{

	protected $tableName;
	
	protected function _construct()
	{
		$this->tableName = Mage::registry("CurrentTableName");
		$this->_init('webportal/'.$this->tableName, 'ID');
		//$this->_init('webportal/apcttablename', 'ID');
	}
	
	public function getList(){
	
		$locationVO = Mage::getSingleton('core/session')->getLocationVO();
		$where = '';
		if($locationVO['CountryID'] != null){
			$where .= ' CountryID = ' . $locationVO['CountryID'];
		}
		
		if($locationVO['StateID'] != null){
			$where .= ' AND StateID = ' . $locationVO['StateID'];
		}
		
		if($locationVO['DistrictID'] != null){
			$where .= ' AND DistrictID = ' . $locationVO['DistrictID'];
		}
		
		if($locationVO['CityID'] != null){
			$where .= ' AND CityID = ' . $locationVO['CityID'];
		}
		
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where($where);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$cityList = $this->getList();
		$cityOption = array();
	
		foreach($cityList as $list){
			$cityOption[$list["ID"]]= $list["Value"];
		}
		return 	$cityOption;
	}
}