<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type3_PhoneBook_Personal_Edit extends Mage_Core_Block_Template{

	protected $customerID = null; 
	
	public function __construct(){
		parent::__construct();
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customerData = Mage::getSingleton('customer/session')->getCustomer();
			$this->customerID = $customerData->getId();
		}
		
	}
	
	public function getPersonalVO(){
		return Mage::registry('CurrentPersonalPhoneBookVO');
	}
	
	
	public function getCountryOptions(){
		$options = array();
		$model = Mage::getModel('webportal/Directory_CountryList');
		$options = $model->getResource()->getOptions();
		return $options;
	}
	
	public function getStateOptions(){
		$options = array();
		$model = Mage::getModel('webportal/Directory_StateList');
		$options = $model->getResource()->getOptions();
		return $options;
	}
	
	public function getDistrictOptions(){
		$options = array();
		$model = Mage::getModel('webportal/Directory_DistrictList');
		$options = $model->getResource()->getOptions();
		return $options;
	}
	
	public function getCityOptions(){
		$options = array();
		$model = Mage::getModel('webportal/Directory_CityList');
		$options = $model->getResource()->getOptions();
		return $options;
	}
	
	public function getStatusOptions(){
		$options = array();
		$model = Mage::getModel('webportal/Status_Status');
		$options = $model->getResource()->getOptions();
		return $options;
	}
	
	
	public function getCustomerID(){
		return $this->customerID;
	}
	
	public function getHTMLFormID(){
		return "PersonalPhoneBook";
	}
	
	
}
