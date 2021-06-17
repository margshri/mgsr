<?php
class Margshri_Common_Block_Frontend_Donor_Donor_DonorList extends Mage_Core_Block_Template{
	
    
    public function __construct(){
        parent::__construct();
    }

    
    public function getHeaderHtml(){
        // return $this->getChild('Registration_Header')->toHtml();
    }
    
    
    public function getFooterHtml(){
        // return $this->getChild('Registration_Footer')->toHtml();
    }
    
    public function getDonationVOs(){
        return Mage::registry("CurrentDonationVOs");
    }
    
}
