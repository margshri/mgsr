<?php

class Margshri_Common_Model_Society_Society_Society extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Society_Society_SocietyVO::$modelName);
    }
}


