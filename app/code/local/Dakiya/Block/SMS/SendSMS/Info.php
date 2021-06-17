<?php
class Dakiya_Block_SMS_SendSMS_Info extends Mage_Adminhtml_Block_Template{
    
    public function __construct(){
        parent::__construct();
        $this->setTemplate('sms/sendsms/entropy.phtml');
    }

    public function getSMSSenderOptions(){
    	$smsSenderOptions = array();
    	$smsSenderModel = Mage::getModel('dakiya/Master_SMS_SMSConfig');
    	$smsSenderOptions = $smsSenderModel->getResource()->getOptions();
    	return $smsSenderOptions;
    }
    
    public function getSMSTemplateOptions(){
    	$smsTemplateOptions = array();
    	$smsTemplateModel = Mage::getModel('dakiya/Master_SMS_SMSTemplate');
    	$smsTemplateOptions = $smsTemplateModel->getResource()->getOptions();
    	return $smsTemplateOptions;
    }
    
    public function getUserMobileNOs(){
    	return;
    	$userRequestIDs = Mage::registry('CurrentUserRequestIDs');
    	Mage::unregister('CurrentUserRequestIDs');
    	
    	$userBookingRequestModel    = Mage::getModel('dakiya/IRCTC_Booking_UserBookingRequest');
    	$userBookingRequestDataObjs = $userBookingRequestModel->getResource()->getUserSMSByRequestID($userRequestIDs);
    	
    	$userEmails = array();
    	foreach ($userBookingRequestDataObjs as $userBookingRequestDataObj){
    		$userEmails[] = $userBookingRequestDataObj['EmailID'];
    	}
    	return implode(',', $userEmails);
    }
    
}