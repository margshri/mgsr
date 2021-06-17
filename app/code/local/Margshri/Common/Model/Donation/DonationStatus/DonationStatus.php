<?php

class Margshri_Common_Model_Donation_DonationStatus_DonationStatus extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$modelName);
    }
}


