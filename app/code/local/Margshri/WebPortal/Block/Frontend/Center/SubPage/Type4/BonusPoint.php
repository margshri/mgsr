<?php
class Margshri_WebPortal_Block_Frontend_Center_SubPage_Type4_BonusPoint extends Mage_Core_Block_Template{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getSubPageArray(){
		return Mage::registry("CurrentSubPageVOs");
	}
	
	public function getPageTitle(){
		return Mage::registry("CurrentPageTitle");
	}
}
