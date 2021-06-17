<?php 
class Margshri_WebPortal_Backend_Center_Content_Type1_Bank_ATMController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
	
	
    
    public function indexAction(){
    	$this->_initAction();
		$this->getLayout()->getBlock('head')->setTitle("Bank ATM");    	
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Center_Content_Type1_Bank_ATM');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$atmDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO();
    			// @var $atmVO Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO 
    			$atmVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($atmDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentATMVO', $atmVO);
    	return Mage::registry('CurrentATMVO');
    }
    
    public function editAction(){
    	$atmVO = $this->_init();
    	// @var $atmVO Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO 
    	
    	if($atmVO == null){
    		$atmVO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO();
    	}
    
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type1_Bank_ATM_Buttons')
    			->setTemplate('webportal/center/content/type1/bank/atm/info.phtml')
    			->setID($atmVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type1_Bank_ATM_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO();
    		
    		$ATMDataObj = json_decode($post["ATMDataObj"],true);
    		$ATMDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
    		$ATMVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($ATMDTO, $ATMDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Center_Content_Type1_Bank_ATM');
    		$response = $model->getResource()->saveDB($ATMVO);
    
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
    	$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray() ));
    	return;
    }
}