<?php 
class Margshri_WebPortal_Frontend_Center_Content_Type3_PhoneBook_PersonalController extends Mage_Core_Controller_Front_Action {
	
	protected $entityID = null;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}
	
	protected function _init(){
		
		if($this->entityID !=null){
    		$model   = Mage::getModel("webportal/Center_Content_Type3_PhoneBook_Personal_Personal");
    		$dataObj = $model->getResource()->getByID($this->entityID);
    		
    		if($dataObj !== false){
    			$DTO = new Margshri_WebPortal_VO_Center_Content_Type3_PhoneBook_Personal_PersonalVO(); 
    			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
    		}
    	}	
    		
    	Mage::register('CurrentPersonalPhoneBookVO', $DTO);
    	return Mage::registry('CurrentPersonalPhoneBookVO');
		
	}
	
	public function indexAction(){
		$this->loadLayout();
		
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type3_PhoneBook_Personal_Info');
		$block->setTemplate('webportal/center/content/type3/phonebook/personal/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		 
		$this->renderLayout();
	}
	
	public function editAction(){
		
		$this->entityID  = $this->getRequest()->getParam("ID");
		$VO = $this->_init();
		 
		if($VO == null){
			$VO = new Margshri_WebPortal_VO_Center_Content_Type3_PhoneBook_Personal_PersonalVO();
		}
		
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type3_PhoneBook_Personal_Edit');
		$block->setTemplate('webportal/center/content/type3/phonebook/personal/edit.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	

	public function notLoginAction(){
		$this->_initAction();
		$this->_redirect('customer/account/login/');
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
			
			$adapter     = new Margshri_WebPortal_VO_Center_Content_Type3_PhoneBook_Personal_PersonalVO();
			$responseVO  = new Margshri_WebPortal_VO_Center_Content_Type3_PhoneBook_Personal_PersonalVO();
			$personalVO    = new Margshri_WebPortal_VO_Center_Content_Type3_PhoneBook_Personal_PersonalVO();
	
	
			$personalVO->setID($post['ID']);
			$personalVO->setName($post['Name']);
			$personalVO->setUserID($post['UserID']);
			$personalVO->setDOB($post['DOB']);
			$personalVO->setRelation($post['Relation']);
			$personalVO->setEmail($post['Email']);
			$personalVO->setAddress($post['Address']);
			$personalVO->setPinCode($post['PinCode']);
			$personalVO->setLandLineNumber($post['LandLineNumber']);
			$personalVO->setMobileNumber1($post['MobileNumber1']);
			$personalVO->setMobileNumber2($post['MobileNumber2']);
			
			/*
			$personalVO->setStatusID($post['StatusID']);
			$personalVO->setCountryID($post['CountryID']);
			$personalVO->setStateID($post['StateID']);
			$personalVO->setDistrictID($post['DistrictID']);
			$personalVO->setCityID($post['CityID']);
			*/
			
			$personalVO->setStatusID(null);
			$personalVO->setCountryID(null);
			$personalVO->setStateID(null);
			$personalVO->setDistrictID(null);
			$personalVO->setCityID(null);
			 
			$adapter->getAdapter()->beginTransaction();
			$model = Mage::getModel("webportal/Center_Content_Type3_PhoneBook_Personal_Personal");
			$response = $model->getResource()->saveDB($personalVO); 
			
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
