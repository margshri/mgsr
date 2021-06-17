<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type2_Professional_Professional_Profile extends Mage_Core_Block_Template{
	public function __construct(){
		parent::__construct();
		
		$id = $this->getRequest()->getParam("ID");
		
		$professionalModel   = Mage::getModel('webportal/Center_Content_Type2_Professional_Professional');
		$professionalDataObj = $professionalModel->getResource()->getByID($id);
		
		
		//$professionModel = Mage::getModel('webportal/Master_Center_Content_Type2_Profession_Profession');
		//$dataObj = $professionModel->getResource()->getByCode($this->tableCode);
		//$professionDTO = new Margshri_WebPortal_VO_Master_Center_Content_Type2_Profession_ProfessionVO();
		/* @var $professionVO Margshri_WebPortal_VO_Master_Center_Content_Type2_Profession_ProfessionVO */
		//$professionVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($professionDTO, $dataObj);
		
		if($professionalDataObj !== false){
			
			$professionalDTO = new Margshri_WebPortal_VO_Center_Content_Type2_Professional_ProfessionalVO();
			/* @var $professionalVO Margshri_WebPortal_VO_Center_Content_Type2_Professional_ProfessionalVO */
			$professionalVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($professionalDTO, $professionalDataObj);
			
			
			
			$firstNameCollection = Mage::getModel('customer/customer')->getCollection();
			$firstNameQuery = $firstNameCollection->getSelect()->reset()->from(array("main_table"=>$firstNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 5)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$fatherNameCollection = Mage::getModel('customer/customer')->getCollection();
			$fatherNameQuery = $fatherNameCollection->getSelect()->reset()->from(array("main_table"=>$fatherNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 138)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$thoughtCollection = Mage::getModel('customer/customer')->getCollection();
			$thoughtQuery = $thoughtCollection->getSelect()->reset()->from(array("main_table"=>$thoughtCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 149)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			
			$companyNameCollection = Mage::getModel('customer/customer')->getCollection();
			$companyNameQuery = $companyNameCollection->getSelect()->reset()->from(array("main_table"=>$companyNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 142)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			
			$experienceCollection = Mage::getModel('customer/customer')->getCollection();
			$experienceQuery = $experienceCollection->getSelect()->reset()->from(array("main_table"=>$experienceCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 143)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$skillsCollection = Mage::getModel('customer/customer')->getCollection();
			$skillsQuery = $skillsCollection->getSelect()->reset()->from(array("main_table"=>$skillsCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 144)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$qualificationCollection = Mage::getModel('customer/customer')->getCollection();
			$qualificationQuery = $qualificationCollection->getSelect()->reset()->from(array("main_table"=>$qualificationCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 145)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$achievementCollection = Mage::getModel('customer/customer')->getCollection();
			$achievementQuery = $achievementCollection->getSelect()->reset()->from(array("main_table"=>$achievementCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 146)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			
			$socialactivityCollection = Mage::getModel('customer/customer')->getCollection();
			$socialactivityQuery = $socialactivityCollection->getSelect()->reset()->from(array("main_table"=>$socialactivityCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 147)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$otheractivityCollection = Mage::getModel('customer/customer')->getCollection();
			$otheractivityQuery = $otheractivityCollection->getSelect()->reset()->from(array("main_table"=>$otheractivityCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 148)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$aboutwebsiteCollection = Mage::getModel('customer/customer')->getCollection();
			$aboutwebsiteQuery = $aboutwebsiteCollection->getSelect()->reset()->from(array("main_table"=>$aboutwebsiteCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 150)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			
			$lastNameCollection = Mage::getModel('customer/customer')->getCollection();
			$lastNameQuery = $lastNameCollection->getSelect()->reset()->from(array("main_table"=>$lastNameCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 7)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$mobileNumberCollection = Mage::getModel('customer/customer')->getCollection();
			$mobileNumberQuery = $mobileNumberCollection->getSelect()->reset()->from(array("main_table"=>$mobileNumberCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 139)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$customerImageCollection = Mage::getModel('customer/customer')->getCollection();
			$customerImageQuery = $customerImageCollection->getSelect()->reset()->from(array("main_table"=>$customerImageCollection->getTable("webportal/customerentityvarchar"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 140)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$customerDOMCollection = Mage::getModel('customer/customer')->getCollection();
			$customerDOMQuery = $customerDOMCollection->getSelect()->reset()->from(array("main_table"=>$customerDOMCollection->getTable("webportal/customerentitydatetime"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 141)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			
			$customerDOBCollection = Mage::getModel('customer/customer')->getCollection();
			$customerDOBQuery = $customerDOBCollection->getSelect()->reset()->from(array("main_table"=>$customerDOBCollection->getTable("webportal/customerentitydatetime"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 11)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			
			
				
			$customerGenderCollection = Mage::getModel('customer/customer')->getCollection();
			$customerGenderQuery = $customerGenderCollection->getSelect()->reset()->from(array("main_table"=>$customerGenderCollection->getTable("webportal/customerentityint"), array("entity_id", "value") ))
			->where('main_table.attribute_id =?', 18)
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$customerRAddressCollection = Mage::getModel('common/Customer_Address')->getCollection();
			$customerRAddressQuery = $customerRAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerRAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID", "Address", "PinCode") ))
			->joinLeft(array("country"=>$customerRAddressCollection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"))
			->joinLeft(array("state"=>$customerRAddressCollection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"))
			->joinLeft(array("district"=>$customerRAddressCollection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"))
			->joinLeft(array("city"=>$customerRAddressCollection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"))
			->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$RESIDENCE_ADDRESS)
			->where('main_table.CustomerID =?', $professionalVO->getCustomerID());
			
			
			$customerOAddressCollection = Mage::getModel('common/Customer_Address')->getCollection();
			$customerOAddressQuery = $customerOAddressCollection->getSelect()->reset()->from(array("main_table"=>$customerOAddressCollection->getTable("common/apctcustomeraddress"), array("CustomerID", "Address", "PinCode") ))
			->joinLeft(array("country"=>$customerOAddressCollection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"))
			->joinLeft(array("state"=>$customerOAddressCollection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"))
			->joinLeft(array("district"=>$customerOAddressCollection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"))
			->joinLeft(array("city"=>$customerOAddressCollection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"))
			->where('main_table.TypeID =?', Margshri_Common_VO_Customer_AddressTypeVO::$OFFICE_ADDRESS)
			->where('main_table.CustomerID =?', $professionalVO->getCustomerID());
			
			
			$customerCollection = Mage::getModel('customer/customer')->getCollection();
			$customerQuery = $customerCollection->getSelect()->reset()->from(array("main_table"=>$customerCollection->getTable("webportal/customerentity")), array("entity_id","Email") )
			->joinLeft(array("firstname"=>$firstNameQuery), "main_table.entity_id = firstname.entity_id", array("FirstName"=>"firstname.value"))
			->joinLeft(array("lastname"=>$lastNameQuery), "main_table.entity_id = lastname.entity_id", array("LastName"=>"lastname.value"))
			->joinLeft(array("mobilenumber"=>$mobileNumberQuery), "main_table.entity_id = mobilenumber.entity_id", array("MobileNumber"=>"mobilenumber.value"))
			->joinLeft(array("gender"=>$customerGenderQuery), "main_table.entity_id = gender.entity_id", array("Gender"=>"gender.value"))
			->joinLeft(array("dom"=>$customerDOMQuery), "main_table.entity_id = dom.entity_id", array("DOM"=>new Zend_Db_Expr(" date(dom.value) " ) ))
			->joinLeft(array("dob"=>$customerDOBQuery), "main_table.entity_id = dob.entity_id", array("DOB"=>new Zend_Db_Expr(" date(dob.value) " ) ))
			->joinLeft(array("fathername"=>$fatherNameQuery), "main_table.entity_id = fathername.entity_id", array("FatherName"=>"fathername.value"))
			->joinLeft(array("thought"=>$thoughtQuery), "main_table.entity_id = thought.entity_id", array("Thought"=>"thought.value"))
			->joinLeft(array("companyname"=>$companyNameQuery), "main_table.entity_id = companyname.entity_id", array("CompanyName"=>"companyname.value"))
			->joinLeft(array("experience"=>$experienceQuery), "main_table.entity_id = experience.entity_id", array("Experience"=>"experience.value"))
			->joinLeft(array("skills"=>$skillsQuery), "main_table.entity_id = skills.entity_id", array("Skills"=>"skills.value"))
			->joinLeft(array("qualification"=>$qualificationQuery), "main_table.entity_id = qualification.entity_id", array("Qualification"=>"qualification.value"))
			->joinLeft(array("achievement"=>$achievementQuery), "main_table.entity_id = achievement.entity_id", array("Achievement"=>"achievement.value"))
			->joinLeft(array("socialactivity"=>$socialactivityQuery), "main_table.entity_id = socialactivity.entity_id", array("SocialActivity"=>"socialactivity.value"))
			->joinLeft(array("otheractivity"=>$otheractivityQuery), "main_table.entity_id = otheractivity.entity_id", array("OtherActivity"=>"otheractivity.value"))
			->joinLeft(array("aboutwebsite"=>$aboutwebsiteQuery), "main_table.entity_id = aboutwebsite.entity_id", array("AboutWebsite"=>"aboutwebsite.value"))
			
			->joinLeft(array("raddress"=>$customerRAddressQuery), "main_table.entity_id = raddress.CustomerID", array("RAddress"=>"raddress.Address", "RCityName"=>"raddress.CityName", "RCityCode"=>"raddress.CityCode", "RDistrictName" => "raddress.DistrictName", "RDistrictCode" => "raddress.DistrictCode", "RStateName"=>"raddress.StateName", "RCountryName"=>"raddress.CountryName", "RPinCode"=>"raddress.PinCode" , "RMobileNumber"=>"raddress.MobileNumber" ))
			->joinLeft(array("oaddress"=>$customerOAddressQuery), "main_table.entity_id = oaddress.CustomerID", array("OAddress"=>"oaddress.Address", "OCityName"=>"oaddress.CityName", "OCityCode"=>"oaddress.CityCode", "ODistrictName" => "oaddress.DistrictName", "ODistrictCode" => "oaddress.DistrictCode", "OStateName"=>"oaddress.StateName", "OCountryName"=>"oaddress.CountryName", "OPinCode"=>"oaddress.PinCode" , "OMobileNumber"=>"oaddress.MobileNumber" ))
			->joinLeft(array("customerimage"=>$customerImageQuery), "main_table.entity_id = customerimage.entity_id", array("CustomerImage"=>"customerimage.value"))
			->where('main_table.entity_id =?', $professionalVO->getCustomerID());
			
			$collection = Mage::getModel('webportal/Center_Content_Type2_Professional_Professional')->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID") );
			$collection->getSelect()->joinLeft(array("profession"=>$collection->getTable("webportal/apctwebprofession")), "main_table.ProfessionID = profession.ID", array( "ProfessionID"=> "profession.ID", "Profession"=>"profession.Value"));
			$collection->getSelect()->joinLeft(array("customer"=>$customerQuery), "main_table.CustomerID = customer.entity_id");
			$collection->getSelect()->where("main_table.StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->where("main_table.ID =?", $id);
			
			$this->setCollection($collection);
			return;	
		}	
	
	}

	 
	
}