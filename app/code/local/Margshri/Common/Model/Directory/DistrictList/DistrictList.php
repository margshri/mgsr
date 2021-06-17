<?php

class Margshri_Common_Model_Directory_DistrictList_DistrictList extends Mage_Core_Model_Abstract  {
	/**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Directory_DistrictList_DistrictListVO::$modelName);
    }
}


