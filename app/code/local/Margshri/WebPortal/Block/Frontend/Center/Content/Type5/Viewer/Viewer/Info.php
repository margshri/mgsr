<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type5_Viewer_Viewer_Info extends Mage_Core_Block_Template{
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type5/viewer/viewer/entropy.phtml');
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		
		
		$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
		$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 5);
		
		$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
		$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 7);
		
		$customerImageCollection = Mage::getModel('customer/customer')->getCollection();
		$customerImageQuery = $customerImageCollection->getSelect()->reset()->from(array("main_table"=>$customerImageCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 140);
		
		
		
		
		
		
		$customerAddressCollection = Mage::getModel('common/Customer_Address')->getCollection();
		$customerAddressQuery = $customerAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID", "Address", "PinCode") ))
		->joinLeft(array("country"=>$customerAddressCollection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"))
		->joinLeft(array("state"=>$customerAddressCollection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"))
		->joinLeft(array("district"=>$customerAddressCollection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"))
		->joinLeft(array("city"=>$customerAddressCollection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"))
		->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$PERMANENT_ADDRESS);
		
		
		
		/*
		$customerPermanentAddressCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPermanentAddressQuery = $customerPermanentAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressCollection->getTable("webportal/customeraddressentity"), array("entity_id", "parent_id") ))
		->joinLeft(array("cei"=>$customerPermanentAddressCollection->getTable("webportal/customerentityint")), "main_table.entity_id=cei.value" ,array("value_id"))
		->where('cei.attribute_id =?', 160);
		

		$customerPAStreetCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPAStreetQuery = $customerPAStreetCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caet"=>$customerPAStreetCollection->getTable("webportal/customeraddressentitytext") ), "main_table.entity_id=caet.entity_id", array("value") )
		->where('caet.attribute_id =?', 25);
		
		
		$customerPACityCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPACityQuery = $customerPACityCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caev"=>$customerPACityCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
		->where('caev.attribute_id =?', 158);
		
		$customerPADistrictCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPADistrictQuery = $customerPADistrictCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caev"=>$customerPADistrictCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
		->where('caev.attribute_id =?', 157);
		
		$customerPAStateCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPAStateQuery = $customerPAStateCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caev"=>$customerPAStateCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
		->where('caev.attribute_id =?', 156);
		
		$customerPACountryCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPACountryQuery = $customerPACountryCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caev"=>$customerPACountryCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
		->where('caev.attribute_id =?', 155);
		
		$customerPAPinCodeCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPAPinCodeQuery = $customerPAPinCodeCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caev"=>$customerPAPinCodeCollection->getTable("webportal/customeraddressentityvarchar") ), "main_table.entity_id=caev.entity_id", array("value") )
		->where('caev.attribute_id =?', 30);
		*/
		
		$customerCollection = Mage::getModel('customer/customer')->getCollection();
		$customerQuery = $customerCollection->getSelect()->reset()->from(array("main_table"=>$customerCollection->getTable("webportal/customerentity")), array("entity_id","email") )
		->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"))
		->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"))
		->joinLeft(array("address"=>$customerAddressQuery), "main_table.entity_id = address.CustomerID", array("Address"=>"address.Address", "CityName"=>"address.CityName", "CityCode"=>"address.CityCode", "DistrictName" => "address.DistrictName", "DistrictCode" => "address.DistrictCode", "StateName"=>"address.StateName", "CountryName"=>"address.CountryName"  ))
		/*
		->joinLeft(array("address"=>$customerPAStreetQuery), "main_table.entity_id = address.parent_id", array("Address"=>"address.value"))
		->joinLeft(array("city"=>$customerPACityQuery), "main_table.entity_id = city.parent_id", array("CityName"=>"city.value"))
		->joinLeft(array("district"=>$customerPADistrictQuery), "main_table.entity_id = district.parent_id", array("DistrictName"=>"district.value"))
		->joinLeft(array("state"=>$customerPAStateQuery), "main_table.entity_id = state.parent_id", array("StateName"=>"state.value"))
		->joinLeft(array("country"=>$customerPACountryQuery), "main_table.entity_id = country.parent_id", array("CountryName"=>"country.value"))
		->joinLeft(array("pincode"=>$customerPAPinCodeQuery), "main_table.entity_id = pincode.parent_id", array("PinCode"=>"pincode.value"))
		*/
		->joinLeft(array("customerimage"=>$customerImageQuery), "main_table.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"));
		

		$viewCollection = Mage::getModel('webportal/Center_Content_Type5_Viewer_Viewer')->getCollection();
		$viewQuery =  $viewCollection->getSelect()->reset()->from(array("main_table"=>$viewCollection->getMainTable()), array("CustomerID"=>"main_table.CreatedBy", "LastViewDate" => new Zend_Db_Expr(" MAX(main_table.CreatedAt) ")) )
		->group("main_table.CreatedBy");
		
		
		$collection = Mage::getModel('webportal/Center_Content_Type5_Viewer_Viewer')->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("View"=>"main_table.Value", "StatusID"=>"main_table.StatusID", "CurrentCustomerID" => "main_table.CreatedBy" ) );
		$collection->getSelect()->joinLeft(array("customer"=>$customerQuery), "main_table.CreatedBy = customer.entity_id");
		$collection->getSelect()->joinInner(array("view"=>$viewQuery), "main_table.CreatedBy = view.CustomerID and main_table.CreatedAt = view.LastViewDate");
		
		$collection->getSelect()->order("main_table.ID desc");
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
	
	
	
}