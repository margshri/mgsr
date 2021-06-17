<?php 
class Margshri_WebPortal_Backend_Center_Content_Type10_Recruitment_RecruitmentController extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
	
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type10_Recruitment_Recruitment");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$recruitmentDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO(); 
    			$recruitmentVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($recruitmentDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentRecruitmentVO', $recruitmentVO);
    	return Mage::registry('CurrentRecruitmentVO');
    }
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("Recruitment");
    	$headerBlock = $this->getLayout()->createBlock("webportal/Backend_Center_Content_Type10_Recruitment_Recruitment_Header");
    	$headerBlock->setTemplate('webportal/center/content/type10/recruitment/recruitment/header.phtml');
    	 
    	$gridBlock =$this->getLayout()->createBlock("webportal/Backend_Center_Content_Type10_Recruitment_Recruitment_Grid");
    	$headerBlock->setChild("grid", $gridBlock);
    	 
    	$this->getLayout()->getBlock('content')->append($headerBlock);
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$recruitmentVO = $this->_init();
    	
    	if($recruitmentVO == null){
    		$recruitmentVO = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type10_Recruitment_Recruitment_Buttons')
    			->setTemplate('webportal/center/content/type10/recruitment/recruitment/info.phtml')
    			->setID($recruitmentVO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type10_Recruitment_Recruitment_Grid');
    	$this->getResponse()->setBody($gridBlock->toHtml());
    }
    
    public function saveAction(){
    	try {
    		
    		$post = $this->getRequest()->getPost();
    		
    		$errorMsg = array();
    		$response = array();
    		
    		if (empty($post)) {
    			Mage::throwException($this->__('Invalid form data.'));
    		}
    
    		$recruitmentDataObj = json_decode($post["RecruitmentDataObj"],true);
    		
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO();
    		
    		$recruitmentDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO();
    		/* @var $recruitmentVO  Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO */
    		$recruitmentVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($recruitmentDTO, $recruitmentDataObj);

    		if($recruitmentVO->getStateID() == null || $recruitmentVO->getStateID() == ''){
    			$recruitmentVO->setStateID(null);
    		}
    		
    		if($recruitmentVO->getDistrictID() == null || $recruitmentVO->getDistrictID() == ''){
    			$recruitmentVO->setDistrictID(null);
    		}
    		
    		if($recruitmentVO->getCityID() == null || $recruitmentVO->getCityID() == ''){
    			$recruitmentVO->setCityID(null);
    		}
    		
    		
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type10_Recruitment_Recruitment");
    		$response = $model->getResource()->saveDB($recruitmentVO);
    		
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			$responseVO->setSuccessMessage($response['message']);
    		}else{
    			$adapter->getAdapter()->rollBack();
    			$responseVO->setErrorMessage($response['message']);
    		}
    
    	} catch (Exception $e) {
    		$adapter->getAdapter()->rollBack();
    		$responseVO->setErrorMessage(array($e->getMessage()));
    	}
    	$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
    	return;
    
    }
    
}
