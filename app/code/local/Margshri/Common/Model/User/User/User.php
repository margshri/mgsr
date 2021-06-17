<?php

class Margshri_Common_Model_User_User_User extends Mage_Core_Model_Abstract  {
	
    /**
     * Initialize resource model
     */
    protected function _construct(){
        parent::_construct();
        $this->_init(Margshri_Common_VO_User_User_UserVO::$modelName);
    }
    
    public function getUserVOByID($userID){
     
        $userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
        $userDataObj = $userModel->getResource()->getByID($userID);
        $userVO = new Margshri_Common_VO_User_User_UserVO();
        if($userDataObj !== false){
            $userDTO = new Margshri_Common_VO_User_User_UserVO();
            /* @var $userVO Margshri_Common_VO_User_User_UserVO */
            $userVO = Margshri_Common_Helper_Utility::callInstanceFunction($userDTO, $userDataObj);
            
            if($userVO->getNamePrefixID() != null){
                $namePrefixModel = Mage::getModel(Margshri_Common_VO_Master_NamePrefix_NamePrefixVO::$modelName);
                $namePrefixDataObj = $namePrefixModel->getResource()->getByID($userVO->getNamePrefixID());
                if($namePrefixDataObj !== false){
                    $namePrefixDTO = new Margshri_Common_VO_Master_NamePrefix_NamePrefixVO();
                    /* @var $namePrefixVO Margshri_Common_VO_Master_NamePrefix_NamePrefixVO */
                    $namePrefixVO = Margshri_Common_Helper_Utility::callInstanceFunction($namePrefixDTO, $namePrefixDataObj);
                    $userVO->setNamePrefix($namePrefixVO->getValue());
                }
            }
            
            if($userVO->getAreaID() != null){
                $areaListModel = Mage::getModel(Margshri_Common_VO_Directory_AreaList_AreaListVO::$modelName);
                $areaListDataObj = $areaListModel->getResource()->getByID($userVO->getAreaID());
                if($areaListDataObj !== false){
                    $areaListDTO = new Margshri_Common_VO_Directory_AreaList_AreaListVO();
                    /* @var $areaListVO Margshri_Common_VO_Directory_AreaList_AreaListVO */
                    $areaListVO = Margshri_Common_Helper_Utility::callInstanceFunction($areaListDTO, $areaListDataObj);
                    $userVO->setArea($areaListVO->getValue());
                    
                    if($areaListVO->getCityID() != null){
                        $cityListModel = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
                        $cityListDataObj = $cityListModel->getResource()->getByID($areaListVO->getCityID());
                        
                        if($cityListDataObj !== false){
                            $cityListDTO = new Margshri_Common_VO_Directory_CityList_CityListVO();
                            /* @var $cityListVO Margshri_Common_VO_Directory_CityList_CityListVO */
                            $cityListVO = Margshri_Common_Helper_Utility::callInstanceFunction($cityListDTO, $cityListDataObj);
                            $userVO->setCityName($cityListVO->getValue());
                        }
                    }
                    
                }
                
            }
        }
        return $userVO;
        
    }
    
    
}


