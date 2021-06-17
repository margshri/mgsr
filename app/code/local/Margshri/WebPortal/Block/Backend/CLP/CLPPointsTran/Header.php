<?php
class Margshri_WebPortal_Block_Backend_CLP_CLPPointsTran_Header extends Mage_Adminhtml_Block_Template{
   
	public function getGridHtml(){
    	return $this->getChild('grid')->toHtml();
    }
    
}
