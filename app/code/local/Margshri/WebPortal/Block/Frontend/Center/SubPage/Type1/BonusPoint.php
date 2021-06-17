<?php
class Margshri_WebPortal_Block_Frontend_Center_SubPage_Type1_BonusPoint extends Mage_Core_Block_Template{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getSubPageArray(){
		return Mage::registry("CurrentSubPageVOs");
	}
	
	public function getPageTitle(){
		return Mage::registry("CurrentPageTitle");
	}
	
	public function getPersonDetailHTML($attributeTypeID, $attributeCode, $subPageVO=null){
		
		$html = '';
		if($subPageVO == null){
			$subPageVO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
		}
			
		$html .=  "<div class='customer-image' >
				   	<img alt='".$attributeCode."' src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $subPageVO->getValue()."' class='customer-image' >
				   </div>	
				   <div class='customer-detail-with-image' >";
		

    	if($subPageVO->getPersonName() != null){
    		$html .= "<span>". $subPageVO->getPersonName() . "</span><br />";
    	}
        
    	if($subPageVO->getPost1Name() != null){
    		$html .= "<span>". $subPageVO->getPost1Name() . "</span><br />";
    	}
    	
    	if($subPageVO->getPost2Name() != null){
    		$html .= "<span>". $subPageVO->getPost2Name() . "</span><br />";
    	}
        					
    	$html .= "</div>";
    	
    	return $html;
	}
	
}
