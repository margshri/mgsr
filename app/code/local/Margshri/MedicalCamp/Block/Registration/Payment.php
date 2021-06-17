<?php
class Margshri_MedicalCamp_Block_Registration_Payment extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('margshri/medicalcamp/registration/payment.phtml');
    }

    public function getCurrentPaymentPost(){
    	$currentPaymentPost = $_SESSION['CurrentPaymentPost'];
    	if(isset($_SESSION['CurrentPaymentPost'])){
    		unset($_SESSION['CurrentPaymentPost']);
    	}
    	return $currentPaymentPost;
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
    
    public function getHTMLFormID(){
    	return 'RegistraionPayment';
    }
}