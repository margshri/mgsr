<?php
class Margshri_WebPortal_Block_Backend_Master_Office_Office_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Office Info');
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
        $this->setTemplate('webportal/master/office/office/entropy.phtml');
    }

    public function getOfficeVO(){
        return Mage::registry('CurrentOfficeVO');
    }

    public function getOfficeTypeOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Office_OfficeType_OfficeType');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }

    public function getStoreOptions(){
    	return array("1"=>"Web Portal", "2"=>"Shopping Website");;
    }
    
    public function getCountryOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_CountryList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getStateOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_StateList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getDistrictOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_DistrictList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getCityOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Directory_CityList');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'Office';
    }
    
}