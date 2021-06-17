<?php
class Margshri_WebPortal_Block_Frontend_HomePage_HomePage extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    	$newLocationVO = array("CountryID"=>1,"StateID"=>null,"DistrictID"=>null,"CityID"=>null);
    	Mage::getSingleton('core/session')->setLocationVO($newLocationVO);
    }
    
    protected function _prepareLayout(){
    	parent::_prepareLayout();
    	$this->setChild('MiddleBar', $this->getLayout()->createBlock('webportal/Frontend_Center_Content_MiddleBar') );
    	$this->setChild('ContentBar', $this->getLayout()->createBlock('webportal/Frontend_Center_Content_ContentBar') );
    	return $this;
    }
    
    public function getMiddleBar(){
    	return $this->getChildHtml('MiddleBar');
    }
    
    public function getContentBar(){
    	return $this->getChildHtml('ContentBar');
    }

}
