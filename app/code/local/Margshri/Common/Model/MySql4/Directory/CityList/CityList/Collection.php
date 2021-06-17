<?php

class Margshri_Common_Model_Mysql4_Directory_CityList_CityList_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
    }
}