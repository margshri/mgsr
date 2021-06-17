<?php
class Margshri_WebPortal_Block_Frontend_Right_CityUpdate extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    }

    public function getNewsVOs(){
    	$model = Mage::getModel("webportal/Center_Content_Type7_News_News");
    	$dataObjs = $model->getResource()->getAllActiveRecord();
    	$VOs = array();
    	foreach ($dataObjs as $dataObj){
    		$newsDTO = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();
    		/* @var $newsVO Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO */
    		$newsVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newsDTO, $dataObj);
    		$VOs[] = $newsVO;  
    	}
    	return $VOs; 
    }
    
}
