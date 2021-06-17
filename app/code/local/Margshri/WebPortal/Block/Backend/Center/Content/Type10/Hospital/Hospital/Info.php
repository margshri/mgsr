<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type10_Hospital_Hospital_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Hospital Info');
    }

    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
    
    
    public function __construct()
    {
    	parent::__construct();
        $this->setTemplate('webportal/center/content/type10/hospital/hospital/entropy.phtml');
    }

    public function getHospitalVO(){
        return Mage::registry('CurrentHospitalVO');
    }
    
    
    public function getCountryOptions(){
    	return Mage::helper('webportal/Data')->getCountryOptions();
    }
    
    public function getStateOptions(){
    	return Mage::helper('webportal/Data')->getStateOptions();
    }
    
    public function getDistrictOptions(){
    	return Mage::helper('webportal/Data')->getDistrictOptions();
    }
    
    public function getCityOptions(){
    	return Mage::helper('webportal/Data')->getCityOptions();
    }

    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    
    public function getDynamicColumnOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Table_DynamicColumn');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHospitalTypeOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Center_Content_Type10_Hospital_HospitalType');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'Hospital';
    }
    
}