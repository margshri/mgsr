<?php 
class Margshri_WebPortal_Backend_Center_Content_Type10_Type10Controller extends Mage_Adminhtml_Controller_Action{
	
	protected $entityID;
	protected $tableCode;
	protected $title;
	
	protected function _initAction(){
		$this->loadLayout();
		$this->setTableName();
		$this->setTitle();
		$this->setBlock();
		return $this;
	}
	
	protected function setTableName(){
		$this->tableCode = $this->getRequest()->getActionName();
	}
	
	protected function setTitle(){
		$this->title = Mage::helper('webportal/Data')->getPageTitleByTableCode($this->getRequest()->getActionName());
		//$this->title = $this->__(ucwords( str_replace('apctweb', '', $this->getRequest()->getActionName())) ) ;
		$this->getLayout()->getBlock('head')->setTitle($this->title);
	}
	
	protected function setBlock(){
    	$headerBlock = $this->getLayout()->createBlock("webportal/Backend_Center_Content_Type10_Header");
    	$headerBlock->setTemplate('webportal/center/content/type10/header.phtml')->setTableCode($this->tableCode);
    	
    	$gridBlock =$this->getLayout()->createBlock("webportal/Backend_Center_Content_Type10_Grid")->setTableCode($this->tableCode);
    	$headerBlock->setChild("grid", $gridBlock);
    	
    	$this->getLayout()->getBlock('content')->append($headerBlock);
	}
    
	/*
    public function apctwebassociationAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    
    public function apctwebautomobileAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    */
	
	
	
	
	
	
    
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::helper('webportal/Data')->getType10Model($this->tableCode);
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$type10DTO = new Margshri_WebPortal_VO_Center_Content_Type10_Type10VO($this->tableCode); 
    			$type10VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($type10DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentType10VO', $type10VO);
    	return Mage::registry('CurrentType10VO');
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$this->tableCode = $this->getRequest()->getParam("TableCode");
    	Mage::register('CurrentTableCode', $this->tableCode);
    	$type10VO = $this->_init();
    	
    	if($type10VO == null){
    		$type10VO = new Margshri_WebPortal_VO_Center_Content_Type10_Type10VO($this->tableCode);  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type10_Buttons')
    			->setTemplate('webportal/center/content/type10/info.phtml')
    			->setID($type10VO->getID())
    	);
    	
    	
    	
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$this->tableCode = $this->getRequest()->getParam("TableCode");
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type10_Grid')->setTableCode($this->tableCode);
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
    
    		$type10DataObj = json_decode($post["Type10DataObj"],true);
    		
    		$this->tableCode = $type10DataObj['TableName'];
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type10_Type10VO($this->tableCode);
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type10_Type10VO($this->tableCode);
    		
    		$type10DTO = new Margshri_WebPortal_VO_Center_Content_Type10_Type10VO($this->tableCode);
    		$type10VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($type10DTO, $type10DataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::helper('webportal/Data')->getType10Model($this->tableCode);
    		$response = $model->getResource()->saveDB($type10VO);
    
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
    
    
    public function apctwebuniversityAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebschoolAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebagricultureAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebacademyinstituteAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebvehicalsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebfinanceAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebloanAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebgodplaceAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    public function apctwebnewspaperAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebmobileserviceAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebgovtdepartmentAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebscientificAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    public function apctweblaboratoryAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    
}
