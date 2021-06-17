<?php 

class Yes_CatalogUpload_Block_Price_Header extends Mage_Adminhtml_Block_Template
{
	public function getUploadUrl(){
		return $this->getUrl("*/*/priceUploadPage");
	}
	
	public function getGridHtml(){
		return $this->getChild("grid")->toHtml();
	}
}