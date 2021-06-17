<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type2_BloodDonor_BloodDonor_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel(){
        return Mage::helper('adminhtml')->__('Blood Donor Info');
    }

    public function getTabTitle(){
        return $this->getTabLabel();
    }

    public function canShowTab(){
        return true;
    }

    public function isHidden(){
        return false;
    }
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('webportal/center/content/type2/blooddonor/blooddonor/entropy.phtml');
    }

    public function getBloodDonorVO(){
        return Mage::registry('CurrentBloodDonorVO');
    }

    public function getIsDonatedOptions(){
    	$options = array();
    	$options[0] = "No";
    	$options[1] = "Yes";
    	return $options;
    }
    
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getBloodGroupOptions(){
    	$model = Mage::getModel('webportal/Master_Center_Content_Type2_BloodDonor_BloodGroup');
    	$options = $model->getResource()->getActiveOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'BloodDonor';
    }
    
}