<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type6_ContactUs_ContactUs_Info extends Mage_Core_Block_Template{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type6/contactus/contactus/entropy.phtml');
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		
	
		$collection = Mage::getModel("webportal/Center_Content_Type6_ContactUs_ContactUs")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" ,  "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2" ,  "DynamicColumn1Value"=>"main_table.Category1Value", "DynamicColumn2Value"=>"main_table.Category2Value", "DynamicColumn3Value"=>"main_table.Category3Value", "Email"=>"main_table.Email", "PinCode"=>"main_table.PinCode",  "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
		$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
		$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
		$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value"));
		$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value"));		
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		if($locationVO->getCountryID() != null){
			$collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
		}
		if($locationVO->getStateID() != null){
			$collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
		}
		if($locationVO->getDistrictID() != null){
			$collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
		}
		if($locationVO->getCityID()){
			$collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
		}
		$collection->getSelect()->Order('main_table.Value Asc');
		$this->setCollection($collection);
			
	}

	protected function _prepareLayout(){
		parent::_prepareLayout();

		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		$pager->setAvailableLimit(array(10=>10,20=>20,50=>50,100=>100));
		$pager->setCollection($this->getCollection());
		$this->setChild('pager', $pager);
		$this->getCollection()->load();
		return $this;
	}

	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getHTMLFormID(){
		return "ContactUs";
	}
	
	
}
