<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type10_Info extends Mage_Core_Block_Template{

	protected $tableCode;
	protected $type10Code;
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type10/entropy.phtml');
		
		/* @var $locationVO  Margshri_WebPortal_VO_LocationSelector_LocationVO */
		$locationVO = unserialize(Mage::getSingleton('core/session')->getData('LocationVO'));
		if(!$locationVO){
			$locationVO = new Margshri_WebPortal_VO_LocationSelector_LocationVO();
		}
		
		
		$this->tableCode = Mage::registry("CurrentTableCode");
		$tableVO = Mage::helper('webportal/Data')->getTableVOByTableCode($this->tableCode);
		$this->type10Code = $tableVO->getValue();
        //$tableVO->setValue("apctweb".$tableVO->getValue()); 
        $tableVO->setValue(str_replace("_","",$tableVO->getValue()) ); 
		 
		$typeModel = Mage::helper('webportal/Data')->getType10TypeModel($tableVO->getValue());
		$dataObj = $typeModel->getResource()->getByCode($this->tableCode);
		
		
		$model = Mage::helper('webportal/Data')->getType10Model($tableVO->getValue());
		$collection = $model->getCollection();
		
		
		if($dataObj !== false){
			
			$typeDTO = new Margshri_WebPortal_VO_Master_Center_Content_Type10_TypeVO($tableVO->getValue());
			/* @var $typeVO Margshri_WebPortal_VO_Master_Center_Content_Type10_TypeVO */
			$typeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($typeDTO, $dataObj);
			$this->title = $typeVO->getValue();
			
			$collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "Value"=>"main_table.Value" , "Address"=>"main_table.Address" , "PinCode"=>"main_table.PinCode", "LandLineNumber"=>"main_table.LandLineNumber" , "MobileNumber1"=>"main_table.MobileNumber1" , "MobileNumber2"=>"main_table.MobileNumber2" ,  "DynamicColumn1Value"=>"main_table.Category1Value", "DynamicColumn2Value"=>"main_table.Category2Value", "DynamicColumn3Value"=>"main_table.Category3Value", "WebsiteLink"=>"main_table.WebsiteLink",  "main_table.edit"=> new Zend_Db_Expr("'Edit'") ));
			$collection->getSelect()->joinLeft(array("country"=>$collection->getTable('webportal/apctcountrylist')), 'main_table.CountryID = country.ID', array("CountryName"=>"country.Value"));
			$collection->getSelect()->joinLeft(array("state"=>$collection->getTable('webportal/apctstatelist')), 'main_table.StateID = state.ID', array("StateName"=>"state.Value"));
			$collection->getSelect()->joinLeft(array("district"=>$collection->getTable('webportal/apctdistrictlist')), 'main_table.DistrictID = district.ID', array("DistrictName"=>"district.Value", "DistrictCode"=>"district.Code"));
			$collection->getSelect()->joinLeft(array("city"=>$collection->getTable('webportal/apctcitylist')), 'main_table.CityID = city.ID', array("CityName"=>"city.Value", "CityCode"=>"city.Code"));
			$collection->getSelect()->joinLeft(array("dynamiccolumn1"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category1ID = dynamiccolumn1.ID', array("DynamicColumn1Name"=>"dynamiccolumn1.Value"));
			$collection->getSelect()->joinLeft(array("dynamiccolumn2"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category2ID = dynamiccolumn2.ID', array("DynamicColumn2Name"=>"dynamiccolumn2.Value"));
			$collection->getSelect()->joinLeft(array("dynamiccolumn3"=>$collection->getTable('webportal/apctwebdynamiccolumn')), 'main_table.Category3ID = dynamiccolumn3.ID', array("DynamicColumn3Name"=>"dynamiccolumn3.Value"));
			$collection->getSelect()->where('main_table.StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
			$collection->getSelect()->where('main_table.TypeID =?', $typeVO->getID());
			
			if($locationVO->getCountryID() != null){
				$collection->getSelect()->where('main_table.CountryID =?', $locationVO->getCountryID());
			}
			if($locationVO->getStateID() != null){
				$collection->getSelect()->where('main_table.StateID =?', $locationVO->getStateID());
			}
			
			if($this->type10Code != Margshri_WebPortal_VO_Master_Table_TableTypeVO::$TYPE10_UNIVERSITY){
				
				if($locationVO->getDistrictID() != null){
					$collection->getSelect()->where('main_table.DistrictID =?', $locationVO->getDistrictID());
				}
				if($locationVO->getCityID()){
					$collection->getSelect()->where('main_table.CityID =?', $locationVO->getCityID());
				}
			}	
			
			
			
			$collection->getSelect()->Order('main_table.Value Asc');
			$this->setCollection($collection);
			
		}	
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
	
	public function getPageTitle(){
		return Mage::registry("CurrentPageTitle");
	}
	
	/*
	 * this function is used for check universtiy or newspaper then create link on name
	 * 
	 */
	public function getType10Code(){
		return $this->type10Code;
	}
	

	

	public function getPagerHtml(){
		return $this->getChildHtml('pager');
	}
}
