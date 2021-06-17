<?php 
class Margshri_WebPortal_Backend_Center_Content_Type11_Type11Controller extends Mage_Adminhtml_Controller_Action{
	
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
    	$headerBlock = $this->getLayout()->createBlock("webportal/Backend_Center_Content_Type11_Header");
    	$headerBlock->setTemplate('webportal/center/content/type11/header.phtml')->setTableCode($this->tableCode);
    	
    	$gridBlock =$this->getLayout()->createBlock("webportal/Backend_Center_Content_Type11_Grid")->setTableCode($this->tableCode);
    	$headerBlock->setChild("grid", $gridBlock);
    	
    	$this->getLayout()->getBlock('content')->append($headerBlock);
	}
    
    protected function _init(){
    	
    	if($this->entityID !=null){
    		$model   = Mage::helper('webportal/Data')->getType11Model($this->tableCode);
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$type11DTO = new Margshri_WebPortal_VO_Center_Content_Type11_Type11VO($this->tableCode); 
    			$type11VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($type11DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentType11VO', $type11VO);
    	return Mage::registry('CurrentType11VO');
    }
    
    public function editAction(){
    	
    	$this->entityID  = $this->getRequest()->getParam("ID");
    	$this->tableCode = $this->getRequest()->getParam("TableCode");
    	Mage::register('CurrentTableCode', $this->tableCode);
    	$type11VO = $this->_init();
    	
    	if($type11VO == null){
    		$type11VO = new Margshri_WebPortal_VO_Center_Content_Type11_Type11VO($this->tableCode);  
    	}
    
    	$this->loadLayout();
    	
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type11_Buttons')
    			->setTemplate('webportal/center/content/type11/info.phtml')
    			->setID($type11VO->getID())
    	);
    	
    	
    	
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$this->tableCode = $this->getRequest()->getParam("TableCode");
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Center_Content_Type11_Grid')->setTableCode($this->tableCode);
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
    
    		$type11DataObj = json_decode($post["Type11DataObj"],true);
    		
    		$this->tableCode = $type11DataObj['TableName'];
    		$adapter     = new Margshri_WebPortal_VO_Center_Content_Type11_Type11VO($this->tableCode);
    		$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type11_Type11VO($this->tableCode);
    		
    		$type11DTO = new Margshri_WebPortal_VO_Center_Content_Type11_Type11VO($this->tableCode);
    		$type11VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($type11DTO, $type11DataObj);
    			
    		$adapter->getAdapter()->beginTransaction();
    		$model = Mage::helper('webportal/Data')->getType11Model($this->tableCode);
    		$response = $model->getResource()->saveDB($type11VO);
    
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
    
    
    public function apctwebrailwaysAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    public function apctwebroadwaysAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebresultAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebsoftwareAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    public function apctwebsongsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }

    
    /*
    public function apctwebgovtsitesAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    */
    
    public function apctwebgspublicsectorunitsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebgsstategovtdepartmentAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebgsinformationtechnologysectorAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    
    public function apctwebgsrajasthanstateportalAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebgscentralgovtdepartmentAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
    
    public function apctwebgseducationalinstitutionsAction(){
    	$this->_initAction();
    	$this->renderLayout();
    }
    
     
}
