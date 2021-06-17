<?php 
class Margshri_WebPortal_Backend_Master_Office_OfficeTypeController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Office Type');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_Office_OfficeType_OfficeType');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$officeTypeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
    			/* @var $officeTypeVO Margshri_WebPortal_VO_Master_Office_OfficeTypeVO */
    			$officeTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($officeTypeDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentOfficeTypeVO', $officeTypeVO);
    	return Mage::registry('CurrentOfficeTypeVO');
    }
    
    public function editAction(){
    	$officeTypeVO = $this->_init();
    	
    	if($officeTypeVO == null){
    		$officeTypeVO = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_Office_OfficeType_Buttons')
    			->setTemplate('webportal/master/office/officetype/info.phtml')
    			->setID($officeTypeVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_Office_OfficeType_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
    		
    		$officeTypeDataObj = json_decode($post["OfficeTypeDataObj"],true);
    		$officeTypeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
    		$officeTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($officeTypeDTO, $officeTypeDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_Office_OfficeType_OfficeType');
    		$response = $model->getResource()->saveDB($officeTypeVO);
    
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
