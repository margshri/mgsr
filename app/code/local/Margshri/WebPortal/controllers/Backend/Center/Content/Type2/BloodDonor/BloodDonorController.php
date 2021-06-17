<?php 
class Margshri_WebPortal_Backend_Center_Content_Type2_BloodDonor_BloodDonorController extends Mage_Adminhtml_Controller_Action{
	
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
    	
    	
    	$customerDataObj = Mage::getModel('customer/customer')->load($this->getRequest()->getParam("CustomerID"))->getData();
    	
    	$bloodGroup = '';
    	/*
    	if($this->getRequest()->getParam("BloodGroup") != null){
    		$bloodGroup = $this->getRequest()->getParam("BloodGroup");
    	}
    	*/
    	if($customerDataObj['bloodgroup'] != null){
    		$bloodGroup = $customerDataObj['bloodgroup'];
    	}
    	
    	
    	$model = Mage::getModel('webportal/Master_Center_Content_Type2_BloodDonor_BloodGroup');
    	$list = $model->getResource()->getActiveList();
    	foreach($list as $row){
    		$bloodGroupDTO = new Margshri_WebPortal_VO_Master_Center_Content_Type2_BloodDonor_BloodGroupVO();
    		$bloodGroupVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bloodGroupDTO, $row);
    		if($bloodGroupVO->getCode() != null){
    			if(strtolower($bloodGroupVO->getCode()) == strtolower($bloodGroup)){
    				$VO->setBloodGroupID($bloodGroupVO->getID());
    			}
    		}
    	}
    	 
    		
    	Mage::register('CurrentBloodDonorVO', $VO);
    	return Mage::registry('CurrentBloodDonorVO');
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
    
    public function gridAction(){
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
    		
    		
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type2_BloodDonor_BloodDonor");
    		$response = $model->getResource()->saveDB($bloodDonorVO);
    		
    
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			$responseVO->setSuccessMessage($response['message']);
    			Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
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
