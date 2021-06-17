<?php 
class Margshri_Common_Frontend_Donor_DonorController extends Mage_Core_Controller_Front_Action {
	
	public function showPratibhaSammanDonorListAction(){
	    $this->loadLayout();
	    /*
	    $this->getLayout()->getBlock('root')->setTemplate('page/empty.phtml');
	    $block = $this->getLayout()->createBlock('common/Frontend_Donor_Donor_PratibhaSammanDonorList');
	    $block->setTemplate('common/responsive/donor/donor/pratibhasammandonorlist.phtml');
	    $this->getLayout()->getBlock('content')->append($block);
	    */
	    $this->renderLayout();
	}
	
	
	public function showDevrajHealthDonorListAction(){
	    $this->loadLayout();
	    $this->renderLayout();
	}
	
	
	public function showBuddhPurnimaDonorListAction(){
	    $this->loadLayout();
	    $this->renderLayout();
	}
	 
	/*
	public function showGoCoronaDonorListAction(){
	    $this->getRequest()->setParam('ProgrammeID', 4);
	    $this->showDonorListAction();
	    $this->loadLayout();
	    $this->renderLayout();
	}
	*/
	
	// public function showDonorListAction(){
	public function showGoCoronaDonorListAction(){
	    $programmeID = $this->getRequest()->getParam('ProgrammeID');
	    if($programmeID == null){
	        $programmeID = 4;
	    }
	    if($programmeID != null){
	        
    	    $donationModel = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
	        $donationDataObjs = $donationModel->getResource()->getByProgrammeID($programmeID);
	        
	        $newDonationVOs = array();
	        foreach($donationDataObjs as $donationDataObj){
	            $donationVOs = array();
	            $donationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
	            /* @var $donationVO Margshri_Common_VO_Donation_Donation_DonationVO */
	            $donationVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationDTO, $donationDataObj);
	            
	            $donationTypeModel = Mage::getModel(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$modelName);
	            $donationTypeDataObj = $donationTypeModel->getResource()->getByID($donationVO->getDonationTypeID());
	            $donationTypeVO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
	            if($donationTypeDataObj !== false){
	                $donationTypeDTO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
	                /* @var $donationTypeVO Margshri_Common_VO_Donation_DonationType_DonationTypeVO */
	                $donationTypeVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationTypeDTO, $donationTypeDataObj);
	            }
	            $donationVO->setDonationTypeVO($donationTypeVO);
	            
	            if(array_key_exists($donationVO->getUserID(), $newDonationVOs)){
	                $userVO = $newDonationVOs[$donationVO->getUserID()]["UserVO"];
	                $arr1 = $newDonationVOs[$donationVO->getUserID()]["DonationVOs"];
	                $arr2 = array($donationVO);
	                $donationVOs = array_merge($arr1, $arr2);
	            }else{
	                $userVO = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName)->getUserVOByID($donationVO->getUserID());
	                $donationVOs = array($donationVO);
	            }
	            $newDonationVOs[$donationVO->getUserID()] = array("UserVO"=>$userVO, "DonationVOs"=>$donationVOs);
	        }
	        
    	    Mage::register("CurrentDonationVOs", $newDonationVOs);
    	}
    	
    	$this->loadLayout();
    	$this->renderLayout();
	}
	
	
	public function showDonorListAction(){
	
	    $programmeID = $this->getRequest()->getParam('ProgrammeID');
	    if($programmeID != null){
	        
	        $donationModel = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
	        $donationDataObjs = $donationModel->getResource()->getByProgrammeID($programmeID);
	        
	        $newDonationVOs = array();
	        foreach($donationDataObjs as $donationDataObj){
	            $donationVOs = array();
	            $donationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
	            /* @var $donationVO Margshri_Common_VO_Donation_Donation_DonationVO */
	            $donationVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationDTO, $donationDataObj);
	            
	            $donationTypeModel = Mage::getModel(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$modelName);
	            $donationTypeDataObj = $donationTypeModel->getResource()->getByID($donationVO->getDonationTypeID());
	            $donationTypeVO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
	            if($donationTypeDataObj !== false){
	                $donationTypeDTO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
	                /* @var $donationTypeVO Margshri_Common_VO_Donation_DonationType_DonationTypeVO */
	                $donationTypeVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationTypeDTO, $donationTypeDataObj);
	            }
	            $donationVO->setDonationTypeVO($donationTypeVO);
	            
	            if(array_key_exists($donationVO->getUserID(), $newDonationVOs)){
	                $userVO = $newDonationVOs[$donationVO->getUserID()]["UserVO"];
	                $arr1 = $newDonationVOs[$donationVO->getUserID()]["DonationVOs"];
	                $arr2 = array($donationVO);
	                $donationVOs = array_merge($arr1, $arr2);
	            }else{
	                $userVO = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName)->getUserVOByID($donationVO->getUserID());
	                $donationVOs = array($donationVO);
	            }
	            $newDonationVOs[$donationVO->getUserID()] = array("UserVO"=>$userVO, "DonationVOs"=>$donationVOs);
	        }
	        
	        Mage::register("CurrentDonationVOs", $newDonationVOs);
	    }
	    
	    $this->loadLayout();
	    $this->renderLayout();
	}
	
	
	public function showBloodDonorFilterFormAction(){
	    $this->loadLayout();
	    $this->renderLayout();
	}
	
	
	public function showBloodDonorListAction(){
	    
	    
	    $bloodGroupID = $this->getRequest()->getParam('BloodGroupID');
	    $cityID = $this->getRequest()->getParam('CityID');
	    $isStpEligible = $this->getRequest()->getParam('IsStpEligible');
	    
	    $userVO = new Margshri_Common_VO_User_User_UserVO();
	    if($bloodGroupID != null && $bloodGroupID != 0 && $bloodGroupID != ""){
	        $userVO->setBloodGroupID($bloodGroupID);
	    }
	    
	    if($cityID != null && $cityID != 0 && $cityID != ""){
	        $userVO->setCityID($cityID);
	    }
	    
	    if($isStpEligible != null && $isStpEligible != 0 && $isStpEligible != ""){
	        $userVO->setIsStpEligible($isStpEligible);
	    }
	    
	    $userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
	    $userDataObjs = $userModel->getResource()->getBloodDonorList($userVO);
	        
	    $bloodGroupModel = Mage::getModel(Margshri_Common_VO_Master_BloodDonation_BloodGroupVO::$modelName);
	    $namePrefixModel = Mage::getModel(Margshri_Common_VO_Master_NamePrefix_NamePrefixVO::$modelName);
	    $areaModel = Mage::getModel(Margshri_Common_VO_Directory_AreaList_AreaListVO::$modelName);
	    $cityModel = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
	    $donationModel = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
	    $todayDateTimeStamp = Mage::getModel('core/date')->timestamp(time());
	    
	    $bloodDonorVOs = array();
        foreach($userDataObjs as $userDataObj){
            $bloodDonorVO = array();
            $userDTO = new Margshri_Common_VO_User_User_UserVO();
            /* @var $userVO Margshri_Common_VO_User_User_UserVO */
            $userVO = Margshri_Common_Helper_Utility::callInstanceFunction($userDTO, $userDataObj);
            
            $donationDataObj = $donationModel->getResource()->getLastByBloodDonorID($userVO->getID());
            
            if($donationDataObj !== false){
                
                $donationDateTimeStamp = $todayDateTimeStamp;
                if($donationDataObj['DonationDate'] != null){
                    $donationDateTimeStamp = strtotime($donationDataObj['DonationDate']);
                }
                
                $datediff = $todayDateTimeStamp - $donationDateTimeStamp;
                $diffDays = round($datediff / (60 * 60 * 24));
               
                if($donationDataObj["DonationTypeID"] == Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$BLOOD){
                    if($diffDays < 90){
                        continue;
                    }
                }else if($donationDataObj["DonationTypeID"] == Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$BLOOD_SDP){
                    if($diffDays < 90){
                        continue;
                    }
                }
                
            }
            
            if($userVO->getNamePrefixID() != null){
                $namePrefixDataObj = $namePrefixModel->getResource()->getByID($userVO->getNamePrefixID());
                $bloodDonorVO['NamePrefix'] = $namePrefixDataObj['Value'];
            }
            
            
            $bloodDonorVO['Name'] = $userVO->getName();
            $bloodDonorVO['FatherName'] = $userVO->getFatherName();
            $bloodDonorVO['MobileNumber1'] = $userVO->getMobileNumber1();
            $bloodDonorVO['Address'] = $userVO->getAddress();
            
            $bloodGroupDataObj = $bloodGroupModel->getResource()->getByID($userVO->getBloodGroupID());
            $bloodDonorVO['BloodGroup'] = $bloodGroupDataObj["Value"];
            
            if($userVO->getIsStpEligible()){
                $bloodDonorVO['IsStpEligible'] = $userVO->getIsStpEligible();
            }
            
            if($userVO->getAreaID() != null){
                $areaDataObj = $areaModel->getResource()->getByID($userVO->getAreaID());
                if($areaDataObj !== false){
                    $bloodDonorVO['Area'] = $areaDataObj['Value'];     
                    
                    $cityDataObj = $cityModel->getResource()->getByID($areaDataObj['CityID']);
                    if($cityDataObj !== false){
                        $bloodDonorVO['CityName'] = $cityDataObj['Value'];
                    }
                }
            }
            
            
//             $donationTypeModel = Mage::getModel(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$modelName);
//             $donationTypeDataObj = $donationTypeModel->getResource()->getByID($donationVO->getDonationTypeID());
//             $donationTypeVO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
//             if($donationTypeDataObj !== false){
//                 $donationTypeDTO = new Margshri_Common_VO_Donation_DonationType_DonationTypeVO();
//                 /* @var $donationTypeVO Margshri_Common_VO_Donation_DonationType_DonationTypeVO */
//                 $donationTypeVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationTypeDTO, $donationTypeDataObj);
//             }
//             $donationVO->setDonationTypeVO($donationTypeVO);
            
            $bloodDonorVOs[] = $bloodDonorVO;
        }
	        
        Mage::register("CurrentBloodDonorVOs", $bloodDonorVOs);
	     
	    
	    $this->loadLayout();
	    $this->renderLayout();
	}
	
}