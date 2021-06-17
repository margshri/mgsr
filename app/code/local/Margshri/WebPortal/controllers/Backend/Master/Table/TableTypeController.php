<?php 
class Margshri_WebPortal_Backend_Master_Table_TableTypeController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Web Table Type');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_Table_TableType');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$tableTypeDTO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
    			/* @var $tableTypeVO Margshri_WebPortal_VO_Master_Table_TableTypeVO */
    			$tableTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableTypeDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentTableTypeVO', $tableTypeVO);
    	return Mage::registry('CurrentTableTypeVO');
    }
    
    public function editAction(){
    	$tableTypeVO = $this->_init();
    	
    	if($tableTypeVO == null){
    		$tableTypeVO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_Table_TableType_Buttons')
    			->setTemplate('webportal/master/table/tabletype/info.phtml')
    			->setID($tableTypeVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_Table_TableType_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
    		
    		$tableTypeDataObj = json_decode($post["TableTypeDataObj"],true);
    		$tableTypeDTO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
    		$tableTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableTypeDTO, $tableTypeDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_Table_TableType');
    		$response = $model->getResource()->saveDB($tableTypeVO);
    
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			$responseVO->setSuccessMessage($response['message']);
    			//Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
    			//$this->_redirect("*/*/");
    		}else{
    			$adapter->getAdapter()->rollBack();
    			$responseVO->setErrorMessage($response['message']);
    			//Mage::getSingleton('adminhtml/session')->addError($response['message']);
    			//$this->_redirectReferer();
    		}
    
    	} catch (Exception $e) {
    		$adapter->getAdapter()->rollBack();
    		//$responseVO->setErrorMessage(array($e->getMessage()));
    		Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		$this->_redirectReferer();
    	}
    	
    	$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
    	return;
    
    }
}
