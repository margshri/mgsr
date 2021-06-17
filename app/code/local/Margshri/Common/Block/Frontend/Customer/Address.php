<?php
class Margshri_Common_Block_Frontend_Customer_Address extends Mage_Customer_Block_Account_Dashboard{
	
	protected $customerID = null;
	
	public function __construct(){
		parent::__construct();
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customerData = Mage::getSingleton('customer/session')->getCustomer();
			$this->customerID = $customerData->getId();
		}
		
	}
	

	public function getRAddressVO(){
		$options = array();
		$model = Mage::getModel('common/Customer_Address');
		$dataObj = $model->getResource()->getByCustomerIDAndTypeID($this->customerID ,Margshri_Common_VO_Customer_AddressTypeVO::$RESIDENCE_ADDRESS);
	
		if($dataObj !== false){
			$rAddressDTO = new Margshri_Common_VO_Customer_AddressVO();
			/* @var $rAddressVO Margshri_Common_VO_Customer_AddressVO */
			$rAddressVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($rAddressDTO, $dataObj);
		}
		return $rAddressVO;
	}
	
	

	public function getOAddressVO(){
		$options = array();
		$model = Mage::getModel('common/Customer_Address');
		$dataObj = $model->getResource()->getByCustomerIDAndTypeID($this->customerID ,Margshri_Common_VO_Customer_AddressTypeVO::$OFFICE_ADDRESS);
	
		if($dataObj !== false){
			$oAddressDTO = new Margshri_Common_VO_Customer_AddressVO();
			/* @var $oAddressVO Margshri_Common_VO_Customer_AddressVO */
			$oAddressVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($oAddressDTO, $dataObj);
		}
		return $oAddressVO;
	}
	
	public function getPAddressVO(){
		$options = array();
		$model = Mage::getModel('common/Customer_Address');
		$dataObj = $model->getResource()->getByCustomerIDAndTypeID($this->customerID ,Margshri_Common_VO_Customer_AddressTypeVO::$PERMANENT_ADDRESS);
		
		if($dataObj !== false){
			$pAddressDTO = new Margshri_Common_VO_Customer_AddressVO();
			/* @var $pAddressVO Margshri_Common_VO_Customer_AddressVO */
			$pAddressVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($pAddressDTO, $dataObj);
		}	
		return $pAddressVO;
	}
	
	
	
	
	public function getBAddressVO(){
		$options = array();
		$model = Mage::getModel('common/Customer_Address');
		$dataObj = $model->getResource()->getByCustomerIDAndTypeID($this->customerID ,Margshri_Common_VO_Customer_AddressTypeVO::$BILLING_ADDRESS);
	
		if($dataObj !== false){
			$bAddressDTO = new Margshri_Common_VO_Customer_AddressVO();
			/* @var $bAddressVO Margshri_Common_VO_Customer_AddressVO */
			$bAddressVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($bAddressDTO, $dataObj);
		}
		return $bAddressVO;
	}
	
	
	public function getSAddressVO(){
		$options = array();
		$model = Mage::getModel('common/Customer_Address');
		$dataObj = $model->getResource()->getByCustomerIDAndTypeID($this->customerID ,Margshri_Common_VO_Customer_AddressTypeVO::$SHIPPING_ADDRESS);
	
		if($dataObj !== false){
			$sAddressDTO = new Margshri_Common_VO_Customer_AddressVO();
			/* @var $sAddressVO Margshri_Common_VO_Customer_AddressVO */
			$sAddressVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($sAddressDTO, $dataObj);
		}
		return $sAddressVO;
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
	
	
	public function getPageTitle(){
		return Mage::registry("CurrentPageTitle");
	}
	

	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
}
