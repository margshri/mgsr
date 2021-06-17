<?php
class Margshri_Common_Model_Mysql4_Donation_DonationType_DonationType extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$tableAlias, Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$primaryKey);
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
	        $DTO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
	        /* @var $VO Margshri_Common_VO_Donation_DonationType_DonationTypeVO */ 
	        $VO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getTypeName();
	    }
	    return 	$option;
	}
	
}