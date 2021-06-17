<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type10_Recruitment_Recruitment_Info extends Mage_Core_Block_Template{

	protected $tableCode;
	protected $title;
	
	public function __construct(){
		   
		parent::__construct();
		$this->setTemplate('webportal/center/content/type10/recruitment/recruitment/entropy.phtml');
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		
		$this->tableCode = Mage::registry("CurrentTableCode");
		
		$recruitmentTypeModel = mage::getModel("webportal/Master_Center_Content_Type10_Recruitment_RecruitmentType");
		$dataObj = $recruitmentTypeModel->getResource()->getByCode($this->tableCode);
		
		if($dataObj !== false){
			$recruitmentTypeDTO = new Margshri_WebPortal_VO_Master_Center_Content_Type10_Recruitment_RecruitmentTypeVO();
			/* @var $recruitmentTypeVO Margshri_WebPortal_VO_Master_Center_Content_Type10_Recruitment_$recruitmentTypeVO */
			$recruitmentTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($recruitmentTypeDTO, $dataObj);
			$this->title = $recruitmentTypeVO->getValue(); 
		
			$collection = Mage::getModel("webportal/Center_Content_Type10_Recruitment_Recruitment")->getCollection();
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode",  "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
			$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
			$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
			$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
			$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->where('main_table.RecruitmentTypeID =?', $recruitmentTypeVO->getID());
			
			/*
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
			*/
			
			$collection->getSelect()->Order('main_table.Value Asc');
			$this->setCollection($collection);
		}	
	}

	protected function _prepareLayout(){
		parent::_prepareLayout();

		$pager = $this->getLayout()->createBlock('page/html_pager', 'custom.pager');
		//$pager->setAvailableLimit(array(2=>2, 5=>5,10=>10,20=>20,'all'=>'all'));
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

	public function getTableCode(){
		return $this->tableCode;
	}
	
}
