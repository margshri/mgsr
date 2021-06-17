<?php 
class Margshri_WebPortal_Backend_Master_SubPage_ServiceController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
    public function indexAction(){
    	$this->_initAction();
    	$this->getLayout()->getBlock('head')->setTitle('Sub Page Service');
    	$this->renderLayout();
    }
    
    protected function _init()
    {
    	$id = $this->getRequest()->getParam("ID");
    	if($id !=null){
    		$model   = Mage::getModel('webportal/Master_SubPage_Service');
    		$dataObj = $model->getResource()->getByID($id);
    		
    		if($dataObj !== false){
    			$serviceDTO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
    			/* @var $serviceVO Margshri_WebPortal_VO_Master_SubPage_ServiceVO */
    			$serviceVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($serviceDTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentServiceVO', $serviceVO);
    	return Mage::registry('CurrentServiceVO');
    }
    
    public function editAction(){
    	$serviceVO = $this->_init();
    	
    	if($serviceVO == null){
    		$serviceVO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
    	}
    	
    	$this->_initAction();
    	$this->_addContent(
    			$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_Service_Buttons')
    			->setTemplate('webportal/master/subpage/service/info.phtml')
    			->setID($serviceVO->getID())
    	);
    
    	$this->renderLayout();
    }
    
    public function gridAction()
    {
    	$gridBlock =$this->getLayout()->createBlock('webportal/Backend_Master_SubPage_Service_Grid');
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
	
			$adapter     = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
			$responseVO  = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
			$serviceVO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
	
	
			$serviceVO->setID($post['ID']);
			$serviceVO->setValue($post['Value']);
			$serviceVO->setCode($post['Code']);
			//$serviceVO->setEntityID($post['EntityID']);
			$serviceVO->setStatusID($post['StatusID']);
			
			
			$imageFileObj = $_FILES['Image'];
			
			if($imageFileObj["tmp_name"] != null && $imageFileObj["tmp_name"] != ''){
				// CREATE IMAGE PATH AND SET IMAGE PATH
				$imagePath = 'web_portal/frontend/subpage/service/';
				$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
				$imagePath = $imagePath.$serviceVO->getCode().'.'.$ext;
				$serviceVO->setImageURL($imagePath);
			}
			 
			$adapter->getAdapter()->beginTransaction();
			$model = Mage::getModel("webportal/Master_SubPage_Service");
			$response = $model->getResource()->saveDB($serviceVO, null);
			
	
			if($response['status'] == "SUCCESS"){
				$adapter->getAdapter()->commit();
				
				if($imageFileObj["tmp_name"] != null && $imageFileObj["tmp_name"] != ''){
					$helper = Mage::helper("margshri/Utility");
					move_uploaded_file($imageFileObj["tmp_name"], $helper->getServerPath() . '/media/' . $serviceVO->getImageURL());
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess($response['message']);
				$this->_redirect('*/*/index');
			}else{
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('adminhtml/session')->addError($response['message']);
				$this->_redirect('*/*/edit', array("ID"=>$serviceVO->getID()));
	
			}
	
		} catch (Exception $e) {
			$adapter->getAdapter()->rollBack();
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*/edit', array("ID"=>$serviceVO->getID()));
		}
		return;
	}	
	
}// end class