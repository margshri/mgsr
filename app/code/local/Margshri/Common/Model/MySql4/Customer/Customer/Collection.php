<?php

class Margshri_Common_Model_Mysql4_Customer_Customer_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	protected function _construct()
    {
    	$this->_init('common/Customer_Customer');
    }
}