<?php
class Margshri_WebPortal_Block_Backend_Registration_Registration_Header extends Mage_Adminhtml_Block_Template{
   
    public function __construct(){
        parent::__construct();
    }
    
	public function getGridHtml(){
    	return $this->getChild('grid')->toHtml();
    }
    
}
