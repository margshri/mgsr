<?php
class Margshri_WebPortal_Model_Mysql4_Master_Table_DynamicColumn extends Mage_Core_Model_Mysql4_Abstract{

	protected function _construct()
	{
		$this->_init('webportal/apctwebdynamiccolumn', 'ID');
	}
	
	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->order("Value ASC");
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $row){
			$DTO = new Margshri_WebPortal_VO_Master_Table_DynamicColumnVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= array("Value"=> $VO->getValue());
		}
		return 	$option;
	}
	 
}