<?php
class Margshri_Transport_Model_Mysql4_Master_Vahicale_VahicaleType extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Master_Vahicale_VahicaleTypeVO::$tableAlias, Margshri_Transport_VO_Master_Vahicale_VahicaleTypeVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getActiveList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("StatusID =?", Margshri_Common_VO_Status_StatusVO::$ACTIVE);
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	
	public function getActiveOptions(){
	    $dataObjs = $this->getActiveList();
	    $options = array();
	    
	    foreach($dataObjs as $dataObj){
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleTypeVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_VahicaleTypeVO */
	        $VO  = Margshri_Common_Helper_Utility::setVO($DTO, $dataObj);
	        $options[$VO->getID()]= $VO->getValue();
	    }
	    return 	$options;
	}
	 
}