<?php
class Margshri_WebPortal_Block_Backend_FileUpload_ImageUpload_Advertisement_Header extends Mage_Adminhtml_Block_Template{
	
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
