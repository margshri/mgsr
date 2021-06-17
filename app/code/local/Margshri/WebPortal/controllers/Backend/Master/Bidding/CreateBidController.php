<?php 
class Margshri_WebPortal_Backend_Master_Bidding_CreateBidController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Create Bid');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_Right_Bid');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
    			/* @var $bidVO Margshri_WebPortal_VO_Master_Right_BidVO */
    			$bidVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentBidVO', $bidVO);
    	return Mage::registry('CurrentBidVO');
    }
    
    public function editAction(){
    	$bidVO = $this->_init();
    	
    	if($bidVO == null){
    		$bidVO = new Margshri_WebPortal_VO_Master_Right_BidVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_Bidding_CreateBid_Buttons')
    			->setTemplate('webportal/master/bidding/createbid/info.phtml')
    			->setID($bidVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_Bidding_CreateBid_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_Right_BidVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_Right_BidVO();
    		
    		$bidDataObj = json_decode($post["BidDataObj"],true);
    		$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
    		$bidVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidDTO, $bidDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_Right_Bid');
    		$response = $model->getResource()->saveDB($bidVO);
    
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
