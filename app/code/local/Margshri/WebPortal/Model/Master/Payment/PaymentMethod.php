<?php

class Margshri_WebPortal_Model_Master_Payment_PaymentMethod extends Mage_Core_Model_Abstract  {
	/**
     * Initialize resource model
     */
    protected function _construct()
    {
    	parent::_construct();
        $this->_init('webportal/Master_Payment_PaymentMethod');
    }
}


