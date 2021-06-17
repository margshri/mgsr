<?php
class Margshri_Common_Block_Frontend_Customer_Registration_Step2 extends Mage_Customer_Block_Form_Register{
	
    public function __construct(){
        parent::__construct();
    }
    
    
    public function getCurrentRegisterMobileNumber(){
        return Mage::getSingleton('core/session')->getCurrentRegisterMobileNumber();
    }
    
}
