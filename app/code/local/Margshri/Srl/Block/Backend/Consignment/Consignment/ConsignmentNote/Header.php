<?php
class Margshri_Transport_Block_Backend_Consignment_Consignment_ConsignmentNote_Header extends Mage_Adminhtml_Block_Template{
	
    /**
     * Get URL of adding new record
     */
    public function getAddNewUrl(){
    	return $this->getUrl('*/*/edit');
    }

    /**
     * Get grid HTML
     */
    public function getGridHtml(){
    	return $this->getChild('grid')->toHtml();
    }
}
