<?php
class Margshri_Common_Block_Frontend_Donor_Donor_PratibhaSammanDonorList extends Mage_Core_Block_Template{
	
    
    public function __construct(){
        parent::__construct();
    }

    
    public function getHeaderHtml(){
        // return $this->getChild('Registration_Header')->toHtml();
    }
    
    
    public function getFooterHtml(){
        // return $this->getChild('Registration_Footer')->toHtml();
    }
    
    
    public function getDonationVOs(){
        $donationVOs = array();
        $donationModel = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
        // $donationDataObjs = $donationModel->getResource()->getDonorList();
        $programmeID = 1; // pratibha samman samaroh 2018 
        $donationDataObjs = $donationModel->getResource()->getByProgrammeID($programmeID);
        foreach($donationDataObjs as $donationDataObj){
            $donationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
            /* @var $donationVO Margshri_Common_VO_Donation_Donation_DonationVO */
            $donationVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationDTO, $donationDataObj);
            
            $userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
            $userDataObj = $userModel->getResource()->getByID($donationVO->getUserID());
            $userVO = new Margshri_Common_VO_User_User_UserVO();
            if($userDataObj !== false){
                $userDTO = new Margshri_Common_VO_User_User_UserVO();
                /* @var $userVO Margshri_Common_VO_User_User_UserVO */
                $userVO = Margshri_Common_Helper_Utility::callInstanceFunction($userDTO, $userDataObj);
            }
            
            
            $donationTypeModel = Mage::getModel(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$modelName);
            $donationTypeDataObj = $donationTypeModel->getResource()->getByID($donationVO->getDonationTypeID());
            $donationTypeVO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
            if($donationTypeDataObj !== false){
                $donationTypeDTO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
                /* @var $donationTypeVO Margshri_Common_VO_Donation_DonationType_DonationTypeVO */
                $donationTypeVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationTypeDTO, $donationTypeDataObj);
            }
            
            $donationVO->setUserVO($userVO);
            $donationVO->setDonationTypeVO($donationTypeVO);
            $donationVOs[] = $donationVO;
        }
        return $donationVOs;
    }
    
}
