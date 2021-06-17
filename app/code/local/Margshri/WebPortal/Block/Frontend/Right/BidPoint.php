<?php
class Margshri_WebPortal_Block_Frontend_Right_BidPoint extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    }

    
    public function getTableCode(){
    	return Mage::registry("CurrentTableCode");
    }
    
}
