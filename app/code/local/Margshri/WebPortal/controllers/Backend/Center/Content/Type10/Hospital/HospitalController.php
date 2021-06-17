<?php 
class Margshri_WebPortal_Backend_Center_Content_Type10_Hospital_HospitalController extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	protected $tableCode = "apctwebhospital";
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
	
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type10_Hospital_Hospital");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$hospitalDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO(); 
    			$hospitalVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($hospitalDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentHospitalVO', $hospitalVO);
    	return Mage::registry('CurrentHospitalVO');
    }
    
    public function indexAction(){

    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("Hospital");
    	$headerBlock = $this->getLayout()->createBlock("webportal/Backend_Center_Content_Type10_Hospital_Hospital_Header");
    	$headerBlock->setTemplate('webportal/center/content/type10/hospital/hospital/header.phtml');
    	 
    	$gridBlock =$this->getLayout()->createBlock("webportal/Backend_Center_Content_Type10_Hospital_Hospital_Grid")->setTableCode($this->tableCode);
    	$headerBlock->setChild("grid", $gridBlock);
    	 
    	$this->getLayout()->getBlock('content')->append($headerBlock);
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$hospitalVO = $this->_init();
    	
    	if($hospitalVO == null){
    		$hospitalVO = new Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type10_Hospital_Hospital_Buttons')
    			->setTemplate('webportal/center/content/type10/hospital/hospital/info.phtml')
    			->setID($hospitalVO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type10_Hospital_Hospital_Grid');
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
    
    		$hospitalDataObj = json_decode($post["HospitalDataObj"],true);
    		
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO();
    		
    		$hospitalDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO();
    		$hospitalVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($hospitalDTO, $hospitalDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type10_Hospital_Hospital");
    		$response = $model->getResource()->saveDB($hospitalVO);
    
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
