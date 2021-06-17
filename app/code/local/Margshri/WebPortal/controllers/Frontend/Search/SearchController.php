<?php 
class Margshri_WebPortal_Frontend_Search_SearchController extends Mage_Core_Controller_Front_Action {
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
	public function indexAction(){
		Mage::register('CurrentSearchKey', $this->getRequest()->getParam("SearchKey"));
    	$this->_initAction();
    	
    	Mage::register("CurrentTableCode", "apctwebsearch");
    	
    	$block = $this->getLayout()->createBlock('webportal/Frontend_Search_Info');
    	//$block->setTemplate('webportal/search/entropy.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
	}
    
}
