<?php
class Margshri_WebPortal_Block_Backend_Master_SubPage_Service_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Sub Page Service Info');
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
        $this->setTemplate('webportal/master/subpage/service/entropy.phtml');
    }

    public function getServiceVO(){
        return Mage::registry('CurrentServiceVO');
    }
     
    public function getEntityOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_SubPage_Entity');
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
    	return 'Service';
    }
    
}