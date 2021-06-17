<?php
class Margshri_WebPortal_Block_Frontend_Right_PlayBid extends Mage_Core_Block_Template{
		
	public $BID_REFRESH_TIME_IN_SEC = null; 
	
    public function __construct(){
    	parent::__construct();
    	
    	$systenConfigModel = Mage::getModel("webportal/Master_System_SystemConfig");
    	$this->BID_REFRESH_TIME_IN_SEC = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$BID_REFRESH_TIME_IN_SEC);
	}
	
	public function getBidVO(){
		return Mage::registry('CurrentBidVO');
	}
	
	
}
