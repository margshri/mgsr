<?php
class Dakiya_Block_Master_Email_EmailTemplate_EmailTemplate_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct(){
        parent::__construct();
        $this->setTemplate('master/email/emailtemplate/emailtemplate/entropy.phtml');
    }
    
    public function getEmailTemplateVO(){
	    return Mage::registry('CurrentEmailTemplateVO');
    }
    
    public function getStatusOptions(){
    	$model = Mage::getModel('dakiya/Master_Status_Status');
    	return  $model->getResource()->getOptions();
    }
    
}