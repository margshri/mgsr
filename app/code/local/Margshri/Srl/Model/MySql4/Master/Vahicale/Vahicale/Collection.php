<?php

class Margshri_Transport_Model_Mysql4_Master_Vahicale_Vahicale_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
    }
}