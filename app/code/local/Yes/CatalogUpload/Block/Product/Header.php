<?php 

class Yes_CatalogUpload_Block_Product_Header extends Mage_Adminhtml_Block_Template
{
	public function getUploadUrl(){
		return $this->getUrl("*/*/fileUploadPage");
	}
	
	public function getGridHtml(){
		return $this->getChild("grid")->toHtml();
	}
}