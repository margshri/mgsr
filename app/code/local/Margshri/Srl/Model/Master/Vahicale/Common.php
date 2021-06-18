<?php

class Margshri_Transport_Model_Master_Vahicale_Common extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Transport_VO_Master_Vahicale_CommonVO::$modelName);
    }
}


