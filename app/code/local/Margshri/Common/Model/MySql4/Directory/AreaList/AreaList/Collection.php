<?php

class Margshri_Common_Model_Mysql4_Directory_AreaList_AreaList_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Directory_AreaList_AreaListVO::$modelName);
    }
}