<?php
class Margshri_WebPortal_Block_Backend_Master_Bidding_ProductMapping_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Product Mapping Info');
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
        $this->setTemplate('webportal/master/bidding/productmapping/entropy.phtml');
    }

    public function getBidProductsVO(){
        return Mage::registry('CurrentBidProductsVO');
    }
     
    public function getBidOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Right_Bid');
    	$options = $model->getResource()->getActiveOptions();
    	return $options;
    }
    
    public function getProductOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Right_BidProducts');
    	$options = $model->getResource()->getProductOptions();
    	return $options;
    }
    
    
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Status_Status');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    public function getHTMLFormID(){
    	return 'ProductMapping';
    }
    
        
    
    
    
    
}