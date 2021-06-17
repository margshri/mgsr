<?php
class Margshri_WebPortal_Block_Backend_Master_Bidding_CreateBid_Info extends Mage_Adminhtml_Block_Widget_Form implements Mage_Adminhtml_Block_Widget_Tab_Interface{

	public function getTabLabel()
    {
        return Mage::helper('adminhtml')->__('Bid Info');
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
        $this->setTemplate('webportal/master/bidding/createbid/entropy.phtml');
    }

    public function getBidVO(){
        return Mage::registry('CurrentBidVO');
    }

    public function getTableTypeOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Table_TableType');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }    
    
    public function getStatusOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Right_BidStatus');
    	$options = $model->getResource()->getOptions();
    	return $options;
    }
    
    
    public function getBidTypeOptions(){
    	$options = array();
    	$model = Mage::getModel('webportal/Master_Right_BidType');
    	$options = $model->getResource()->getActiveOptions();
    	return $options;
    }
    
    
    public function getHTMLFormID(){
    	return 'CreateBid';
    }
    
        
    
    
    
    
}