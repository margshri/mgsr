<?php
class Margshri_Common_Model_Mysql4_Master_BloodDonation_BloodGroup_BloodGroup extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Master_BloodDonation_BloodGroupVO::$tableAlias, Margshri_Common_VO_Master_BloodDonation_BloodGroupVO::$primaryKey);
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
	    $list = $this->getList();
	    $option = array();
	    
	    foreach($list as $row){
	        $DTO = new Margshri_Common_VO_Master_BloodDonation_BloodGroupVO();
	        /* @var $VO Margshri_Common_VO_Master_BloodDonation_BloodGroupVO */
	        $VO = Margshri_Common_Helper_Utility::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getValue();
	    }
	    return 	$option;
	}
}