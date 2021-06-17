<?php
class Margshri_WebPortal_Block_Frontend_HomePage_HomePage extends Mage_Core_Block_Template{

    private $locationVO;
    private $advertisements = array();
	
    public function __construct(){

    	parent::__construct();

    	$newLocationVO = array("CountryID"=>1,"StateID"=>null,"DistrictID"=>null,"CityID"=>null);
    	Mage::getSingleton('core/session')->setLocationVO($newLocationVO);
    	
    	/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
    	$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
    	if(!$locationVO){
    		$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
    	}
    	
    	$this->locationVO = $locationVO;
    	
    	$collection = Mage::getModel("webportal/Center_Content_Type7_Event_Event")->getCollection();
    	$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode",  "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2" ,  "DynamicColumn1Value"=>"main_table.Category1Value", "DynamicColumn2Value"=>"main_table.Category2Value", "DynamicColumn3Value"=>"main_table.Category3Value", "Description"=>"main_table.Description", "Image"=>"main_table.Image", "EventDate"=>"main_table.EventDate", "LaunchDate"=>"main_table.LaunchDate", "EndDate"=>"main_table.EndDate", "StateID" => "main_table.StateID", "DistrictID" => "main_table.DistrictID", "CityID" => "main_table.CityID" ));
    	$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
    	$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
    	$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
    	$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
    	$collection->getSelect()->joinLeft(array("dynamiccolumn1"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category1ID = dynamiccolumn1.ID', array("DynamicColumn1Name"=>"dynamiccolumn1.Value"));
    	$collection->getSelect()->joinLeft(array("dynamiccolumn2"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category2ID = dynamiccolumn2.ID', array("DynamicColumn2Name"=>"dynamiccolumn2.Value"));
    	$collection->getSelect()->joinLeft(array("dynamiccolumn3"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category3ID = dynamiccolumn3.ID', array("DynamicColumn3Name"=>"dynamiccolumn3.Value"));
    	$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
    	
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
		
    	$collection->getSelect()->Order('main_table.EventDate Asc');
    	$this->setCollection($collection);





	// for center advertisement

		// GET LOCATION VO
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		
		// GET TABLE CODE
		$currentCategoryObj = Mage::registry('current_category');
		$actionObj = $this->getAction();
		if($currentCategoryObj){
			$this->tableCode = $currentCategoryObj->getUrl_key();
			if($this->tableCode == "home"){
				$this->tableCode = 'apctwebhome';
			}
		}else{
			$this->tableCode = 'apctwebhome';
		}		
			
		// SET TABLE CODE FOR TABLE TYPE 1 (BANK)


		if($actionObj){
			//if($actionObj->hasAction("login")){ $this->tableCode = "apctweblogin"; exit;  }
			if($actionObj->hasAction("branch")) $this->tableCode = "apctwebbank";
			if($actionObj->hasAction("atm")) $this->tableCode = "apctwebbank"; 
		}
	
		$tableCodeArray = array($this->tableCode, 'apctwebdefault');		
		$collection = Mage::getModel("webportal/FileUpload_ImageUpload_Advertisement")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode",  "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2" ,  "DynamicColumn1Value"=>"main_table.Category1Value", "DynamicColumn2Value"=>"main_table.Category2Value", "DynamicColumn3Value"=>"main_table.Category3Value", "TypeID"=>"main_table.TypeID", "ImagePath"=>"main_table.ImagePath", "LaunchDate"=>"main_table.LaunchDate", "EndDate"=>"main_table.EndDate", "TableCode"=>"main_table.TableCode", "Order"=> "main_table.Order"));
		$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
		$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
		$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
		$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$collection->getSelect()->where('main_table.TypeID =?', Margshri_WebPortal_VO_FileUpload_ImageUpload_AdvertisementTypeVO::$MIDDLE_BAR);
		$collection->getSelect()->where('main_table.TableCode IN (?)', $tableCodeArray);
		
		if($locationVO->getCountryID() != null){
			$collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
		}
		
		if($locationVO->getStateID() != null){
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.StateID =". $locationVO->getStateID() . " OR " . "main_table.StateID is null" ));
		}else{
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.StateID is null" ));
		}
		
		if($locationVO->getDistrictID() != null){
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.DistrictID =". $locationVO->getDistrictID() . " OR " . "main_table.DistrictID is null" ));
		}else{
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.DistrictID is null" ));
		}
		
		if($locationVO->getCityID()){
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.CityID =". $locationVO->getCityID() . " OR " . "main_table.CityID is null" ));
		}else{
			$collection->getSelect()->where(new Zend_Db_Expr("main_table.CityID is null" ));
		}
		
		$collection->getSelect()->Order('main_table.Order Asc');
		
		
		//$this->setCollection($collection);
                $this->advertisements = $collection;


    }
    
    
    public function getLocationVO(){
    	return $this->locationVO;	
    }


    public function getAdvertisements(){
    	return $this->advertisements;
    }


}
