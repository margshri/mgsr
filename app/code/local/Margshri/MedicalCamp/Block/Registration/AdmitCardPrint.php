<?php
class Margshri_MedicalCamp_Block_Registration_AdmitCardPrint extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('margshri/medicalcamp/registration/admitcardprint.phtml');
    }

    public function getCurrentAdmitCardPrint(){
    	$currentAdmitCardPrint = $_SESSION['CurrentAdmitCardPrint'];
    	if(isset($_SESSION['CurrentAdmitCardPrint'])){
    		unset($_SESSION['CurrentAdmitCardPrint']);
    	}
    	return $currentAdmitCardPrint;
    }
    
    public function getHTMLFormID(){
    	return 'AdmitCardPrint';
    }
}