<?php

class Margshri_Common_Model_Donation_Donation_Donation extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
    }
}


