<?php
class Margshri_MedicalCamp_Model_Mysql4_Registration_BloodGroupList extends Mage_Core_Model_Mysql4_Abstract{

	protected function _construct()
	{
		$this->_init('madicalcamp/madicalcampbloodgrouplist', 'ID');
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
	
		foreach($list as $row){
			$DTO = new Margshri_MedicalCamp_VO_BloodGroupListVO();
			$VO  = Margshri_MedicalCamp_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= $VO->getValue();
		}
		return 	$option;
	}
	
	 
}