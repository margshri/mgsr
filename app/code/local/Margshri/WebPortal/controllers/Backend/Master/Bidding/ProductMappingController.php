<?php 
class Margshri_WebPortal_Backend_Master_Bidding_ProductMappingController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Product Mapping');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_Right_BidProducts');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$bidProductsDTO = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
    			/* @var $bidProductsVO Margshri_WebPortal_VO_Master_Right_BidProductsVO */
    			$bidProductsVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidProductsDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentBidProductsVO', $bidProductsVO);
    	return Mage::registry('CurrentBidProductsVO');
    }
    
    public function editAction(){
    	$bidProductsVO = $this->_init();
    	
    	if($bidProductsVO == null){
    		$bidProductsVO = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_Bidding_ProductMapping_Buttons')
    			->setTemplate('webportal/master/bidding/productmapping/info.phtml')
    			->setID($bidProductsVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_Bidding_ProductMapping_Grid');
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
    
    		$adapter     = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
    		$responseVO  = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
    		
    		$bidProductsDataObj = json_decode($post["BidProductsDataObj"],true);
    		$bidProductsDTO = new Margshri_WebPortal_VO_Master_Right_BidProductsVO();
    		$bidProductsVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bidProductsDTO, $bidProductsDataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = mage::getModel('webportal/Master_Right_BidProducts');
    		$response = $model->getResource()->saveDB($bidProductsVO);
    
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
