<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type7_Event_EventController extends Mage_Core_Controller_Front_Action {
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	protected function _init(){
		 
		if($this->entityID !=null){
			$model   = Mage::getModel("webportal/Center_Content_Type7_Event_Event");
			$dataObj = $model->getResource()->getByID($this->entityID);
	
			if($dataObj !== false){
				$eventDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
				$eventVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($eventDTO, $dataObj);
			}
		}
	
		Mage::register('CurrentEventVO', $eventVO);
		return Mage::registry('CurrentEventVO');
	}
	
	public function indexAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Event_Event_Info');
		$block->setTemplate('webportal/center/content/type7/event/event/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function detailAction(){
		
		$this->entityID  = $this->getRequest()->getParam("ID");
		$this->_initAction();
		$eventVO = $this->_init();
    	
    	if($eventVO == null){
    		$eventVO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();  
    	}
    
    	$this->_initAction();
    	$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Event_Event_Detail');
    	$block->setTemplate('webportal/center/content/type7/event/event/detail.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
	}
    
}
