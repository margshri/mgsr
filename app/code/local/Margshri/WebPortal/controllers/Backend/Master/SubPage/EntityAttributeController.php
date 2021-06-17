<?php 
class Margshri_WebPortal_Backend_Master_SubPage_EntityAttributeController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Sub Page Entity Attribute');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_SubPage_EntityAttribute');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$entityAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
    			/* @var $entityAttributeVO Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO */
    			$entityAttributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityAttributeDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentEntityAttributeVO', $entityAttributeVO);
    	return Mage::registry('CurrentEntityAttributeVO');
    }
    
    public function editAction(){
    	$entityAttributeVO = $this->_init();
    	
    	if($entityAttributeVO == null){
    		$entityAttributeVO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_EntityAttribute_Buttons')
    			->setTemplate('webportal/master/subpage/entityattribute/info.phtml')
    			->setID($entityAttributeVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_EntityAttribute_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
    		
    		$entityAttributeDataObj = json_decode($post["EntityAttributeDataObj"],true);
    		$entityAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
    		$entityAttributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityAttributeDTO, $entityAttributeDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_SubPage_EntityAttribute');
    		$response = $model->getResource()->saveDB($entityAttributeVO);
    
    		
    		
    		
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
	
}// end class