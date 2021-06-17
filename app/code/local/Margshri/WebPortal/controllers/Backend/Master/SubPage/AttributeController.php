<?php 
class Margshri_WebPortal_Backend_Master_SubPage_AttributeController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Sub Page Attribute');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_SubPage_Attribute');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$attributeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
    			/* @var $attributeVO Margshri_WebPortal_VO_Master_SubPage_AttributeVO */
    			$attributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($attributeDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentAttributeVO', $attributeVO);
    	return Mage::registry('CurrentAttributeVO');
    }
    
    public function editAction(){
    	$attributeVO = $this->_init();
    	
    	if($attributeVO == null){
    		$attributeVO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_Attribute_Buttons')
    			->setTemplate('webportal/master/subpage/attribute/info.phtml')
    			->setID($attributeVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_Attribute_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
    		
    		$attributeDataObj = json_decode($post["AttributeDataObj"],true);
    		$attributeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
    		$attributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($attributeDTO, $attributeDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_SubPage_Attribute');
    		$response = $model->getResource()->saveDB($attributeVO);
    
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