<?php
class Margshri_MedicalCamp_Block_Registration_Header extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
    	$this->setTemplate('medicalcamp/registration/header.phtml');
    }
    
}
