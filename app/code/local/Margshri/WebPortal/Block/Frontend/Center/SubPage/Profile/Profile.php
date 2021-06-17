<?php
class Margshri_WebPortal_Block_Frontend_Center_SubPage_Profile_Profile extends Mage_Core_Block_Template{
	public function __construct(){
		parent::__construct();
		
		$customerID = $this->getRequest()->getParam("CustomerID");

		if($customerID != null){
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5)
			->where('main_table.entity_id =?', $customerID);
			
			$fatherNameCollection = Mage::getModel('customer/customer')->getCollection();
			$fatherNameQuery = $fatherNameCollection->getSelect()->reset()->from(array("main_table"=>$fatherNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 138)
			->where('main_table.entity_id =?', $customerID);
			
			$thoughtCollection = Mage::getModel('customer/customer')->getCollection();
			$thoughtQuery = $thoughtCollection->getSelect()->reset()->from(array("main_table"=>$thoughtCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 149)
			->where('main_table.entity_id =?', $customerID);
			
			$experienceCollection = Mage::getModel('customer/customer')->getCollection();
			$experienceQuery = $experienceCollection->getSelect()->reset()->from(array("main_table"=>$experienceCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 143)
			->where('main_table.entity_id =?', $customerID);
			
			$skillsCollection = Mage::getModel('customer/customer')->getCollection();
			$skillsQuery = $skillsCollection->getSelect()->reset()->from(array("main_table"=>$skillsCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 144)
			->where('main_table.entity_id =?', $customerID);
			
			$qualificationCollection = Mage::getModel('customer/customer')->getCollection();
			$qualificationQuery = $qualificationCollection->getSelect()->reset()->from(array("main_table"=>$qualificationCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 145)
			->where('main_table.entity_id =?', $customerID);
			
			$achievementCollection = Mage::getModel('customer/customer')->getCollection();
			$achievementQuery = $achievementCollection->getSelect()->reset()->from(array("main_table"=>$achievementCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 146)
			->where('main_table.entity_id =?', $customerID);
			
			
			$socialactivityCollection = Mage::getModel('customer/customer')->getCollection();
			$socialactivityQuery = $socialactivityCollection->getSelect()->reset()->from(array("main_table"=>$socialactivityCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 147)
			->where('main_table.entity_id =?', $customerID);
			
			$otheractivityCollection = Mage::getModel('customer/customer')->getCollection();
			$otheractivityQuery = $otheractivityCollection->getSelect()->reset()->from(array("main_table"=>$otheractivityCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 148)
			->where('main_table.entity_id =?', $customerID);
			
			$aboutwebsiteCollection = Mage::getModel('customer/customer')->getCollection();
			$aboutwebsiteQuery = $aboutwebsiteCollection->getSelect()->reset()->from(array("main_table"=>$aboutwebsiteCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 150)
			->where('main_table.entity_id =?', $customerID);
			
			
			$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
			$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 7)
			->where('main_table.entity_id =?', $customerID);
			
			$mobileNumberCollection = Mage::getModel('customer/customer')->getCollection();
			$mobileNumberQuery = $mobileNumberCollection->getSelect()->reset()->from(array("main_table"=>$mobileNumberCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 139)
			->where('main_table.entity_id =?', $customerID);
			
			$customerImageCollection = Mage::getModel('customer/customer')->getCollection();
			$customerImageQuery = $customerImageCollection->getSelect()->reset()->from(array("main_table"=>$customerImageCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 140)
			->where('main_table.entity_id =?', $customerID);
			
			$customerDOMCollection = Mage::getModel('customer/customer')->getCollection();
			$customerDOMQuery = $customerDOMCollection->getSelect()->reset()->from(array("main_table"=>$customerDOMCollection->getTable("webportal/customerentitydatetime"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 141)
			->where('main_table.entity_id =?', $customerID);
			
			
			$customerDOBCollection = Mage::getModel('customer/customer')->getCollection();
			$customerDOBQuery = $customerDOBCollection->getSelect()->reset()->from(array("main_table"=>$customerDOBCollection->getTable("webportal/customerentitydatetime"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 11)
			->where('main_table.entity_id =?', $customerID);
			
			
			
				
			$customerGenderCollection = Mage::getModel('customer/customer')->getCollection();
			$customerGenderQuery = $customerGenderCollection->getSelect()->reset()->from(array("main_table"=>$customerGenderCollection->getTable("webportal/customerentityint"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 18)
			->where('main_table.entity_id =?', $customerID);
			
			$customerRAddressCollection = Mage::getModel('common/Customer_Address')->getCollection();
			$customerRAddressQuery = $customerRAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerRAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID", "Address", "PinCode") ))
			->joinLeft(array("country"=>$customerRAddressCollection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"))
			->joinLeft(array("state"=>$customerRAddressCollection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"))
			->joinLeft(array("district"=>$customerRAddressCollection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"))
			->joinLeft(array("city"=>$customerRAddressCollection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"))
			->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$RESIDENCE_ADDRESS)
			->where('main_table.CustomerID =?', $customerID);
			
			
			$customerOAddressCollection = Mage::getModel('common/Customer_Address')->getCollection();
			$customerOAddressQuery = $customerOAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerOAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID", "Address", "PinCode") ))
			->joinLeft(array("country"=>$customerOAddressCollection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"))
			->joinLeft(array("state"=>$customerOAddressCollection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"))
			->joinLeft(array("district"=>$customerOAddressCollection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"))
			->joinLeft(array("city"=>$customerOAddressCollection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"))
			->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$OFFICE_ADDRESS)
			->where('main_table.CustomerID =?', $customerID);
			
			
			$customerCollection = Mage::getModel('customer/customer')->getCollection();
			$customerCollection->getSelect()->reset()->from(array("main_table"=>$customerCollection->getTable("webportal/customerentity")), array("entity_id","Email") );
			$customerCollection->getSelect()->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"));
			$customerCollection->getSelect()->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"));
			$customerCollection->getSelect()->joinLeft(array("mobilenumber"=>$mobileNumberQuery), "main_table.entity_id = mobilenumber.entity_id", array("MobileNumber"=>"mobilenumber.value"));
			$customerCollection->getSelect()->joinLeft(array("gender"=>$customerGenderQuery), "main_table.entity_id = gender.entity_id", array("Gender"=>"gender.value"));
			$customerCollection->getSelect()->joinLeft(array("dom"=>$customerDOMQuery), "main_table.entity_id = dom.entity_id", array("DOM"=>new Zend_Db_Expr(" date(dom.value) " ) ));
			$customerCollection->getSelect()->joinLeft(array("dob"=>$customerDOBQuery), "main_table.entity_id = dob.entity_id", array("DOB"=>new Zend_Db_Expr(" date(dob.value) " ) ));
			$customerCollection->getSelect()->joinLeft(array("fathername"=>$fatherNameQuery), "main_table.entity_id = fathername.entity_id", array("FatherName"=>"fathername.value"));
			$customerCollection->getSelect()->joinLeft(array("thought"=>$thoughtQuery), "main_table.entity_id = thought.entity_id", array("Thought"=>"thought.value"));
			$customerCollection->getSelect()->joinLeft(array("experience"=>$experienceQuery), "main_table.entity_id = experience.entity_id", array("Experience"=>"experience.value"));
			$customerCollection->getSelect()->joinLeft(array("skills"=>$skillsQuery), "main_table.entity_id = skills.entity_id", array("Skills"=>"skills.value"));
			$customerCollection->getSelect()->joinLeft(array("qualification"=>$qualificationQuery), "main_table.entity_id = qualification.entity_id", array("Qualification"=>"qualification.value"));
			$customerCollection->getSelect()->joinLeft(array("achievement"=>$achievementQuery), "main_table.entity_id = achievement.entity_id", array("Achievement"=>"achievement.value"));
			$customerCollection->getSelect()->joinLeft(array("socialactivity"=>$socialactivityQuery), "main_table.entity_id = socialactivity.entity_id", array("SocialActivity"=>"socialactivity.value"));
			$customerCollection->getSelect()->joinLeft(array("otheractivity"=>$otheractivityQuery), "main_table.entity_id = otheractivity.entity_id", array("OtherActivity"=>"otheractivity.value"));
			$customerCollection->getSelect()->joinLeft(array("aboutwebsite"=>$aboutwebsiteQuery), "main_table.entity_id = aboutwebsite.entity_id", array("AboutWebsite"=>"aboutwebsite.value"));
			$customerCollection->getSelect()->joinLeft(array("raddress"=>$customerRAddressQuery), "main_table.entity_id = raddress.CustomerID", array("RAddress"=>"raddress.Address", "RCityName"=>"raddress.CityName", "RCityCode"=>"raddress.CityCode", "RDistrictName" => "raddress.DistrictName", "RDistrictCode" => "raddress.DistrictCode", "RStateName"=>"raddress.StateName", "RCountryName"=>"raddress.CountryName", "RPinCode"=>"raddress.PinCode" , "RMobileNumber"=>"raddress.MobileNumber" ));
			$customerCollection->getSelect()->joinLeft(array("oaddress"=>$customerOAddressQuery), "main_table.entity_id = oaddress.CustomerID", array("OAddress"=>"oaddress.Address", "OCityName"=>"oaddress.CityName", "OCityCode"=>"oaddress.CityCode", "ODistrictName" => "oaddress.DistrictName", "ODistrictCode" => "oaddress.DistrictCode", "OStateName"=>"oaddress.StateName", "OCountryName"=>"oaddress.CountryName", "OPinCode"=>"oaddress.PinCode" , "OMobileNumber"=>"oaddress.MobileNumber" ));
			$customerCollection->getSelect()->joinLeft(array("customerimage"=>$customerImageQuery), "main_table.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"));
			$customerCollection->getSelect()->where('main_table.entity_id =?', $customerID);
			
			/*
			$collection = Mage::getModel('webportal/Center_Content_Type2_Professional_Professional')->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID") );
			$collection->getSelect()->joinLeft(array("profession"=>$collection->getTable("webportal/apctwebprofession")), "main_table.ProfessionID = profession.ID", array( "ProfessionID"=> "profession.ID", "Profession"=>"profession.Value"));
			$collection->getSelect()->joinLeft(array("customer"=>$customerQuery), "main_table.CustomerID = customer.entity_id");
			$collection->getSelect()->where("main_table.StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->where("main_table.ID =?", $id);
			*/
			
		    $this->setCollection($customerCollection);
			return;	
		}	
	
	}
	
}