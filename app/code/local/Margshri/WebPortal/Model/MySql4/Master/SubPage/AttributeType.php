<?php
class Margshri_WebPortal_Model_Mysql4_Master_SubPage_AttributeType extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebsubpageattributetype', 'ID');
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
	
		foreach($list as $type){
			/* @var $typeVO Margshri_WebPortal_VO_Master_SubPage_AttributeTypeVO */
			$typeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeTypeVO();
			$typeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($typeDTO, $type);
			$option[$typeVO->getID()]= $typeVO->getValue();
		}
		return 	$option;
	}
}