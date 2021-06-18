<?php
class Margshri_Transport_Block_Backend_Master_Vahicale_Driver_Header extends Mage_Adminhtml_Block_Template{
	
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
