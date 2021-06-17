<?php 
class Margshri_WebPortal_Backend_Center_Content_Type2_CityDiamonds_CityDiamondsController extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
    protected function _init(){
    	
    	$VO = new Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO();
    	
    	if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type2_CityDiamonds_CityDiamonds");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$DTO = new Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO(); 
    			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		}
    	}else{
    		$VO->setCustomerID($this->getRequest()->getParam("CustomerID"));
    	}

    	$VO->setFirstName($this->getRequest()->getParam("FirstName"));
    	$VO->setLastName($this->getRequest()->getParam("LastName"));
    	
    		
    	Mage::register('CurrentCityDiamondsVO', $VO);
    	return Mage::registry('CurrentCityDiamondsVO');
    }
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("CityDiamonds");
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$VO = $this->_init();
    	
    	if($VO == null){
    		$VO = new Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type2_CityDiamonds_CityDiamonds_Buttons')
    			->setTemplate('webportal/center/content/type2/citydiamonds/citydiamonds/info.phtml')
    			->setID($VO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type2_CityDiamonds_CityDiamonds_Grid');
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
    
    		$professionalDataObj = json_decode($post["CityDiamondsDataObj"],true);
    		
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO();
    		$professionalDTO  = new Margshri_WebPortal_VO_Center_Content_Type2_CityDiamonds_CityDiamondsVO();
    		$professionalVO   = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($professionalDTO, $professionalDataObj);
    		
    		
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type2_CityDiamonds_CityDiamonds");
    		$response = $model->getResource()->saveDB($professionalVO);
    		
    
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
