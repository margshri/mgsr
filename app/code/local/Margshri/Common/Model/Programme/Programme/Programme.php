<?php

class Margshri_Common_Model_Programme_Programme_Programme extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$modelName);
    }
}


