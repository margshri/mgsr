<?php

class Margshri_Common_Model_Mysql4_Society_Society_Society_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Society_Society_SocietyVO::$modelName);
    }
}