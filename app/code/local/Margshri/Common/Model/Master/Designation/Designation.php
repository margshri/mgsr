<?php

class Margshri_Common_Model_Master_Designation_Designation extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Master_Designation_DesignationVO::$modelName);
    }
}


