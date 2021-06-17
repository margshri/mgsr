<?php 
class Margshri_WebPortal_Backend_Center_Content_Type5_Viewer_ViewerController extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type5_Viewer_Viewer");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$DTO = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO(); 
    			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentViewerVO', $DTO);
    	return Mage::registry('CurrentViewerVO');
    }
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle("Viewer");
    	$this->renderLayout();
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$VO = $this->_init();
    	
    	if($VO == null){
    		$VO = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type5_Viewer_Viewer_Buttons')
    			->setTemplate('webportal/center/content/type5/viewer/viewer/info.phtml')
    			->setID($VO->getID())
    	);
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type5_Viewer_Viewer_Grid');
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
    
    		$viewerDataObj = json_decode($post["ViewerDataObj"],true);
    		
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
    		
    		$viewerDTO     = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
    		/* @var $viewerVO Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO */
    		$viewerVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($viewerDTO, $viewerDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::getModel("webportal/Center_Content_Type5_Viewer_Viewer");
    		$response = $model->getResource()->updateDB($viewerVO);
    		
    		if($response['status'] == "SUCCESS"){
    			$adapter->getAdapter()->commit();
    			Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
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
