<?php
class Margshri_WebPortal_Block_Frontend_Center_Content_Type2_BloodDonor_BloodDonor_CustomerForm extends Mage_Core_Block_Template{
	
	public function __construct(){
		parent::__construct();
		$this->setTemplate('webportal/center/content/type2/blooddonor/blooddonor/customerform.phtml');
	}
	
	public function getPageTitle(){
		return "Blood Donor";
	}
	
	public function getBloodGroupOptions(){
		$model = Mage::getModel('webportal/Master_Center_Content_Type2_BloodDonor_BloodGroup');
		$options = $model->getResource()->getActiveOptions();
		return $options;
	}

	public function getIsDonatedOptions(){
		$options = array();
		$options[0] = "No";
		$options[1] = "Yes";
		return $options;
	}
	
	public function getWantToDonateOptions(){
		$options = array();
		$options[0] = "No";
		$options[1] = "Yes";
		return $options;
	}
	
	public function getHTMLFormID(){
    	return 'BloodDonor';
    }
    
    public function getBloodDonorVO(){
    	return Mage::registry('CurrentBloodDonorVO');
    }
	
}
