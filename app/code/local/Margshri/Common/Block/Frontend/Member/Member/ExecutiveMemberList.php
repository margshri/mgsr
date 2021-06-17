<?php
class Margshri_Common_Block_Frontend_Member_Member_ExecutiveMemberList extends Mage_Core_Block_Template{
	
    
    public function __construct(){
        parent::__construct();
    }
    
    
    public function getMemberVOs(){
        $memberVOs = array();
        $memberModel = Mage::getModel(Margshri_Common_VO_Member_Member_MemberVO::$modelName);
        $memberDataObjs = $memberModel->getResource()->getExecutiveMemberList();
        $counter = 0;
        
        foreach($memberDataObjs as $memberDataObj){
            $counter++;
            $memberDTO = new Margshri_Common_VO_Member_Member_MemberVO();
            /* @var $memberVO Margshri_Common_VO_Member_Member_MemberVO */
            $memberVO = Margshri_Common_Helper_Utility::callInstanceFunction($memberDTO, $memberDataObj);
            $userVO = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName)->getUserVOByID($memberVO->getUserID());
            $memberVO->setUserVO($userVO);
            
            $designationModel = Mage::getModel( Margshri_Common_VO_Master_Designation_DesignationVO::$modelName ); 
            $designationDataObj = $designationModel->getResource()->getByID($memberVO->getDesignationID());
            if($designationDataObj !== false){
                $designationDTO = new Margshri_Common_VO_Master_Designation_DesignationVO();
                /* @var $designationVO Margshri_Common_VO_Master_Designation_DesignationVO */
                $designationVO = Margshri_Common_Helper_Utility::callInstanceFunction($designationDTO, $designationDataObj);
                $memberVO->setDesignationVO($designationVO);    
            }
            
            
            $memberVOs[$counter.$memberVO->getDesignationID()] = $memberVO;
        }
        return $memberVOs;
    }
    
}
