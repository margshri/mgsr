<?php
class Margshri_MedicalCamp_Block_Registration_Info extends Mage_Adminhtml_Block_Template{ 
    
    public function __construct()
    {
    	parent::__construct();
        $this->setTemplate('margshri/medicalcamp/registration/entropy.phtml');
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
    
    public function getGenderListOptions(){
    	$options = array(1=>'Male', 2=>'Female');
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'StudentRegistraion';
    }
    
    public function getSchoolOptions(){
    	$schoolOption = array();
    	
    	$schoolOption['School 1'] = 'School 1';
    	$schoolOption['School 2'] = 'School 2';
    	
    	return $schoolOption;
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


	public function getSubjectOptions(){
    	$option = array();
    	
    	$option[1] = 'General';
    	$option[2] = 'Commerce';
        $option[3] = 'Science';
        $option[4] = 'CA-CPT-PCC';
    	
    	return $option;
    }

    
	public function getBoardOptions(){
    	$option = array();
    	
    	$option[1] = 'CBSE';
    	$option[2] = 'ICSE';
        $option[3] = 'Other';
    	
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
    
}
