<?php
class Margshri_Common_Block_Backend_Customer_ManageCustomer_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct(){
    	parent::__construct();
        $this->setTemplate('common/customer/managecustomer/entropy.phtml');
    }

    public function getCustomerVO(){
        return Mage::registry('CurrentCustomerVO');
    }
    
    public function getHTMLFormID(){
    	return 'ManageCustomer';
    }
 
}
