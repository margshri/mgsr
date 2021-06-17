<?php
class Dakiya_Block_Email_SendLegalEmail_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct(){
        parent::__construct();
        $this->setTemplate('email/sendlegalemail/entropy.phtml');
    }

    public function getEmailSenderOptions(){
    	$emailSenderOptions = array();
    	$emailSenderModel = Mage::getModel('dakiya/Master_Email_EmailConfig');
    	$emailSenderOptions = $emailSenderModel->getResource()->getEmailSenderOptions();
    	return $emailSenderOptions;
    }
    
    public function getEmailTemplateOptions(){
    	$emailTemplateOptions = array();
    	$emailTemplateModel = Mage::getModel('dakiya/Master_Email_EmailTemplate');
    	$emailTemplateOptions = $emailTemplateModel->getResource()->getOptions();
    	
    	$newEmailTemplateOptions = array();
    	$legalTemplateIDs = array(2);
    	foreach ($emailTemplateOptions as $key=>$value){
    		if(in_array($key, $legalTemplateIDs)){
    			$newEmailTemplateOptions[$key] = $value;
    		} 
    	}
    	return $newEmailTemplateOptions;
    }

    public function getHTMLFormID(){
    	return 'SendLegalEmail';
    }
}