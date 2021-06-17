<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type7_Event_Event_Info extends Mage_Core_Block_Template{
	
	private $locationVO;
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type7/event/event/entropy.phtml');
		
		$currentDate = date('Y-m-d');
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		
		$this->locationVO = $locationVO;
		
		$collection = Mage::getModel("webportal/Center_Content_Type7_Event_Event")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode",  "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2" ,  "DynamicColumn1Value"=>"main_table.Category1Value", "DynamicColumn2Value"=>"main_table.Category2Value", "DynamicColumn3Value"=>"main_table.Category3Value", "Description"=>"main_table.Description", "PersonImage"=>"main_table.PersonImage", "EventDate"=>"main_table.EventDate", "LaunchDate"=>"main_table.LaunchDate", "EndDate"=>"main_table.EndDate" , "StateID" => "main_table.StateID", "DistrictID" => "main_table.DistrictID", "CityID" => "main_table.CityID" ));
		$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
		$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
		$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
		$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
		$collection->getSelect()->joinLeft(array("dynamiccolumn1"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category1ID = dynamiccolumn1.ID', array("DynamicColumn1Name"=>"dynamiccolumn1.Value"));
		$collection->getSelect()->joinLeft(array("dynamiccolumn2"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category2ID = dynamiccolumn2.ID', array("DynamicColumn2Name"=>"dynamiccolumn2.Value"));
		$collection->getSelect()->joinLeft(array("dynamiccolumn3"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category3ID = dynamiccolumn3.ID', array("DynamicColumn3Name"=>"dynamiccolumn3.Value"));
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		
		$collection->getSelect()->where('DATE(main_table.LaunchDate) <=?', $currentDate);
		$collection->getSelect()->where('DATE(main_table.EndDate) >=?', $currentDate);
		
		if($locationVO->getCountryID() != null){
			$collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
		}
		
		if($locationVO->getStateID() != null){
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.StateID =". $locationVO->getStateID() . " OR " . "main_table.StateID is null" ));
		}
		
		if($locationVO->getDistrictID() != null){
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.DistrictID =". $locationVO->getDistrictID() . " OR " . "main_table.DistrictID is null" ));
		}
		
		if($locationVO->getCityID() != null){
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.CityID =". $locationVO->getCityID() . " OR " . "main_table.CityID is null" ));
		}
		
		/*
		if($locationVO->getStateID() != null){
			$collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
		}
		if($locationVO->getDistrictID() != null){
			$collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
		}
		if($locationVO->getCityID()){
			$collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
		}
		*/
		
		
		$collection->getSelect()->Order('main_table.EventDate Asc');
		
		
		$this->setCollection($collection);
	
	}

	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		$pager->setAvailableLimit(array(10=>10));
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
		return 'Viewer';
	}
	
	public function getCurrentCustomerID(){
		$currentCustomerID = null;
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customerData = Mage::getSingleton('customer/session')->getCustomer();
		    $currentCustomerID = $customerData->getId();
		}

		return $currentCustomerID;
	}
	
	public function getLocationVO(){
		return $this->locationVO;
	}
	
}