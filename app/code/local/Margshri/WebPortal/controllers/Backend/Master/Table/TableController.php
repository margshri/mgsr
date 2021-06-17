<?php 
class Margshri_WebPortal_Backend_Master_Table_TableController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Web Table');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_Table_Table');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    			/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */
    			$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentTableVO', $tableVO);
    	return Mage::registry('CurrentTableVO');
    }
    
    public function editAction(){
    	$tableVO = $this->_init();
    	
    	if($tableVO == null){
    		$tableVO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_Table_Table_Buttons')
    			->setTemplate('webportal/master/table/table/info.phtml')
    			->setID($tableVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_Table_Table_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		
    		$tableDataObj = json_decode($post["TableDataObj"],true);
    		$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
    		$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $tableDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_Table_Table');
    		$response = $model->getResource()->saveDB($tableVO);
    
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
