<?php
class Margshri_WebPortal_Block_Frontend_Search_Info extends Mage_Core_Block_Template{
	
	protected $searchKey;
	protected $tableCode;
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/search/entropy.phtml');
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		
		$this->searchKey = Mage::registry("CurrentSearchKey");
		
		if($this->searchKey != null && $this->searchKey != ""){
		
		
			$model = Mage::getModel('webportal/Master_Table_Table');
			$collection = $model->getCollection();
			$collections=array();
			
			
			$branchCollection = Mage::getModel('webportal/Center_Content_Type1_Bank_Branch')->getCollection();
			$branchQuery = $branchCollection->getSelect()->reset()->from(array("main_table"=>$branchCollection->getMainTable()), array("BankID"=>"main_table.BankID", "Branch"=> new Zend_Db_Expr("'Branch'") ))
			->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			if($locationVO->getCountryID() != null) $collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
			if($locationVO->getStateID() != null) $collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
			if($locationVO->getDistrictID() != null) $collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
			if($locationVO->getCityID()) $collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
			$branchCollection->getSelect()->group('main_table.BankID');
							
							
			$atmCollection = Mage::getModel('webportal/Center_Content_Type1_Bank_ATM')->getCollection();
			$atmQuery = $atmCollection->getSelect()->reset()->from(array("main_table"=>$atmCollection->getMainTable()), array("BankID"=>"main_table.BankID", "ATM"=> new Zend_Db_Expr("'ATM'") ))
			->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			if($locationVO->getCountryID() != null) $collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
			if($locationVO->getStateID() != null) $collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
			if($locationVO->getDistrictID() != null) $collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
			if($locationVO->getCityID()) $collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
			$atmCollection->getSelect()->group('main_table.BankID');
	
			$collection = $model->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable('webportal/apctwebbank')), array("ID"=>"main_table.ID", "Value"=>"main_table.Value", "Code"=>"main_table.Code", "WebsiteLink"=>"main_table.WebsiteLink",  'TableTypeID'=>new Zend_Db_Expr("1"), 'TableCode'=>new Zend_Db_Expr("'apctwebbank'")  ));
			$collection->getSelect()->joinRight(array("bank"=>$branchQuery), 'main_table.ID = bank.BankID', array("Branch"=>"bank.Branch"));
			$collection->getSelect()->joinLeft(array("atm"=>$atmQuery), 'main_table.ID = atm.BankID', array("ATM"=>"atm.ATM"));
			$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->Where(new Zend_Db_Expr("main_table.Value LIKE '%".$this->searchKey."%' OR
				main_table.Code LIKE '%".$this->searchKey."%'  OR
				main_table.WebsiteLink LIKE '%".$this->searchKey."%' " ) );
			$collection->getSelect()->Order('main_table.Value Asc');
			$collections[] = $collection;			 
						
	
			$collection = $model->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable('webportal/apctwebbankbranch')), array("ID"=>"main_table.ID", "Value"=>"main_table.Value", "Code"=>"main_table.Code", "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode", "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2", "IFSCCode"=>"main_table.IFSCCode", "MICRCode"=>"main_table.MICRCode", 'TableTypeID'=>new Zend_Db_Expr("1"), 'TableCode'=>new Zend_Db_Expr("'apctwebbankbranch'") ));
			$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
			$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
			$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
			$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
			$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->Where(new Zend_Db_Expr("main_table.Value LIKE '%".$this->searchKey."%' OR
				main_table.Code LIKE '%".$this->searchKey."%'  OR	
				main_table.MobileNumber1 LIKE '%".$this->searchKey."%'  OR
				main_table.MobileNumber2 LIKE '%".$this->searchKey."%'  OR
				main_table.LandLineNumber LIKE '%".$this->searchKey."%' OR
				main_table.Address LIKE '%".$this->searchKey."%' OR
				main_table.PinCode LIKE '%".$this->searchKey."%' OR
				main_table.IFSCCode LIKE '%".$this->searchKey."%' OR
				main_table.MICRCode LIKE '%".$this->searchKey."%' OR
				state.Value LIKE '%".$this->searchKey."%' OR
				district.Value LIKE '%".$this->searchKey."%' OR
				city.Value LIKE '%".$this->searchKey."%' " ) );
			if($locationVO->getCountryID() != null) $collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
			if($locationVO->getStateID() != null) $collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
			if($locationVO->getDistrictID() != null) $collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
			if($locationVO->getCityID()) $collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
			$collection->getSelect()->Order('main_table.Value Asc');
			$collections[] = $collection;
			
	
	
			$collection = $model->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable('webportal/apctwebbankatm')), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , 'TableTypeID'=>new Zend_Db_Expr("1"), "PinCode"=>"main_table.PinCode", 'TableTypeID'=>new Zend_Db_Expr("1") , 'TableCode'=>new Zend_Db_Expr("'apctwebbankatm'") ));
			$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
			$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
			$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
			$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
			$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->Where(new Zend_Db_Expr("main_table.Value LIKE '%".$this->searchKey."%' OR
				main_table.Address LIKE '%".$this->searchKey."%' OR
				main_table.PinCode LIKE '%".$this->searchKey."%' OR
				state.Value LIKE '%".$this->searchKey."%' OR
				district.Value LIKE '%".$this->searchKey."%' OR
				city.Value LIKE '%".$this->searchKey."%' " ) );
				
			if($locationVO->getCountryID() != null) $collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
			if($locationVO->getStateID() != null) $collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
			if($locationVO->getDistrictID() != null) $collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
			if($locationVO->getCityID()) $collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
			$collection->getSelect()->Order('main_table.Value Asc');
			$collections[] = $collection;
	
	
	
	
	
	
			$collection = $model->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getTable('webportal/apctwebfirm')), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode", "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2" ,  "DynamicColumn1Value"=>"main_table.Category1Value", "DynamicColumn2Value"=>"main_table.Category2Value", "IsPaid"=>"main_table.IsPaid", 'TableCode'=>"main_table.TableCodes",
					'TableTypeID'=>new Zend_Db_Expr("8"), "SubPageTableCode"=>"main_table.SubPageTableCode", "WebsiteLink"=>"main_table.WebsiteLink", "DynamicColumn3Value"=>"main_table.Category3Value", "ContactPersonName"=>"main_table.ContactPersonName", "BusinessDay"=>"main_table.BusinessDay", "BusinessHours"=>"main_table.BusinessHours", "SortName"=>"main_table.SortName", "PaymentMethod"=>"main_table.PaymentMethod", "Area"=>"main_table.Area", "CustomerCareNumber"=>"main_table.CustomerCareNumber", "EmergencyNumber"=>"main_table.EmergencyNumber", "TollFree"=>"main_table.TollFree", "Email"=>"main_table.Email"));
			$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
			$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
			$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
			$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
			$collection->getSelect()->joinLeft(array("dynamiccolumn1"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category1ID = dynamiccolumn1.ID', array("DynamicColumn1Name"=>"dynamiccolumn1.Value"));
			$collection->getSelect()->joinLeft(array("dynamiccolumn2"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category2ID = dynamiccolumn2.ID', array("DynamicColumn2Name"=>"dynamiccolumn2.Value"));
			$collection->getSelect()->joinLeft(array("dynamiccolumn3"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category3ID = dynamiccolumn3.ID', array("DynamicColumn3Name"=>"dynamiccolumn3.Value"));
			$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->Where(new Zend_Db_Expr("main_table.Value LIKE '%".$this->searchKey."%' OR 
					main_table.ContactPersonName LIKE '%".$this->searchKey."%'  OR
					main_table.SortName LIKE '%".$this->searchKey."%'  OR
					main_table.Area LIKE '%".$this->searchKey."%'  OR
					main_table.CustomerCareNumber LIKE '%".$this->searchKey."%'  OR
					main_table.EmergencyNumber LIKE '%".$this->searchKey."%'  OR
					main_table.TollFree LIKE '%".$this->searchKey."%'  OR
					main_table.Email LIKE '%".$this->searchKey."%'  OR
					main_table.MobileNumber1 LIKE '%".$this->searchKey."%'  OR 
					main_table.MobileNumber2 LIKE '%".$this->searchKey."%'  OR 
					main_table.LandLineNumber LIKE '%".$this->searchKey."%' OR 
					main_table.Address LIKE '%".$this->searchKey."%' OR 
					main_table.PinCode LIKE '%".$this->searchKey."%' OR 
					state.Value LIKE '%".$this->searchKey."%' OR 
					district.Value LIKE '%".$this->searchKey."%' OR 
					city.Value LIKE '%".$this->searchKey."%' OR 
					dynamiccolumn1.Value LIKE '%".$this->searchKey."%' OR 
					dynamiccolumn2.Value LIKE '%".$this->searchKey."%' OR 
					dynamiccolumn3.Value LIKE '%".$this->searchKey."%' OR
					main_table.Category1Value LIKE '%".$this->searchKey."%' OR 
					main_table.Category2Value LIKE '%".$this->searchKey."%' OR 
					main_table.Category3Value LIKE '%".$this->searchKey."%' OR
					main_table.WebsiteLink LIKE '%".$this->searchKey."%' " ) );
			
			if($locationVO->getCountryID() != null) $collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
			if($locationVO->getStateID() != null) $collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
			if($locationVO->getDistrictID() != null) $collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID()); 
			if($locationVO->getCityID()) $collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID()); 
			$collection->getSelect()->Order('main_table.Value Asc');
			$collections[] = $collection;
		}
		
		$preSearchVOs = array();
		$postSearchVOs = array();
		$searchVOs = array();
		foreach ($collections as $collection){
			foreach ($collection as $row){
				$searchDTO  = new Margshri_WebPortal_VO_Search_SearchVO();
				$searchVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($searchDTO, $row->getData());
				$searchVO->setTableCode($row->getData('TableCode'));
		        $searchVO->setSubPageTableCode($row->getData('SubPageTableCode'));
				$searchVO->setTableTypeID($row->getData('TableTypeID'));
				
				if($row->getData('IsPaid') == 1){
					$preSearchVOs[] = $searchVO;  
				}else{
					$postSearchVOs[] = $searchVO;
				}
			}
		}
		
		if(sizeof($preSearchVOs) > 0 && sizeof($postSearchVOs) > 0){
			$searchVOs = array_merge($preSearchVOs,$postSearchVOs);
		}elseif(sizeof($preSearchVOs) > 0){
			$searchVOs = $preSearchVOs;
		}elseif(sizeof($postSearchVOs) > 0){
			$searchVOs = $postSearchVOs;
		}
			
		Mage::register('CurrentSearchVOs', $searchVOs);
	}
	
	public function getSearchVOs(){
		return Mage::registry("CurrentSearchVOs");
	}
	
	public function getPageTitle(){
		return 'Search Result';
	}
	

	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
	
}
