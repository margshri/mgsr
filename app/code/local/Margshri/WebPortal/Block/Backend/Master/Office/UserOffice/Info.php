<?php
class Margshri_WebPortal_Block_Backend_Master_Office_UserOffice_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('User Office Info');
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
        $this->setTemplate('webportal/master/office/useroffice/entropy.phtml');
    }

    public function getUserOfficeVO(){
        return Mage::registry('CurrentUserOfficeVO');
    }

    public function getAdminUserID(){
    	return Mage::registry('CurrentAdminUserID');
    }
    
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('common/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getOfficeOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Office_Office_Office');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    

    public function getAdminUserOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Office_Office_Office');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    
    
    
    public function getHTMLFormID(){
    	return 'UserOffice';
    }
    
}