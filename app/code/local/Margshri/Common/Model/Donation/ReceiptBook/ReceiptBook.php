<?php

class Margshri_Common_Model_Donation_ReceiptBook_ReceiptBook extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO::$modelName);
    }
}


