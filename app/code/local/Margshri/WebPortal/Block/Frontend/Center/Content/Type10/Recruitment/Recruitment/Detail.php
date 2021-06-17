<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type10_Recruitment_Recruitment_Detail extends Mage_Core_Block_Template{

	protected $tableCode;
	protected $title;
	
	public function __construct(){
		   
		parent::__construct();
		
		$recruitmentID = Mage::registry("CurrentRecuitmentID");
		$this->tableCode = Mage::registry("CurrentTableCode");
		
		
		$collection = Mage::getModel("webportal/Center_Content_Type10_Recruitment_Recruitment")->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode", "Department"=>"main_table.Department", "PostName"=>"main_table.PostName", "NoOfPost"=>"main_table.NoOfPost", "Qualification"=>"main_table.Qualification", "OpeningDate"=>"main_table.OpeningDate", "LastDate"=>"main_table.LastDate", "ExamDate"=>"main_table.ExamDate", "ApplyOnlineLink"=>"main_table.ApplyOnlineLink", "MoreDetailLink"=>"main_table.MoreDetailLink" ));
		$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
		$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
		$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
		$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$collection->getSelect()->where('main_table.ID =?', $recruitmentID);
		$this->setCollection($collection);
			
			
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
	
	public function getTableCode(){
		return $this->tableCode;
	}

}
