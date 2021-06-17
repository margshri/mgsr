<?php 
class Margshri_WebPortal_Backend_Master_Office_UserOfficeController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('User Office');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_Office_UserOffice_UserOffice');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$userOfficeDTO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
    			/* @var $userOfficeVO Margshri_WebPortal_VO_Master_Office_UserOfficeVO */
    			$userOfficeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($userOfficeDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentUserOfficeVO', $userOfficeVO);
    	Mage::register('CurrentAdminUserID', $this->getRequest()->getParam("AdminUserID"));
    	
    	return Mage::registry('CurrentUserOfficeVO');
    }
    
    public function editAction(){
    	$userOfficeVO = $this->_init();
    	
    	if($userOfficeVO == null){
    		$userOfficeVO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_Office_UserOffice_Buttons')
    			->setTemplate('webportal/master/office/useroffice/info.phtml')
    			->setID($userOfficeVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_Office_UserOffice_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
    		
    		$userOfficeDataObj = json_decode($post["UserOfficeDataObj"],true);
    		$userOfficeDTO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
    		$userOfficeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($userOfficeDTO, $userOfficeDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_Office_UserOffice_UserOffice');
    		$response = $model->getResource()->saveDB($userOfficeVO);
    
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
