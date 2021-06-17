<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type1_Bank_ATM_Info extends Mage_Core_Block_Template{

	protected $tableCode;
	
	public function __construct(){
		parent::__construct();
		
		$bankID = Mage::registry("CurrentBankID");
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		

		$model = Mage::getModel('webportal/Center_Content_Type1_Bank_ATM');
		$collection = $model->getCollection();
		
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Code"=>"main_table.Code" , "Address"=>"main_table.Address" ,  "BankID"=>"main_table.BankID"  ));
		$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
		$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
		$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
		$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
		$collection->getSelect()->joinLeft(array("bank"=>$collection->getTable('webportal/apctwebbank')), 'main_table.BankID = bank.ID', array("BankName"=>"bank.Value", "BankCode"=>"bank.Code"));
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
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
		$collection->getSelect()->where('main_table.BankID =?', $bankID);
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
}
