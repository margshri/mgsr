<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type1_Bank_Bank_Info extends Mage_Core_Block_Template{

	protected $tableCode;
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type1/bank/bank/entropy.phtml');
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */ 
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}

		
		$branchCollection = Mage::getModel('webportal/Center_Content_Type1_Bank_Branch')->getCollection();
		$branchQuery = $branchCollection->getSelect()->reset()->from(array("main_table"=>$branchCollection->getMainTable()), array("BankID"=>"main_table.BankID", "Branch"=> new Zend_Db_Expr("'Branch'") ))
		->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		if($locationVO->getCountryID() != null){
			$branchCollection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
		}
		if($locationVO->getStateID() != null){
			$branchCollection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
		}
		if($locationVO->getDistrictID() != null){
			$branchCollection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
		}
		if($locationVO->getCityID()){
			$branchCollection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
		}
		$branchCollection->getSelect()->group('main_table.BankID');
		
		
		$atmCollection = Mage::getModel('webportal/Center_Content_Type1_Bank_ATM')->getCollection();
		$atmQuery = $atmCollection->getSelect()->reset()->from(array("main_table"=>$atmCollection->getMainTable()), array("BankID"=>"main_table.BankID", "ATM"=> new Zend_Db_Expr("'ATM'") ))
		->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		if($locationVO->getCountryID() != null){
			$atmCollection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
		}
		if($locationVO->getStateID() != null){
			$atmCollection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
		}
		if($locationVO->getDistrictID() != null){
			$atmCollection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
		}
		if($locationVO->getCityID()){
			$atmCollection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
		}
		$atmCollection->getSelect()->group('main_table.BankID');

		$model = Mage::getModel('webportal/Master_Center_Content_Type1_Bank_Bank');
		$collection = $model->getCollection();
		$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value", "Code"=>"main_table.Code" ));
		$collection->getSelect()->joinRight(array("bank"=>$branchQuery), 'main_table.ID = bank.BankID', array("Branch"=>"bank.Branch"));
		$collection->getSelect()->joinLeft(array("atm"=>$atmQuery), 'main_table.ID = atm.BankID', array("ATM"=>"atm.ATM"));
		$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
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
