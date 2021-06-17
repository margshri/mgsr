<?php 
class Margshri_WebPortal_Backend_Center_Content_Type1_Bank_BranchController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
	
	
    
    public function indexAction(){
    	$this->_initAction();
		$this->getLayout()->getBlock('head')->setTitle("Bank Branch");    	
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Center_Content_Type1_Bank_Branch');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$branchDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
    			/* @var $branchVO Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO */
    			$branchVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($branchDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentBranchVO', $branchVO);
    	return Mage::registry('CurrentBranchVO');
    }
    
    public function editAction(){
    	$branchVO = $this->_init();
    	/* @var $branchVO Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO */
    	
    	if($branchVO == null){
    		$branchVO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
    	}
    
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type1_Bank_Branch_Buttons')
    			->setTemplate('webportal/center/content/type1/bank/branch/info.phtml')
    			->setID($branchVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type1_Bank_Branch_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
    		
    		$branchDataObj = json_decode($post["BranchDataObj"],true);
    		$branchDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
    		$branchVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($branchDTO, $branchDataObj);
    		
    		if($branchVO->getWebsiteLink() != null){
	    		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$branchVO->getWebsiteLink())) {
	    			$errorMsg[] = "Please Enter Valid Website Link";
	    		}
    		}	

    		if(sizeof($errorMsg) > 0){
    			$responseVO->setErrorMessage($errorMsg);
    			$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray() ));
    			return;
    		}
    		
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Center_Content_Type1_Bank_Branch');
    		$response = $model->getResource()->saveDB($branchVO);
    
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
    	$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray() ));
    	return;
    }
}