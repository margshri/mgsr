<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type2_Professional_ProfessionalController extends Mage_Core_Controller_Front_Action {
	
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
	public function profileAction(){
		$this->loadLayout();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type2_Professional_Professional_Profile');
		$block->setTemplate('webportal/center/content/type2/professional/professional/profile.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
    
}
