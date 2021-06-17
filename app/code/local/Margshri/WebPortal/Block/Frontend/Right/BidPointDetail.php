<?php
class Margshri_WebPortal_Block_Frontend_Right_BidPointDetail extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    }

    public function getCLPPointsVO(){
    	$customerDataObj  = Mage::getSingleton('customer/session')->getCustomer();
    	$model = Mage::getModel("webportal/Right_CLPPoints");
    	$dataObj = $model->getResource()->getByCustomerID($customerDataObj->getId());
    	$clpPointsVO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
    	if($dataObj !== false){
	    	$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
	    	$clpPointsVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($clpPointsDTO, $dataObj);
    	}	
    	return $clpPointsVO; 
    }
    
}
