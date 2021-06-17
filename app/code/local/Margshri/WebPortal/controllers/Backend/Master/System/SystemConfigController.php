<?php 
class Margshri_WebPortal_Backend_Master_System_SystemConfigController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('System Config');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_System_SystemConfig');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$systemConfigDTO = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
    			/* @var $systemConfigVO Margshri_WebPortal_VO_Master_System_SystemConfigVO */
    			$systemConfigVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($systemConfigDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentSystemConfigVO', $systemConfigVO);
    	return Mage::registry('CurrentSystemConfigVO');
    }
    
    public function editAction(){
    	
    	try {
	    	$systemConfigVO = $this->_init();
	    	
	    	if($systemConfigVO == null){
	    		$systemConfigVO = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
	    	}
	    	
	    	$this->_initAction();
	    	$this->_addContent(
	    			$this->getLayout()->createBlock('webportal/Backend_Master_System_SystemConfig_Buttons')
	    			->setTemplate('webportal/master/system/systemconfig/info.phtml')
	    			->setID($systemConfigVO->getID())
	    	);
	    
	    	$this->renderLayout();
    		
    	} catch(Exception $e){
		    $this->_redirect('*/*/index');
		}
	    	
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_System_SystemConfig_Grid');
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
    
    		$adapter = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
    		
    		$systemConfigDataObj = json_decode($post["SystemConfigDataObj"],true);
    		$systemConfigDTO = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
    		$systemConfigVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($systemConfigDTO, $systemConfigDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_System_SystemConfig');
    		$response = $model->getResource()->saveDB($systemConfigVO);
    
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
