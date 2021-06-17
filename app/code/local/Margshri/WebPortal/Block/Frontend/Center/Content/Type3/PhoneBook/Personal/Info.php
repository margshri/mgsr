<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type3_PhoneBook_Personal_Info extends Mage_Core_Block_Template{

	protected $customerID = null; 
	
	public function __construct(){
		parent::__construct();
		
		if(Mage::getSingleton('customer/session')->isLoggedIn()) {
			$customerData = Mage::getSingleton('customer/session')->getCustomer();
			$this->customerID = $customerData->getId();
		}
		
		$this->setTemplate('webportal/center/content/type3/phonebook/personal/entropy.phtml');	
		$collection = Mage::getModel("webportal/Center_Content_Type3_PhoneBook_Personal_Personal")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Name"=>"main_table.Name" , "Address"=>"main_table.Address" ,  "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2",  "DOB"=>"main_table.DOB", "Email"=>"main_table.Email", "Relation"=>"main_table.Relation",   "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
		$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
		$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
		$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value"));
		$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value"));		
		//$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$collection->getSelect()->where('main_table.UserID =?', $this->customerID);
		$collection->getSelect()->Order('main_table.Name Asc');
		$this->setCollection($collection);
	}

	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		$pager->setAvailableLimit(array(10=>10));
		//$pager->setAvailableLimit(array(10=>10,20=>20,50=>50,100=>100));
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
	
	public function getCustomerID(){
		return $this->customerID;
	}
	
	public function getHTMLFormID(){
		return "PersonalPhoneBook";
	}
	
	
}
