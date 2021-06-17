<?php
class Margshri_Common_Model_Mysql4_Master_Designation_Designation extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Master_Designation_DesignationVO::$tableAlias, Margshri_Common_VO_Master_Designation_DesignationVO::$primaryKey);
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
	        $DTO = new Margshri_Common_VO_Master_Designation_DesignationVO();
	        /* @var $VO Margshri_Common_VO_Master_Designation_DesignationVO */ 
	        $VO = Margshri_Common_Helper_Utility::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getValue();
	    }
	    return 	$option;
	}
	
}