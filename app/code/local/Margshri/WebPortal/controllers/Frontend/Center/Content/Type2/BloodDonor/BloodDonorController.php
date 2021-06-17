<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type2_BloodDonor_BloodDonorController extends Mage_Core_Controller_Front_Action {
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
    protected function _init(){
    	
    	$VO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
    	
    	if($this->entityID !=null){
    		$model = Mage::getModel("webportal/Center_Content_Type2_BloodDonor_BloodDonor");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$DTO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO(); 
    			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		}
    	}else{
    		$VO->setCustomerID($this->getRequest()->getParam("CustomerID"));
    	}

    	$VO->setFirstName($this->getRequest()->getParam("FirstName"));
    	$VO->setLastName($this->getRequest()->getParam("LastName"));
    	
    		
    	Mage::register('CurrentBloodDonorVO', $VO);
    	return Mage::registry('CurrentBloodDonorVO');
    }
    
    public function customerFormAction(){
    	
    	if(Mage::getSingleton('customer/session')->isLoggedIn()){
    		
    		$customerDataObj = Mage::getSingleton('customer/session')->getCustomer();
    		$customerID = $customerDataObj->getId();
    		
    		$VO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
    		
    		if($customerID != null){
    			$model = Mage::getModel("webportal/Center_Content_Type2_BloodDonor_BloodDonor");
    			$dataObj = $model->getResource()->getByCustomerID($customerID);
    			if($dataObj !== false){
    				$DTO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
    				$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    			}
    		}
    		
    		Mage::register('CurrentBloodDonorVO', $VO);
    	}
    	
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("Blood Donor");
    	$this->renderLayout();
    }
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("Blood Donor");
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$VO = $this->_init();
    	
    	if($VO == null){
    		$VO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type2_BloodDonor_BloodDonor_Buttons')
    			->setTemplate('webportal/center/content/type2/blooddonor/blooddonor/info.phtml')
    			->setID($VO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type2_BloodDonor_BloodDonor_Grid');
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
    
    		$bloodDonorDataObj = json_decode($post["BloodDonorDataObj"],true);
    		
    		$adapter = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
    		$responseVO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
    		$bloodDonorDTO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
    		$bloodDonorVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bloodDonorDTO, $bloodDonorDataObj);
    		
    		if($bloodDonorVO->getCustomerID() == null){
	    		if(Mage::getSingleton('customer/session')->isLoggedIn()){
	    			$customerDataObj = Mage::getSingleton('customer/session')->getCustomer();
	    			$customerID = $customerDataObj->getId();
	    			$bloodDonorVO->setCustomerID($customerID);
	    		}
    		}

    		if($bloodDonorVO->getCustomerID() == null){
    			Mage::throwException($this->__('ther is a problem, please try after some time.'));
    		}
    		
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type2_BloodDonor_BloodDonor");
    		$response = $model->getResource()->frontendSaveDB($bloodDonorVO);
    		
    
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
