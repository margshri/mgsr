<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type11_Header extends Mage_Adminhtml_Block_Template{
	
    /**
     * Get URL of adding new record
     */
    public function getAddNewUrl(){
    	return $this->getUrl('*/*/edit', array('TableCode'=>$this->getTableCode()));
    }

    /**
     * Get grid HTML
     */
    public function getGridHtml(){
    	return $this->getChild('grid')->toHtml();
    }
}
