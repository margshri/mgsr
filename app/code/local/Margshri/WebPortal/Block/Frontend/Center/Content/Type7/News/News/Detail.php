<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type7_News_News_Detail extends Mage_Core_Block_Template{
	public function __construct(){
		parent::__construct();
	}
	
	public function getNewsVO(){
		return Mage::registry('CurrentNewsVO');
	}

	
}