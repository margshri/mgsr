<?php 
class Margshri_WebPortal_Backend_Master_SubPage_EntityController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Sub Page Entity');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_SubPage_Entity');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
    			/* @var $entityVO Margshri_WebPortal_VO_Master_SubPage_EntityVO */
    			$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentEntityVO', $entityVO);
    	return Mage::registry('CurrentEntityVO');
    }
    
    public function editAction(){
    	$entityVO = $this->_init();
    	
    	if($entityVO == null){
    		$entityVO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_Entity_Buttons')
    			->setTemplate('webportal/master/subpage/entity/info.phtml')
    			->setID($entityVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_Entity_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
    		
    		$entityDataObj = json_decode($post["EntityDataObj"],true);
    		$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
    		$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $entityDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_SubPage_Entity');
    		$response = $model->getResource()->saveDB($entityVO);
    
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