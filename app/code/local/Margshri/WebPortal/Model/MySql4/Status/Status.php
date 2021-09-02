<?php
class Margshri_WebPortal_Model_Mysql4_Status_Status extends Mage_Core_Model_Mysql4_Abstract{

	protected function _construct()
	{
		$this->_init('webportal/mgsrstatus', 'ID');
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
	
		foreach($list as $status){
			/* @var $statusVO Margshri_WebPortal_VO_StatusVO */
			$statusDTO = new Margshri_WebPortal_VO_StatusVO();
			$statusVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($statusDTO, $status);
			$option[$statusVO->getID()]= $statusVO->getValue();
		}
		return 	$option;
	}
}