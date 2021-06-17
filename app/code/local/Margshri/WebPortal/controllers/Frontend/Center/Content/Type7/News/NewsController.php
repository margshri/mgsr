<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type7_News_NewsController extends Mage_Core_Controller_Front_Action {
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	protected function _init(){
		 
		if($this->entityID !=null){
			$model   = Mage::getModel("webportal/Center_Content_Type7_News_News");
			$dataObj = $model->getResource()->getByID($this->entityID);
	
			if($dataObj !== false){
				$newsDTO = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();
				$newsVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newsDTO, $dataObj);
			}
		}
	
		Mage::register('CurrentNewsVO', $newsVO);
		return Mage::registry('CurrentNewsVO');
	}
	
	public function indexAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_News_News_Info');
		$block->setTemplate('webportal/center/content/type7/news/news/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function detailAction(){
		
		$this->entityID  = $this->getRequest()->getParam("ID");
		$this->_initAction();
		$newsVO = $this->_init();
    	
		Mage::register("CurrentTableCode", "apctwebnews");
		
    	if($newsVO == null){
    		$newsVO = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();  
    	}
    
    	$this->_initAction();
    	$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_News_News_Detail');
    	$block->setTemplate('webportal/center/content/type7/news/news/detail.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
	}
    
}
