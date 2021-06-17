<?php
class Margshri_MedicalCamp_Block_Registration_Response extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
    }
    
    public function getCurrentPayuResponse(){
    	$currentPayuResponse= $_SESSION['CurrentPayuResponse'];
    	if(isset($_SESSION['CurrentPayuResponse'])){
    		unset($_SESSION['CurrentPayuResponse']);
    	}
    	return $currentPayuResponse;
    }
    
}