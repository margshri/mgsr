<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type5_Viewer_ViewerStatus extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebviewerstatus', 'ID');
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
			/* @var $statusVO Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerStatusVO */
			$statusDTO = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerStatusVO();
			$statusVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($statusDTO, $status);
			$option[$statusVO->getID()]= $statusVO->getValue();
		}
		return 	$option;
	}
	
}