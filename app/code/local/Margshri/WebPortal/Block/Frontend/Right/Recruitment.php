<?php
class Margshri_WebPortal_Block_Frontend_Right_Recruitment extends Mage_Core_Block_Template{
	
    public function __construct(){
    	parent::__construct();
    }

    public function getRecruitmentVOs(){
    	$model    = Mage::getModel("webportal/Center_Content_Type10_Recruitment_Recruitment");
    	$dataObjs = $model->getResource()->getAllActiveRecord();
    	$VOs = array();
    	foreach ($dataObjs as $dataObj){
    		$recruitmentDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO();
    		/* @var $recruitmentVO Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO */
    		$recruitmentVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($recruitmentDTO, $dataObj);
    		$VOs[] = $recruitmentVO;  
    	}
    	return $VOs; 
    }
    
}
