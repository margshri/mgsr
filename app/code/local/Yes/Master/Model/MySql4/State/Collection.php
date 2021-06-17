<?php

class Yes_Master_Model_Mysql4_State_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    
    //public $size=0;
    protected function _construct()
    {
    	parent::_construct();
        $this->_init('yesmaster/state');
    }
 
}
