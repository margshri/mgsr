<?php
class Margshri_MedicalCamp_Block_Registration_AdmitCardFilter extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('margshri/medicalcamp/registration/admitcardfilter.phtml');
    }

    public function getCurrentAdmitCardFilter(){
    	$currentAdmitCardFilter = $_SESSION['CurrentAdmitCardFilter'];
    	if(isset($_SESSION['CurrentAdmitCardFilter'])){
    		unset($_SESSION['CurrentAdmitCardFilter']);
    	}
    	return $currentAdmitCardFilter;
    }
    
    public function getHTMLFormID(){
    	return 'AdmitCardFilter';
    }
}