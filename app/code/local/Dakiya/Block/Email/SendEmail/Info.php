<?php
class Dakiya_Block_Email_SendEmail_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct(){
        parent::__construct();
        $this->setTemplate('email/sendemail/entropy.phtml');
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
    	return $emailTemplateOptions;
    }
    
    public function getUserEmailIDs(){
    	$userRequestIDs = Mage::registry('CurrentUserRequestIDs');
    	Mage::unregister('CurrentUserRequestIDs');
    	
    	$userBookingRequestModel    = Mage::getModel('dakiya/Booking_Request_UserBookingRequest');
    	$userBookingRequestDataObjs = $userBookingRequestModel->getResource()->getUserEmailByRequestID($userRequestIDs);
    	
    	$userEmails = array();
    	foreach ($userBookingRequestDataObjs as $userBookingRequestDataObj){
    		$userEmails[] = $userBookingRequestDataObj['EmailID'];
    	}
    	return implode(',', $userEmails);
    }
    
}