<?php
class Margshri_WebPortal_Block_Backend_Master_Table_Table_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Table Info');
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
        $this->setTemplate('webportal/master/table/table/entropy.phtml');
    }

    public function getTableVO(){
        return Mage::registry('CurrentTableVO');
    }

    public function getTableTypeOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Table_TableType');
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
    	return 'Table';
    }
    
    public function getYesNoOptions(){
    	return array("0"=>"No", "1"=>"Yes");
    }
    
    
    
    public function getTableOptions1(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Table_Table');
    	$options = $model->getResource()->getOptions1();
    	return $options;
    }
    
    
    
}