<?php
class Margshri_WebPortal_Block_Backend_Center_Content_Type11_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Info');
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
        $this->setTemplate('webportal/center/content/type11/entropy.phtml');
    }

    public function getType11VO(){
        return Mage::registry('CurrentType11VO');
    }
    
    public function getTableCode(){
    	return Mage::registry("CurrentTableCode");
    }

    
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'Type11';
    }
    
}