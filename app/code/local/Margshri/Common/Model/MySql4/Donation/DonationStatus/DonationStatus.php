<?php
class Margshri_Common_Model_Mysql4_Donation_DonationStatus_DonationStatus extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$tableAlias, Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$primaryKey);
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
	        $DTO = new Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO();
	        /* @var $VO Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO */ 
	        $VO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getStatusName();
	    }
	    return 	$option;
	}
	
}