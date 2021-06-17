<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type5_Viewer_ViewerController extends Mage_Core_Controller_Front_Action {
	
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
	
	public function indexAction(){
		$this->loadLayout();
		
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type5_Viewer_Viewer_Info');
		$block->setTemplate('webportal/center/content/type5/viewer/viewer/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		 
		$this->renderLayout();
	}
	
	
	public function saveAction(){
		try {
	
			$post = $this->getRequest()->getPost();
	
			$errorMsg = array();
			$response = array();
	
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
			
			if(Mage::getSingleton('customer/session')->isLoggedIn()) {
				$customerData = Mage::getSingleton('customer/session')->getCustomer();
				$userID = $customerData->getId(); 
			}else{
				$this->_redirect('customer/account/login/');
				return;
			}
     		
			
			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			
			$adapter     = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
			$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
			$viewerVO     = new Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerVO();
	
	
			$viewerVO->setID($post['ID']);
			$viewerVO->setValue($post['Value']);
			$viewerVO->setStatusID(Margshri_WebPortal_VO_Center_Content_Type5_Viewer_ViewerStatusVO::$PENDING);
			$viewerVO->setCreatedAt($serverDate);
			$viewerVO->setCreatedBy($userID);
			 
			$adapter->getAdapter()->beginTransaction();
			$model = Mage::getModel("webportal/Center_Content_Type5_Viewer_Viewer");
			$response = $model->getResource()->saveDB($viewerVO); 
			
			if($response['status'] == "SUCCESS"){
				$adapter->getAdapter()->commit();
				Mage::getSingleton('core/session')->addSuccess($response['message']);
				$this->_redirect('*/*/index');
			}else{
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('core/session')->addError($response['message']);
				$this->_redirect('*/*/index');
	
			}
	
		} catch (Exception $e) {
			$adapter->getAdapter()->rollBack();
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$this->_redirect('*/*/index');
		}
		return;
	}
    
}
