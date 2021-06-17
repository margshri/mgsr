<?php 
class Margshri_WebPortal_Frontend_LocationSelector_LocationSelectorController extends Mage_Core_Controller_Front_Action {
	
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
    
	public function setClientIPAction(){
		$clientIP = Mage::getSingleton('core/session')->setData('ClientIP', Mage::helper('webportal/Data')->getClientIP());
		$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($clientIP));
		return;
	}
	
	
	public function setLocationAction(){
		try{
			$response = array();
			$post     = $this->getRequest()->getPost();
		
			if (empty($post)) {
				Mage::throwException($this->__('Invalid data.'));
			}
	
			$locationDataObj = json_decode($post["LocationDataObj"],true);
		
			$locationDTO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
			$locationVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($locationDTO, $locationDataObj);
		
			Mage::getSingleton('core/session')->setData('LocationVO', serialize($locationVO));
		
			$response['status'] = 'SUCCESS';
			$response['message']= 'Location Set Successfully';
			
		}catch (Exception $e){
			$response['status'] ='ERROR';
			$response['message']= $e->getMessage();
		}

		return 	$this->getResponse()->setBody(Mage::helper('core')->jsonEncode($response));		
	}
	
	 
    
}
