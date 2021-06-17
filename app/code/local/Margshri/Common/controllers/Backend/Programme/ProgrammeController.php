<?php 
class Margshri_Common_Backend_Programme_ProgrammeController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_Programme_Programme_Grid';
	private $formBlock ='common/Backend_Programme_Programme_Form';
	
	
	protected function _init(){
	    $programmeID = $this->getRequest()->getParam('ID');
	    $programmeVO = new Margshri_Common_VO_Programme_Programme_ProgrammeVO();
	    if($programmeID != null){
	        $programmeModel = Mage::getModel(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$modelName);
	        $programmeDataObj = $programmeModel->getResource()->getByID($programmeID);
	        if($programmeDataObj !== false){
	            $programmeDTO = new Margshri_Common_VO_Programme_Programme_ProgrammeVO();
	            $programmeVO = Margshri_Common_Helper_Utility::callInstanceFunction($programmeDTO, $programmeDataObj);
			}
		}
		Mage::register('CurrentProgrammeVO', $programmeVO);
		return $programmeVO;
	}
	
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	} 
	
	public function editAction(){
		/* @var $programmeVO Margshri_Common_VO_Programme_Programme_ProgrammeVO */ 
	    $programmeVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setProgrammeID($programmeVO->getID())
		);
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}	

	public function saveAction(){
	    
    	try {
    	    $responseVO = new Margshri_Common_VO_ResponseVO();
    	    $isTransactionStart = false;
    	    
    		$post = $this->getRequest()->getPost();
    		if (empty($post)) {
    			Mage::throwException("Invalid Form Data.");
    		}
    		
    		$programmeDataObj = json_decode($post["ProgrammeDataObj"],true);
    		if($programmeDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$programmeDTO = new Margshri_Common_VO_Programme_Programme_ProgrammeVO();
    		/* @var $programmeVO Margshri_Common_VO_Programme_Programme_ProgrammeVO */
    		$programmeVO = Margshri_Common_Helper_Utility::callInstanceFunction($programmeDTO, $programmeDataObj);
    		
    		if($programmeVO->getProgrammeDate() == null || $programmeVO->getProgrammeDate() == "" || $programmeVO->getProgrammeDate() == "0000-00-00 00:00:00"){
    		    Mage::throwException("Please Select Programme Date.");
    		}
    		
    		$programmeYear = date("Y", strtotime($programmeVO->getProgrammeDate()));
    		$programmeVO->setProgrammeYear($programmeYear);
    		
    		$adapter = $programmeVO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		$programmeModel = Mage::getModel(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$modelName);
    		$responseVO = $programmeModel->getResource()->saveDB($programmeVO, $responseVO);
    		
    		if($responseVO->getErrorMessage() != null){
    			Mage::throwException($responseVO->getErrorMessage());
    		}
    		
    		$adapter->commit();
    	
    	} catch (Exception $e) {
    		if($isTransactionStart == true){
    			$adapter->rollBack();
    		}
    		$responseVO->setErrorMessage($e->getMessage());
    	}
    	$this->getResponse()->setBody(Margshri_Common_Helper_Utility::jsonEncode($responseVO->getResponseData()));
    	return;
    
    }	
	
}// end class
