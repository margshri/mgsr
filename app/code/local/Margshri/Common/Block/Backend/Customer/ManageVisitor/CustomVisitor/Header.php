<?php
class Margshri_Common_Block_Backend_Customer_ManageVisitor_CustomVisitor_Header extends Mage_Adminhtml_Block_Template{
    
	public function __construct(){
		parent::__construct();
	}
    
    /**
     * Get grid HTML
     */
    public function getGridHtml(){
    	return $this->getChild('grid')->toHtml();
    }
}
