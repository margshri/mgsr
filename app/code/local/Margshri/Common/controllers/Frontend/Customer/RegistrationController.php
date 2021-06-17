<?php 
class Margshri_Common_Frontend_Customer_RegistrationController extends Mage_Core_Controller_Front_Action {
	
	protected $entityID;
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	protected function _init(){
		 
		if($this->entityID !=null){
			$model   = Mage::getModel("webportal/Center_Content_Type7_Event_Event");
			$dataObj = $model->getResource()->getByID($this->entityID);
	
			if($dataObj !== false){
				$eventDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
				$eventVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($eventDTO, $dataObj);
			}
		}
	
		Mage::register('CurrentEventVO', $eventVO);
		return Mage::registry('CurrentEventVO');
	}
	
	
	public function step1Action(){
	    
// 	    if ($this->_getSession()->isLoggedIn()) {
// 	        $this->_redirect('*/*');
// 	        return;
// 	    }
	    
	    $this->_initAction();
	    $isMobile = Zend_Http_UserAgent_Mobile::match(Mage::helper('core/http')->getHttpUserAgent(),$_SERVER);
	    if($isMobile){
	        $this->getLayout()->getBlock('root')->setTemplate('page/empty.phtml');
	        $block = $this->getLayout()->createBlock('common/Frontend_Customer_Registration_Step1');
	        $block->setTemplate('customer/mobile/form/registration/step1.phtml');
	    }else{
	        $block = $this->getLayout()->createBlock('common/Frontend_Customer_Registration_Step1');
	        $block->setTemplate('customer/desktop/form/registration/step1.phtml');
	    }
	    $this->getLayout()->getBlock('content')->append($block);
	    $this->renderLayout();
	    
	}
	
	
	public function step2Action(){
	    
	    $this->_initAction();
	    $currentRegisterMobileNumber = Mage::getSingleton('core/session')->getCurrentRegisterMobileNumber();
	    // Mage::getSingleton('core/session')->unsetCurrentRegisterMobileNumber();
	    $isMobile = Zend_Http_UserAgent_Mobile::match(Mage::helper('core/http')->getHttpUserAgent(),$_SERVER);
	    if($isMobile){
	        $this->getLayout()->getBlock('root')->setTemplate('page/empty.phtml');
            $block = $this->getLayout()->createBlock('common/Frontend_Customer_Registration_Step2');
	        $block->setTemplate('customer/mobile/form/registration/step2.phtml');
	   
	    }else{
	        $block = $this->getLayout()->createBlock('common/Frontend_Customer_Registration_Step2');
	        $block->setTemplate('customer/desktop/form/registration/step1.phtml');
	    }
	    
	    if($currentRegisterMobileNumber == null){
	       $this->_redirect("*/*/step1");
	    }
	    $this->_initLayoutMessages('customer/session');
	    $this->getLayout()->getBlock('content')->append($block);
	    $this->renderLayout();
	    
	}
	
	
	/*
	public function indexAction(){
		$this->_initAction();
		$block = $this->getLayout()->createBlock('webportal/Frontend_Center_Content_Type7_Event_Event_Info');
		$block->setTemplate('webportal/center/content/type7/event/event/entropy.phtml');
		$this->getLayout()->getBlock('content')->append($block);
		$this->renderLayout();
	}
	*/
	
	
	public function sendOTPAction(){
	    
	    try{
	        Mage::log('=> Margshri_Common_Frontend_Customer_RegistrationController->sendOTPAction method', null, 'system.log', true);
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

	        if($otpVO->getMobileNumber() == null){
	            Mage::throwException('Please Enter Mobile Number.');
	        }
	        
	        // Magento Customer Table Verification By Mobile Number
	        $customer = Mage::getModel('customer/customer')->getCollection()->addAttributeToSelect('*')->addAttributeToFilter('mobilenumber', $otpVO->getMobileNumber())->getFirstItem();
	        $customerID = $customer->getData("entity_id");
	        if($customerID != null && $customerID != ""){
	            $responseVO->setErrorKey("MOBILE_NUMBER");
	            Mage::throwException('Already an Account Associated with this Mobile Number.');
	        }
	        
	        $customerVO = new Margshri_Common_VO_Customer_CustomerVO();
	        $customerVO->setID(0);
	        $customerVO->setFirstName("guest");
	        $customerVO->setLastName("guest");
	        $customerVO->setEmailID("guest@gmail.com");
	        $customerVO->setMobileNumber($otpVO->getMobileNumber());
	        $customerVO->setStatusID(Margshri_Common_VO_Customer_CustomerStatusVO::$INACTIVE);
	        $customerVO->setIsShowProfile(0);
	        $customerVO->setIsMobileOTPVerified(0);
	        $isMobile = Zend_Http_UserAgent_Mobile::match(Mage::helper('core/http')->getHttpUserAgent(),$_SERVER);
	        if($isMobile){
	            $customerVO->setIsMobileRequest(1);
	        }
	        
	        // Check Duplicacy apct_customer Table By Mobile Number  
	        $customerModel = Mage::getModel(Margshri_Common_VO_Customer_CustomerVO::$MODELPATH);
	        $custMobDataObj = $customerModel->getResource()->getByMobileNumber($otpVO->getMobileNumber());
	        if($custMobDataObj !== false){
	            if($custMobDataObj['IsMobileOTPVerified'] == 1){
	                
	                if($custMobDataObj['CustomerID'] == "" || $custMobDataObj['CustomerID'] == null){
	                    $custMobDataObj['CustomerID'] = null;
	                }
	                
	                if($custMobDataObj['StatusID'] == Margshri_WebPortal_VO_StatusVO::$ACTIVE && $custMobDataObj['CustomerID'] != null  ){
	                    $responseVO->setErrorKey("MOBILE_NUMBER");
	                    Mage::throwException('Already an Account Associated with this Mobile Number.');
	                }
	            }
	            
	        }else{
	            // Save Customer
    	        $adapter->beginTransaction();
    	        $isTransactionStart = true;
    	        $custRegiRespo = $customerModel->getResource()->saveFrontDB($customerVO);
    	        if($custRegiRespo['status'] != "SUCCESS"){
    	            Mage::throwException($custRegiRespo['message']);
    	        }
    	        $adapter->commit();
	        }
	        
	        // Get Randamally 4 Digit OTP
	        $otp = rand(1000,9999);
	        $systemConfigModel = Mage::getModel(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$MODELPATH);
	        $expireSec = $systemConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$CUSTOMER_REGISTRATION_OTP_EXPIRED_TIME_IN_SEC);
	        
	        $otpVO->setID(0);
	        $otpVO->setOTP($otp);
	        
	        // Get Last OTP With This Mobile Number 
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
	        $responseData = $responseVO->getResponseData();
	        $lastInsertedOTPID = $responseData['OTPID'];
	        $adapter->commit();
	        
	        $responseVO->setSuccessMessage("Successfully OTP Sent.");
	        $responseVO->setResponseData(array('OTPID'=>$lastInsertedOTPID));
	    }catch (Exception $e){
	        if($isTransactionStart == true){
	            $adapter->rollBack();
	        }
	        $responseVO->setSuccessMessage(null);
	        $responseVO->setErrorMessage($e->getMessage());
	        Mage::log('=> Margshri_Common_Frontend_Customer_RegistrationController->Error'. $e->getMessage(), null, 'system.log', true);
	    }
	    
	    $this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
	    return;
	    
	}
	
	
	public function verifyOTPAction(){
	    
	    try{
	        Mage::log('=> Margshri_Common_Frontend_Customer_RegistrationController->verifyOTPAction method', null, 'system.log', true);
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
	        $customerVO->setIsMobileOTPVerified(1);
	        
	        $customerModel = Mage::getModel(Margshri_Common_VO_Customer_CustomerVO::$MODELPATH);
	        
	        // Get By Mobile Number
	        $custMobDataObj = $customerModel->getResource()->getByMobileNumber($otpVO->getMobileNumber());
	        if($custMobDataObj === false){
	            Mage::throwException('Mobile Number Not Found.');
	        }
	        
	        if($custMobDataObj['CustomerID'] == "" && $custMobDataObj['CustomerID'] == null){
	            $custMobDataObj['CustomerID'] = null;
	        }
	        
	        if($custMobDataObj['IsMobileOTPVerified'] == 1){
	            if($custMobDataObj['StatusID'] == Margshri_WebPortal_VO_StatusVO::$ACTIVE && $custMobDataObj['CustomerID'] != null){
	                Mage::throwException('Already an Account Associated with this Mobile Number.');
	            }
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
	        
	        $systemConfigModel = Mage::getModel(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$MODELPATH);
	        $expireSec = $systemConfigModel->getResource()->getConfigValueByConfigCode(Margshri_WebPortal_VO_Master_System_SystemConfigVO::$CUSTOMER_REGISTRATION_OTP_EXPIRED_TIME_IN_SEC);
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
	        
	        // Set Mobile Number In Session
	        // Mage::register("CurrentRegisterMobileNumber", $otpVO->getMobileNumber());
	        Mage::getSingleton('core/session')->setCurrentRegisterMobileNumber($otpVO->getMobileNumber());
	        
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
