<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type7_Achivement_AchivementController extends Mage_Core_Controller_Front_Action {
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	protected function _init(){
		 
		if($this->entityID !=null){
			$model   = Mage::getModel("webportal/Center_Content_Type7_Achivement_Achivement");
			$dataObj = $model->getResource()->getByID($this->entityID);
	
			if($dataObj !== false){
				$achivementDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();
				$achivementVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($achivementDTO, $dataObj);
			}
		}
	
		Mage::register('CurrentAchivementVO', $achivementVO);
		return Mage::registry('CurrentAchivementVO');
	}
	
	public function indexAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Achivement_Achivement_Info');
		$block->setTemplate('webportal/center/content/type7/achivement/achivement/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function detailAction(){
		
		$this->entityID  = $this->getRequest()->getParam("ID");
		$this->_initAction();
		$achivementVO = $this->_init();
    	
    	if($achivementVO == null){
    		$achivementVO = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();  
    	}
    
    	$this->_initAction();
    	$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Achivement_Achivement_Detail');
    	$block->setTemplate('webportal/center/content/type7/achivement/achivement/detail.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
	}
    
}
