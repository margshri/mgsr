<?php

class Margshri_Transport_Model_Mysql4_Consignment_Consignment_ConsignmentNote_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO::$modelName);
    }
}