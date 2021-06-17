<?php

class Margshri_Common_Model_Directory_CityList_CityList extends Mage_Core_Model_Abstract  {
	/**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
    }
}


