<?php
class Margshri_Common_Model_Mysql4_Customer_CustomerStatus extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('common/apctcustomerstatus', 'ID');
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
	        $DTO = new Margshri_Common_VO_Customer_CustomerStatusVO();
	        $VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getValue();
	    }
	    return 	$option;
	}
	
}