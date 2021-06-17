<?php
class Margshri_WebPortal_Block_Backend_Master_Table_TableType_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Table Type Info');
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
        $this->setTemplate('webportal/master/table/tabletype/entropy.phtml');
    }

    public function getTableTypeVO(){
        return Mage::registry('CurrentTableTypeVO');
    }

    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'TableType';
    }
    
}