<?php
class Margshri_WebPortal_Block_Frontend_LocationSelector_LocationSelector extends Mage_Core_Block_Template{

    public function __construct(){
        parent::__construct();
        $todayDate  = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
        $currentTime = date("H:i:s", Mage::getModel('core/date')->timestamp(time()));
        
        $collection = Mage::getModel("webportal/Master_Right_Bid")->getCollection();
        $collection->getSelect()->reset()->from(array("main_table"=>$collection->getMainTable()), array("ID"=>"main_table.ID", "StatusID"=>"main_table.StatusID", "BidName"=>"main_table.BidName", "BiddingDate"=>"main_table.BiddingDate", "BiddingTime"=>new Zend_Db_Expr(" CASE WHEN  main_table.BiddingTime <=  '" . $currentTime . "' AND main_table.BiddingDate = '" . $todayDate . "'  THEN  'Running' ELSE main_table.BiddingTime END ") ));
        $collection->getSelect()->joinLeft(array("type"=>$collection->getTable('webportal/apctwebbidtype') ), 'main_table.TypeID = type.ID', array("TypeName"=>"type.Value"));
        $collection->getSelect()->joinInner(array("product"=>$collection->getTable('webportal/apctwebbidproducts') ), 'main_table.ID = product.BidID', array("ProductID"=>"product.ProductID"));
        $collection->getSelect()->where('main_table.StatusID = ' . Margshri_WebPortal_VO_Master_Right_BidStatusVO::$TO_BE_OPEN . " OR main_table.StatusID = " .  Margshri_WebPortal_VO_Master_Right_BidStatusVO::$RUNNING);
        $collection->getSelect()->where('main_table.BiddingDate >=?', $todayDate);
        $collection->getSelect()->Order('main_table.BiddingDate ASC');
        $collection->getSelect()->limit(1);
        $this->setCollection($collection);
    }

    public function getCountryOptions(){
    	/*
    	$countryDataObjs = Mage::getModel('directory/country')->getResourceCollection()->loadByStore()->toOptionArray(true);
    	foreach ($countryDataObjs as $countryDataObj){
   			if($countryDataObj['value'] == 'IN'){
   				$countryList[$countryDataObj['value']] = $countryDataObj['label'];
   			}
    	}
    	return $countryList;
    	*/
    	$model   = Mage::getModel('webportal/Directory_CountryList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }

    public function getStateOptions(){
    	$model   = Mage::getModel('webportal/Directory_StateList');
    	$options = $model->getResource()->getActiveOptions();
    	return $options;
    }
    
    public function getDistrictOptions(){
    	$model   = Mage::getModel('webportal/Directory_DistrictList');
    	$options = $model->getResource()->getActiveOptions();
    	return $options;
    }
    
    public function getCityOptions(){
    	$model   = Mage::getModel('webportal/Directory_CityList');
    	$options = $model->getResource()->getActiveOptions();
    	return $options;
    }
    
    
}
