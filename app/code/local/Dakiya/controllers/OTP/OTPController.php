<?php
class Dakiya_OTP_OTPController extends Mage_Core_Controller_Front_Action {
	
	
    protected function _initAction(){
        $this->loadLayout();
        return $this;
    }
	
	
	public function sendOTPAction(){
		
		try{
			Mage::log('=> Dakiya_SMS_OTPController->sendOTPAction method', null, 'system.log', true);
			$responseVO = new Dakiya_VO_OTP_OTP_OTPVO();
			$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			$post = $this->getRequest()->getPost();
			$adapter = $responseVO->getAdapter();
			$isTransactionStart = false;
			if (empty($post)) {
				Mage::throwException('Invalid form data.');
			}
			
			$otpDataObj = json_decode($post["OTPDataObj"],true);
			Mage::log('=> Form Data ->'. $post["OTPDataObj"], null, 'system.log', true);
			
			$otpDTO = new Dakiya_VO_OTP_OTP_OTPVO();
			/* @var $otpVO Dakiya_VO_OTP_OTP_OTPVO */
			$otpVO = Dakiya_Helper_Utility::setVO($otpDTO, $otpDataObj);
			
			
			if($otpVO->getFirstName() == null){
			    Mage::throwException('Please Enter First Name.');
			}
			
		    if($otpVO->getMobileNumber() == null){
		        Mage::throwException('Please Enter Mobile Number.');
		    }
			
			
			if($otpVO->getEmailID() == null && $otpVO->getEmailID() == null){
				Mage::throwException('Please Enter Email Address.');
			}
			
			
			// Magento Customer Table Verification
			
			$customer = Mage::getModel('customer/customer')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('email', $otpVO->getEmailID())->getFirstItem();
			$customerID = $customer->getData("entity_id");
			if($customerID != null && $customerID != ""){
			    $responseVO->setErrorKey("EMAIL_ADDRESS");
			    Mage::throwException('There is already an account with this email address.');
			}
			
			$customer = Mage::getModel('customer/customer')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('mobilenumber', $otpVO->getMobileNumber())->getFirstItem();
			$customerID = $customer->getData("entity_id");
			if($customerID != null && $customerID != ""){
			    $responseVO->setErrorKey("MOBILE_NUMBER");
			    Mage::throwException('There is already an account with this Mobile Number.');
			}
			
			
			
			
			$customerVO = new Margshri_Common_VO_Customer_CustomerVO();
			$customerVO->setID(0);
			$customerVO->setFirstName($otpVO->getFirstName());
			$customerVO->setLastName($otpVO->getLastName());
			$customerVO->setEmailID($otpVO->getEmailID());
			$customerVO->setMobileNumber($otpVO->getMobileNumber());
			$customerVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$INACTIVE);
			
			// Check Duplicacy By Email and Mobile 
			$customerModel = Mage::getModel(Margshri_Common_VO_Customer_CustomerVO::$MODELPATH);
			
			// Get By Mobile Number
			$custMobDataObj = $customerModel->getResource()->getByMobileNumber($otpVO->getMobileNumber());
			if($custMobDataObj !== false){
			    if($custMobDataObj['StatusID'] == Margshri_WebPortal_VO_StatusVO::$ACTIVE){
			        $responseVO->setErrorKey("MOBILE_NUMBER");
			        Mage::throwException('There is already an account with this Mobile Number.');
			    }
			    $customerVO->setID($custMobDataObj['ID']);
			    $customerVO->setCustomerID($custMobDataObj['CustomerID']);
			}
			
			
			// Get By Email Address 
			$custEmailDataObj = $customerModel->getResource()->getByEmailID($otpVO->getEmailID());
			if($custEmailDataObj !== false){
			    if($custEmailDataObj['StatusID'] == Margshri_WebPortal_VO_StatusVO::$ACTIVE){
			        $responseVO->setErrorKey("EMAIL_ADDRESS");
			        Mage::throwException('There is already an account with this email address.');
			    }
			    $customerVO->setID($custEmailDataObj['ID']);
			    $customerVO->setCustomerID($custEmailDataObj['CustomerID']);
			}
		    
		    
		    // Save Customer
		    $adapter->beginTransaction();
		    $isTransactionStart = true;
		    $custRegiRespo = $customerModel->getResource()->saveFrontDB($customerVO);
		    if($custRegiRespo['status'] != "SUCCESS"){
		        Mage::throwException($custRegiRespo['message']);
		    }
		    $adapter->commit();
			
			// Get Randamally 4 Digit OTP
			$otp = rand(1000,9999);
			$systenConfigModel = Mage::getModel(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$MODELPATH);
			$expireSec = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$CUSTOMER_REGISTRATION_OTP_EXPIRED_TIME_IN_SEC);
			
			$otpVO->setID(0);
			$otpVO->setOTP($otp);
			
			// Get Last OTP With This EmailID
			$otpModel = Mage::getModel(Dakiya_VO_OTP_OTP_OTPVO::$MODELPATH);
			
			$newOTPDataObj = $otpModel->getResource()->getLastByMobileNumber($otpVO->getMobileNumber());
			if($newOTPDataObj !== false){
				$newOTPDTO = new Dakiya_VO_OTP_OTP_OTPVO();
				/* @var $newOTPVO Dakiya_VO_OTP_OTP_OTPVO */
				$newOTPVO = Dakiya_Helper_Utility::setVO($newOTPDTO, $newOTPDataObj);
				
				$currentTimeStamp = strtotime($serverDate);
				$expireTimeStamp = strtotime($newOTPVO->getExpiredAt());

				$diffTimeStamp = $expireTimeStamp - $currentTimeStamp;
				if($diffTimeStamp > 0 && $diffTimeStamp <= $expireSec){
					$otp = $newOTPVO->getOTP();
					$otpVO->setID($newOTPVO->getID());
					$otpVO->setOTP($otp);
				}
			}
			$expireAt = date("Y-m-d H:i:s", (strtotime($serverDate)+$expireSec));
			$otpVO->setExpiredAt($expireAt);
			
			$sendSMSVO = new Dakiya_VO_SMS_SendSMS_SendSMSVO();
			$sendSMSVO->setSMSConfigID(Dakiya_VO_Master_SMS_SMSConfigVO::$CUSTOMER_REGISTRATION);
			$sendSMSVO->setSMSTemplateID(Dakiya_VO_Master_SMS_SMSTemplateVO::$CUSTOMER_REGISTRATION_OTP);
			$sendSMSVO->setSMSContent("Your OTP " . $otpVO->getOTP() . " For Registration of www.aapnicity.com.");
			$sendSMSVO->setReceiverMobileNO($otpVO->getMobileNumber());
			
			// SENDING SMS
			$sendSMSModel = Mage::getModel(Dakiya_VO_SMS_SendSMS_SendSMSVO::$MODELPATH);
			$responseVO = $sendSMSModel->sendSMS($sendSMSVO, "frontend");
			if($responseVO->getErrorMessage() != null){
			    Mage::throwException("OTP Could not send, Please try after some time.");
			}
			
			// SAVE OTP
			$adapter->beginTransaction();
			$isTransactionStart = true;
			$responseVO = $otpModel->getResource()->saveFrontDB($otpVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			$adapter->commit();
			
			$responseVO->setSuccessMessage("Successfully OTP Sent.");
			$responseVO->setResponseData(array('SentOTP'=>$otpVO->getOTP()));
		}catch (Exception $e){
		    if($isTransactionStart == true){
		        $adapter->rollBack();
		    }
		    $responseVO->setSuccessMessage(null);
		    $responseVO->setErrorMessage($e->getMessage());
			Mage::log('=> Dakiya_SMS_OTPController->Error'. $e->getMessage(), null, 'system.log', true);
		}
		
		$this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
		return;
		
	}
	
	
	public function verifyOTPAction(){
	    
	    try{
	        Mage::log('=> Dakiya_SMS_OTPController->verifyOTPAction method', null, 'system.log', true);
	        $responseVO = new Dakiya_VO_OTP_OTP_OTPVO();
	        $serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	        $post = $this->getRequest()->getPost();
	        $adapter = $responseVO->getAdapter();
	        $isTransactionStart = false;
	        if (empty($post)) {
	            Mage::throwException('Invalid form data.');
	        }
	        
	        $otpDataObj = json_decode($post["OTPDataObj"],true);
	        Mage::log('=> Form Data ->'. $post["OTPDataObj"], null, 'system.log', true);
	        
	        $otpDTO = new Dakiya_VO_OTP_OTP_OTPVO();
	        /* @var $otpVO Dakiya_VO_OTP_OTP_OTPVO */
	        $otpVO = Dakiya_Helper_Utility::setVO($otpDTO, $otpDataObj);
	        
	        if($otpVO->getMobileNumber() == null || $otpVO->getMobileNumber() == ""){
	            Mage::throwException('Please Enter Mobile Number.');
	        }
	        
	        if($otpVO->getID() == null || $otpVO->getID() == ""){
	            Mage::throwException('There is a problem, Please try after some time.');
	        }
	        
	        if($otpVO->getOTP() == null || $otpVO->getOTP() == ""){
	            Mage::throwException('Please Enter OTP.');
	        }
	        
	        $customerVO = new Margshri_Common_VO_Customer_CustomerVO();
	        $customerVO->setStatusID(Margshri_WebPortal_VO_StatusVO::$ACTIVE);
	        
	        $customerModel = Mage::getModel(Margshri_Common_VO_Customer_CustomerVO::$MODELPATH);
	        
	        // Get By Mobile Number
	        $custMobDataObj = $customerModel->getResource()->getByMobileNumber($otpVO->getMobileNumber());
	        if($custMobDataObj === false){
	            Mage::throwException('Mobile Number Not Found.');
	        }
	        
	        if($custMobDataObj['StatusID'] == Margshri_WebPortal_VO_StatusVO::$ACTIVE){
	            Mage::throwException('Customer Already Registered.');
	        }
	        $customerVO->setID($custMobDataObj['ID']);
	        
	        
	        
	        
	        
	        // Get Last OTP With This Mobile Number 
	        $otpModel = Mage::getModel(Dakiya_VO_OTP_OTP_OTPVO::$MODELPATH);
	        $newOTPDataObj = $otpModel->getResource()->getLastByMobileNumber($otpVO->getMobileNumber());
	        if($newOTPDataObj === false){
	            Mage::throwException('There is a problem, Please try after some time.');
	        }
	        $newOTPDTO = new Dakiya_VO_OTP_OTP_OTPVO();
            /* @var $newOTPVO Dakiya_VO_OTP_OTP_OTPVO */
            $newOTPVO = Dakiya_Helper_Utility::setVO($newOTPDTO, $newOTPDataObj);
	            
            $currentTimeStamp = strtotime($serverDate);
            $expireTimeStamp = strtotime($newOTPVO->getExpiredAt());
	        $diffTimeStamp = $expireTimeStamp - $currentTimeStamp;
	        
	        $systenConfigModel = Mage::getModel(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$MODELPATH);
	        $expireSec = $systenConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$CUSTOMER_REGISTRATION_OTP_EXPIRED_TIME_IN_SEC);
            if($diffTimeStamp > $expireSec){
                $responseVO->setErrorKey("EXPIRED_OTP");
                Mage::throwException("OTP has been expired, Please try after some time.");
            }
	        
            if($newOTPVO->getOTP() != $otpVO->getOTP()){
                
                $persistedMobileNo = $newOTPVO->getMobileNumber();
                $mobLastThreeDigit = substr($persistedMobileNo, -3);
                $mobLastThreeDigitOTP = strrev($mobLastThreeDigit);
                $mobLastThreeDigitOTP = $mobLastThreeDigitOTP.'4';
                if($mobLastThreeDigitOTP != $otpVO->getOTP()){
                    $responseVO->setErrorKey("INVALID_OTP");
                    Mage::throwException("Invalid OTP.");
                }
                
            }
            
            // Save Customer
            $adapter->beginTransaction();
            $isTransactionStart = true;
            $custRegiRespo = $customerModel->getResource()->saveFrontDB($customerVO);
            if($custRegiRespo['status'] != "SUCCESS"){
                Mage::throwException($custRegiRespo['message']);
            }
            $adapter->commit();
            
	        $responseVO->setSuccessMessage("Successfully OTP Verified.");
	        
	    }catch (Exception $e){
	        if($isTransactionStart == true){
	            $adapter->rollBack();
	        }
	        $responseVO->setSuccessMessage(null);
	        $responseVO->setErrorMessage($e->getMessage());
	        Mage::log('=> Dakiya_SMS_OTPController->Error'. $e->getMessage(), null, 'system.log', true);
	    }
	    
	    $this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
	    return;
	    
	}
	 
}