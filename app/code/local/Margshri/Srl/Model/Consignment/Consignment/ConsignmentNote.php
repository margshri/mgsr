<?php

class Margshri_Transport_Model_Consignment_Consignment_ConsignmentNote extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO::$modelName);
    }
}


