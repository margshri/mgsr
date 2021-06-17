<?php 
class Margshri_WebPortal_Backend_Master_Office_OfficeController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Office');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_Office_Office_Office');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$officeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
    			/* @var $officeVO Margshri_WebPortal_VO_Master_Office_OfficeVO */
    			$officeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($officeDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentOfficeVO', $officeVO);
    	return Mage::registry('CurrentOfficeVO');
    }
    
    public function editAction(){
    	$officeVO = $this->_init();
    	
    	if($officeVO == null){
    		$officeVO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_Office_Office_Buttons')
    			->setTemplate('webportal/master/office/office/info.phtml')
    			->setID($officeVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_Office_Office_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
    		
    		$officeDataObj = json_decode($post["OfficeDataObj"],true);
    		$officeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
    		$officeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($officeDTO, $officeDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_Office_Office_Office');
    		$response = $model->getResource()->saveDB($officeVO);
    
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
