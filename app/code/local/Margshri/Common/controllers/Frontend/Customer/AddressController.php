<?php 
class Margshri_Common_Frontend_Customer_AddressController extends Mage_Core_Controller_Front_Action {
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	protected function _init(){
		 
		if($this->entityID !=null){
			$model   = Mage::getModel("webportal/Center_Content_Type7_Event_Event");
			$dataObj = $model->getResource()->getByID($this->entityID);
	
			if($dataObj !== false){
				$eventDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
				$eventVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($eventDTO, $dataObj);
			}
		}
	
		Mage::register('CurrentEventVO', $eventVO);
		return Mage::registry('CurrentEventVO');
	}
	
	public function indexAction(){
		$this->_initAction();
		//$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Event_Event_Info');
		//$block->setTemplate('webportal/center/content/type7/event/event/entropy.phtml');
		//$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	
	
	public function saveAction(){
		try {
	
			$post = $this->getRequest()->getPost();
	
			$errorMsg = array();
			$rResponse = array();
			$oResponse = array();
			$pResponse = array();
			$bResponse = array();
			$sResponse = array();
	
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
			
			
			
			if(Mage::getSingleton('customer/session')->isLoggedIn()) {
				$customerData = Mage::getSingleton('customer/session')->getCustomer();
				$customerID = $customerData->getId(); 
			}else{
				$this->_redirect('customer/account/login/');
				return;
			}
     		
			$adapter     = new Margshri_Common_VO_Customer_AddressVO();
			//$rAdapter     = new Margshri_Common_VO_Customer_AddressVO();
			//$oAdapter     = new Margshri_Common_VO_Customer_AddressVO();
			//$pAdapter     = new Margshri_Common_VO_Customer_AddressVO();
			//$bAdapter     = new Margshri_Common_VO_Customer_AddressVO();
			//$sAdapter     = new Margshri_Common_VO_Customer_AddressVO();

			$rAddressVO  = new Margshri_Common_VO_Customer_AddressVO();
			$oAddressVO  = new Margshri_Common_VO_Customer_AddressVO();
			$pAddressVO  = new Margshri_Common_VO_Customer_AddressVO();
			$bAddressVO  = new Margshri_Common_VO_Customer_AddressVO();
			$sAddressVO  = new Margshri_Common_VO_Customer_AddressVO();

			
			$rAddressVO->setID($post['RID']);
			$rAddressVO->setCustomerID($customerID);
			$rAddressVO->setTypeID(Margshri_Common_VO_Customer_AddressTypeVO::$RESIDENCE_ADDRESS);
			$rAddressVO->setMobileNumber($post['RMobileNumber']);
			$rAddressVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$rAddressVO->setPinCode($post['RPinCode']);
			$rAddressVO->setAddress($post['RAddress']);
			$rAddressVO->setCountryID($post['RCountryID']);
			$rAddressVO->setStateID($post['RStateID']);
			$rAddressVO->setDistrictID($post['RDistrictID']);
			$rAddressVO->setCityID($post['RCityID']);
			$rAddressVO->setCreatedBy(1);
			$rAddressVO->setUpdatedBy(1);
			
			
			$oAddressVO->setID($post['OID']);
			$oAddressVO->setCustomerID($customerID);
			$oAddressVO->setTypeID(Margshri_Common_VO_Customer_AddressTypeVO::$OFFICE_ADDRESS);
			$oAddressVO->setMobileNumber($post['OMobileNumber']);
			$oAddressVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$oAddressVO->setPinCode($post['OPinCode']);
			$oAddressVO->setAddress($post['OAddress']);
			$oAddressVO->setCountryID($post['OCountryID']);
			
			if($post['OStateID'] == null){
				$oAddressVO->setStateID(null);
			}else{
				$oAddressVO->setStateID($post['OStateID']);
			}
				
			if($post['ODistrictID'] == null){
				$oAddressVO->setDistrictID(null);
			}else{
				$oAddressVO->setDistrictID($post['ODistrictID']);
			}
				
			if($post['OCityID'] == null){
				$oAddressVO->setCityID(null);
			}else{
				$oAddressVO->setCityID($post['OCityID']);
			}
			
			$oAddressVO->setCreatedBy(1);
			$oAddressVO->setUpdatedBy(1);
			
			
			
			
			$pAddressVO->setID($post['PID']);
			$pAddressVO->setCustomerID($customerID);
			$pAddressVO->setTypeID(Margshri_Common_VO_Customer_AddressTypeVO::$PERMANENT_ADDRESS);
			$pAddressVO->setMobileNumber($post['PMobileNumber']);
			$pAddressVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$pAddressVO->setPinCode($post['PPinCode']);
			$pAddressVO->setAddress($post['PAddress']);
			$pAddressVO->setCountryID($post['PCountryID']);
			$pAddressVO->setStateID($post['PStateID']);
			$pAddressVO->setDistrictID($post['PDistrictID']);
			$pAddressVO->setCityID($post['PCityID']);
			$pAddressVO->setCreatedBy(1);
			$pAddressVO->setUpdatedBy(1);
			 
			
			
			if($post['PStateID'] == null){
				$pAddressVO->setStateID(null);
			}else{
				$pAddressVO->setStateID($post['PStateID']);
			}
			
			if($post['PDistrictID'] == null){
				$pAddressVO->setDistrictID(null);
			}else{
				$pAddressVO->setDistrictID($post['PDistrictID']);
			}
			
			if($post['PCityID'] == null){
				$pAddressVO->setCityID(null);
			}else{
				$pAddressVO->setCityID($post['PCityID']);
			}
			
			$pAddressVO->setCreatedBy(1);
			$pAddressVO->setUpdatedBy(1);
			
			
			$bAddressVO->setID($post['BID']);
			$bAddressVO->setCustomerID($customerID);
			$bAddressVO->setTypeID(Margshri_Common_VO_Customer_AddressTypeVO::$BILLING_ADDRESS);
			$bAddressVO->setMobileNumber($post['BMobileNumber']);
			$bAddressVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$bAddressVO->setPinCode($post['BPinCode']);
			$bAddressVO->setAddress($post['BAddress']);
			$bAddressVO->setCountryID($post['BCountryID']);
			
			if($post['BStateID'] == null){
				$bAddressVO->setStateID(null);
			}else{
				$bAddressVO->setStateID($post['BStateID']);
			}
			
			if($post['BDistrictID'] == null){
				$bAddressVO->setDistrictID(null);
			}else{
				$bAddressVO->setDistrictID($post['BDistrictID']);
			}
			
			if($post['BCityID'] == null){
				$bAddressVO->setCityID(null);
			}else{
				$bAddressVO->setCityID($post['BCityID']);
			}
			
			$bAddressVO->setCreatedBy(1);
			$bAddressVO->setUpdatedBy(1);
			
			
			$sAddressVO->setID($post['SID']);
			$sAddressVO->setCustomerID($customerID);
			$sAddressVO->setTypeID(Margshri_Common_VO_Customer_AddressTypeVO::$SHIPPING_ADDRESS);
			$sAddressVO->setMobileNumber($post['SMobileNumber']);
			$sAddressVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$sAddressVO->setPinCode($post['SPinCode']);
			$sAddressVO->setAddress($post['SAddress']);
			$sAddressVO->setCountryID($post['SCountryID']);
			
			if($post['SStateID'] == null){
				$sAddressVO->setStateID(null);
			}else{
				$sAddressVO->setStateID($post['SStateID']);
			}
			
			if($post['SDistrictID'] == null){
				$sAddressVO->setDistrictID(null);
			}else{
				$sAddressVO->setDistrictID($post['SDistrictID']);
			}
			
			if($post['SCityID'] == null){
				$sAddressVO->setCityID(null);
			}else{
				$sAddressVO->setCityID($post['SCityID']);
			}
			
			$sAddressVO->setCreatedBy(1);
			$sAddressVO->setUpdatedBy(1);
				
			 
			
			$model = Mage::getModel("common/Customer_Address");
			
			$adapter->getAdapter()->beginTransaction();
			$rResponse = $model->getResource()->saveDB($rAddressVO);
				
			if($rResponse['status'] == "ERROR"){
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('core/session')->addError($rResponse['message']." :=>Residence Address");
				$this->_redirect('customer/account/address/');
				return;
			}else{
				$adapter->getAdapter()->commit();
			}
			
			
			$adapter->getAdapter()->beginTransaction();
			$oResponse = $model->getResource()->saveDB($oAddressVO);
				
			if($oResponse['status'] == "ERROR"){
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('core/session')->addError($oResponse['message']." :=>Office Address");
				$this->_redirect('customer/account/address/');
				return;
			}else{
				$adapter->getAdapter()->commit();
			}
			
			
			$adapter->getAdapter()->beginTransaction();
			$pResponse = $model->getResource()->saveDB($pAddressVO); 
			
			if($pResponse['status'] == "ERROR"){
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('core/session')->addError($pResponse['message']." :=>Permanent Address");
				$this->_redirect('customer/account/address/');
				return;
			}else{
				$adapter->getAdapter()->commit();
			}
			
			
			
			
			$adapter->getAdapter()->beginTransaction();
			$bResponse = $model->getResource()->saveDB($bAddressVO);
			
			if($bResponse['status'] == "ERROR"){
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('core/session')->addError($bResponse['message']." :=>Billing Address");
				$this->_redirect('customer/account/address/');
				return;
			}else{
				$adapter->getAdapter()->commit();
			}
			
			$adapter->getAdapter()->beginTransaction();
			$sResponse = $model->getResource()->saveDB($sAddressVO);
			
			if($sResponse['status'] == "ERROR"){
				$adapter->getAdapter()->rollBack();
				Mage::getSingleton('core/session')->addError($sResponse['message']." :=> Shipping Address");
				$this->_redirect('customer/account/address/');
				return;
			}else{
				$adapter->getAdapter()->commit();
			}
			
			Mage::getSingleton('core/session')->addSuccess("Successfully Saved !");
			$this->_redirect('customer/account/address/');
	
		} catch (Exception $e) {
			$adapter->getAdapter()->rollBack();
			Mage::getSingleton('core/session')->addError($e->getMessage());
			$this->_redirect('customer/account/address/');
		}
		return;
	}
    
}
