<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type7_Achivement_Achivement_Detail extends Mage_Core_Block_Template{
	public function __construct(){
		parent::__construct();
	}
	
	public function getAchivementVO(){
		return Mage::registry('CurrentAchivementVO');
	}

	
}