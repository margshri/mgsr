<?php
class Margshri_MedicalCamp_Block_Registration_Genius extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('medicalcamp/registration/genius.phtml');
    }
    
    public function getHeaderHtml(){
        return $this->getChild('Registration_Header')->toHtml();
    }
    
    public function getFooterHtml(){
        return $this->getChild('Registration_Footer')->toHtml();
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
    
    
    public function getRegistrationVOs(){
        $registrationVOs = array();
        $registrationModel = Mage::getModel('medicalcamp/Registration_Registration');
        $registrationDataObjs = $registrationModel->getResource()->getAll();
        foreach ($registrationDataObjs as $registrationDataObj){
            $registrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
            $registrationVO = Margshri_MedicalCamp_Model_DataAccess::callInstanceFunction($registrationDTO, $registrationDataObj);
            
            // added by vipin date 04-12-2019
            if($registrationVO->getCreatedAt() != null){
                $createdDate = date("Y-m-d", strtotime($registrationVO->getCreatedAt()));
                if($createdDate < "2020-12-22"){
                    continue;
                }
            }
            
            if($registrationVO->getIsPaid() != 2){ // is rejected if yes = 2 or no = 1  
                $registrationVOs[] = $registrationVO;
            }
    	}	
    	return $registrationVOs;
    }
    
}
