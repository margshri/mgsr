<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type3_PhoneBook_General_Info extends Mage_Core_Block_Template{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type3/phonebook/general/entropy.phtml');
		
		
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
		
		$customerMobileCollection = Mage::getModel('customer/customer')->getCollection();
		$customerMobileQuery = $customerMobileCollection->getSelect()->reset()->from(array("main_table"=>$customerMobileCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 139);
		
		$customerGenderCollection = Mage::getModel('customer/customer')->getCollection();
		$customerGenderQuery = $customerGenderCollection->getSelect()->reset()->from(array("main_table"=>$customerGenderCollection->getTable("webportal/customerentityint"), array("entity_id", "value") ))
		->where('main_table.attribute_id =?', 18);
		
		
		$customerPermanentAddressCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPermanentAddressQuery = $customerPermanentAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID"=>"main_table.CustomerID", "CountryID"=>"main_table.CountryID", "StateID"=>"main_table.StateID", "DistrictID"=>"main_table.DistrictID", "CityID"=>"main_table.CityID" ) ))
		->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$PERMANENT_ADDRESS)
		->group('main_table.CustomerID');
		
		/*
		$customerPermanentAddressCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPermanentAddressQuery = $customerPermanentAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressCollection->getTable("webportal/customeraddressentity"), array("entity_id", "parent_id") ))
		->joinLeft(array("cei"=>$customerPermanentAddressCollection->getTable("webportal/customerentityint")), "main_table.entity_id=cei.value" ,array("value_id"))
		->where('cei.attribute_id =?', 160);
		
		
		$customerPACityCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPACityQuery = $customerPACityCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPACityCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 153);
			
		$customerPADistrictCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPADistrictQuery = $customerPADistrictCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPADistrictCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 152);
			
		$customerPAStateCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPAStateQuery = $customerPAStateCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPAStateCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 151);
			
		$customerPACountryCollection = Mage::getModel('customer/customer')->getCollection();
		$customerPACountryQuery = $customerPACountryCollection->getSelect()->reset()->from(array("main_table"=>$customerPermanentAddressQuery), array("parent_id"))
		->joinLeft(array("caei"=>$customerPACountryCollection->getTable("webportal/customeraddressentityint") ), "main_table.entity_id=caei.entity_id", array("value") )
		->where('caei.attribute_id =?', 154);
		*/
		
		
		
		/*
		$customerCollection = Mage::getModel('customer/customer')->getCollection();
		$customerQuery = $customerCollection->getSelect()->reset()->from(array("main_table"=>$customerCollection->getTable("webportal/customerentity")), array("entity_id","email") )
		->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"))
		->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"))
		->joinLeft(array("customerimage"=>$customerImageQuery), "main_table.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"))
		->joinLeft(array("customermobile"=>$customerMobileQuery), "main_table.entity_id = customermobile.entity_id", array("MobileNumber"=>"customermobile.value"))
		->joinLeft(array("gender"=>$customerGenderQuery), "main_table.entity_id = gender.entity_id", array("Gender"=>"gender.value"))
		->joinLeft(array("city"=>$customerPACityQuery), "main_table.entity_id = city.parent_id", array("CityID"=>"city.value"))
		->joinLeft(array("district"=>$customerPADistrictQuery), "main_table.entity_id = district.parent_id", array("DistrictID"=>"district.value"))
		->joinLeft(array("state"=>$customerPAStateQuery), "main_table.entity_id = state.parent_id", array("StateID"=>"state.value"))
		->joinLeft(array("country"=>$customerPACountryQuery), "main_table.entity_id = country.parent_id", array("CountryID"=>"country.value"));
		
		$collection = Mage::getModel('customer/customer')->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$customerQuery) );
		$collection->getSelect()->joinLeft(array("professional"=>$collection->getTable("webportal/apctwebprofessional")), "main_table.entity_id = professional.CustomerID");
		$collection->getSelect()->joinLeft(array("profession"=>$collection->getTable("webportal/apctwebprofession")), "professional.ProfessionID = profession.ID", array("ProfessionID"=>"profession.ID",  "ProfessionName"=>"profession.Value" ));
		$collection->getSelect()->where('professional.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		*/
		
		
		
		$customerCollection = Mage::getModel('customer/customer')->getCollection();
		$customerQuery = $customerCollection->getSelect()->reset()->from(array("main_table"=>$customerCollection->getTable("webportal/customerentity")), array("entity_id","email") )
		->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"))
		->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"))
		->joinLeft(array("customerimage"=>$customerImageQuery), "main_table.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"))
		->joinLeft(array("customermobile"=>$customerMobileQuery), "main_table.entity_id = customermobile.entity_id", array("MobileNumber"=>"customermobile.value"))
		->joinLeft(array("gender"=>$customerGenderQuery), "main_table.entity_id = gender.entity_id", array("Gender"=>"gender.value"))
		->joinLeft(array("padd"=>$customerPermanentAddressQuery), "main_table.entity_id = padd.CustomerID", array("CountryID"=>"padd.CountryID", "StateID"=>"padd.StateID", "DistrictID"=>"padd.DistrictID", "CityID"=>"padd.CityID" ));;
		
		
		$collection = Mage::getModel('customer/customer')->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$customerQuery));
		$collection->getSelect()->joinLeft(array("professional"=>$collection->getTable("webportal/apctwebprofessional")), "main_table.entity_id = professional.CustomerID");
		$collection->getSelect()->joinLeft(array("profession"=>$collection->getTable("webportal/apctwebprofession")), "professional.ProfessionID = profession.ID", array("ProfessionID"=>"profession.ID",  "ProfessionName"=>"profession.Value" ));
		$collection->getSelect()->where('professional.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		
		
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
		
		
		$collection->getSelect()->order("main_table.entity_id desc");
		
		$this->setCollection($collection);
	}

	protected function _prepareLayout(){
		parent::_prepareLayout();
		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		//$pager->setAvailableLimit(array(10=>10,20=>20,50=>50,100=>100));
		$pager->setAvailableLimit(array(20=>20));
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
	
}
