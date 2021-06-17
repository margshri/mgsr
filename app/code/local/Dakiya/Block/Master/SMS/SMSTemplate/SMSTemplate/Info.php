<?php
class Dakiya_Block_Master_SMS_SMSTemplate_SMSTemplate_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct(){
        parent::__construct();
        $this->setTemplate('master/sms/smstemplate/smstemplate/entropy.phtml');
    }
    
    public function getSMSTemplateVO(){
	    return Mage::registry('CurrentSMSTemplateVO');
    }
    
    public function getStatusOptions(){
    	$model = Mage::getModel('dakiya/Master_Status_Status');
    	return  $model->getResource()->getOptions();
    }
    
}