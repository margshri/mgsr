<?php 
class Margshri_Common_Backend_Society_SocietyController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_Society_Society_Grid';
	private $formBlock ='common/Backend_Society_Society_Form';
	
	
	protected function _init(){
	    $societyID = $this->getRequest()->getParam('ID');
	    $societyVO = new Margshri_Common_VO_Society_Society_SocietyVO();
	    if($societyID != null){
	        $societyModel = Mage::getModel(Margshri_Common_VO_Society_Society_SocietyVO::$modelName);
	        $societyDataObj = $societyModel->getResource()->getByID($societyID);
	        if($societyDataObj !== false){
	            $societyDTO = new Margshri_Common_VO_Society_Society_SocietyVO();
	            $societyVO = Margshri_Common_Helper_Utility::callInstanceFunction($societyDTO, $societyDataObj);
			}
		}
		Mage::register('CurrentSocietyVO', $societyVO);
		return $societyVO;
	}
	
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	} 
	
	public function editAction(){
		/* @var $societyVO Margshri_Common_VO_Society_Society_SocietyVO */ 
	    $societyVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setSocietyID($societyVO->getID())
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
    		
    		$societyDataObj = json_decode($post["SocietyDataObj"],true);
    		if($societyDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$societyDTO = new Margshri_Common_VO_Society_Society_SocietyVO();
    		/* @var $societyVO Margshri_Common_VO_Society_Society_SocietyVO */
    		$societyVO = Margshri_Common_Helper_Utility::callInstanceFunction($societyDTO, $societyDataObj);
    		
    		$adapter = $societyVO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		$societyModel = Mage::getModel(Margshri_Common_VO_Society_Society_SocietyVO::$modelName);
    		$responseVO = $societyModel->getResource()->saveDB($societyVO, $responseVO);
    		
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
