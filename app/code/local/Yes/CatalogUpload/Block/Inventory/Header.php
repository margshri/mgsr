<?php 

class Yes_CatalogUpload_Block_Inventory_Header extends Mage_Adminhtml_Block_Template
{
	public function getUploadUrl(){
		return $this->getUrl("*/*/inventoryUploadPage");
	}
	
	public function getGridHtml(){
		return $this->getChild("grid")->toHtml();
	}
}