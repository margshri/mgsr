<?php
class Margshri_MedicalCamp_Block_Registration_Response extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate('medicalcamp/registration/response.phtml');
    }
    
    public function getHeaderHtml(){
        return $this->getChild('Registration_Header')->toHtml();
    }
    
    public function getFooterHtml(){
        return $this->getChild('Registration_Footer')->toHtml();
    }
    
    public function getRegistrationVO(){
        $registrationData = Mage::getSingleton('core/session')->getData("CurrentRegistrationData");
        if($registrationData != null){
            Mage::getSingleton('core/session')->unsetData("CurrentRegistrationData");
            $registrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
            $registrationVO = Margshri_MedicalCamp_Model_DataAccess::callInstanceFunction($registrationDTO, $registrationData);
        }
        return $registrationVO;
    }
    
}
