<?php
class Margshri_WebPortal_Block_Backend_Registration_Registration_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct()
    {
    	parent::__construct();
        $this->setTemplate('webportal/registration/registration/entropy.phtml');
    }

    public function getRegistrationVO(){
        return Mage::registry('CurrentRegistrationVO');
    }
    
    public function getHTMLFormID(){
    	return 'Registration';
    }
    
    
    public function getClassOptions(){
        $option = array();
        $option[1] = '5th';
        $option[2] = '8th';
        $option[3] = '10th';
        $option[4] = '12th';
        $option[5] = 'Graduation';
        $option[6] = 'Post Graduation';
        $option[7] = 'Other';
        
        return $option;
    }
    
     
    public function getCityOptions(){
        $options = array();
        $newOptions = array();
        
        $model = Mage::getModel('webportal/Directory_CityList');
        $options = $model->getResource()->getOptions();
        
        foreach($options as $key=>$row){
            if($row["DistrictID"] == 31){
                $newOptions[$key] = $row["Name"];
            }
        }
        
        return $newOptions;
    }
    
    
    public function getUserOptions(){
        $options = array();
        $userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
        $options = $userModel->getResource()->getActiveOptions();
        return $options;
    }
    
    
    public function getProgrammeOptions(){
        $options = array();
        $donationTypeModel = Mage::getModel(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$modelName);
        $options = $donationTypeModel->getResource()->getOptions();
        return $options;
    }
}