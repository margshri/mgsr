<?php
class Margshri_MedicalCamp_Block_Registration_Terms extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('medicalcamp/registration/terms.phtml');
    }

}
