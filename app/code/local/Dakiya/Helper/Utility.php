<?php

class Dakiya_Helper_Utility extends Mage_Core_Helper_Abstract {

	public function jsonEncode($valueToEncode, $cycleCheck = false, $options = array()){
        $json = Zend_Json::encode($valueToEncode, $cycleCheck, $options);
        /* @var $inline Mage_Core_Model_Translate_Inline */
        $inline = Mage::getSingleton('core/translate_inline');
        if ($inline->isAllowed()) {
            $inline->setIsJson(true);
            $inline->processResponseBody($json);
            $inline->setIsJson(false);
        }
        return $json;
    }
    
    
    public static function setVO($instance, $associcativeArray){
    
    	if(!is_array($associcativeArray)){
    		$associcativeArray = $associcativeArray->toArray();
    	}
    	foreach(  $associcativeArray as $key=>$value ){
    
    		$functionName = "set{$key}";
    		$instance->$functionName($value);
    	}
    	return $instance;
    }
    
    
    public static function sendEmail(Dakiya_VO_Miscellaneous_EmailVO $emailVO){
    	require_once(Mage::getBaseDir('app') . '/code/local/Dakiya/API/PHPMailer/PHPMailerAutoload.php');
    	$responseVO = new Dakiya_VO_BaseVO();
    	$mail = new PHPMailer;
    	
    	$mail->isSMTP();
    	$mail->SMTPAuth = true;
    	$mail->SMTPSecure = $emailVO->getSMTPSecure(); // Enable TLS encryption, `ssl` also accepted
    	$mail->Port = $emailVO->getPort();
    	$mail->Host = $emailVO->getHostName();     
    	$mail->Username = $emailVO->getUserEmail();
    	$mail->Password = $emailVO->getUserPass();
    	
    	$mail->setFrom($emailVO->getSenderEmail(), $emailVO->getSenderName());
    	$mail->addReplyTo($emailVO->getReplyToEmail(), $emailVO->getReplyToName());
    	
    	foreach ($emailVO->getReceiverEmailAddress() as $emailAddress){
    		$mail->addAddress($emailAddress);
    	}
   	
    	foreach ($emailVO->getReceiverCCAddress() as $ccAddress){
    		$mail->addCC($ccAddress);
    	}
    	
    	foreach ($emailVO->getReceiverBCCAddress() as $bccAddress){
    		$mail->addBCC($bccAddress);
    	}
    	
    	$mail->isHTML(true);
    	$mail->Subject = $emailVO->getEmailSubject();
    	$mail->Body    = $emailVO->getEmailBody();
    	
    	if(!$mail->send()){
    		$responseVO->setErrorMessage('Mailer Error: ' . $mail->ErrorInfo);
    	} else {
    		$responseVO->setSuccessMessage('Message has been sent');
    	}
    	return $responseVO;
    }
    
    
    public static function isACLAllowed($resourceLookup){
    	try {
    		$session = Mage::getSingleton('admin/session');
    		$resourceId = $session->getData('acl')->get($resourceLookup)->getResourceId();
    		if (!$session->isAllowed($resourceId)) {
    			throw new Exception('');
    		}
    		return true;
    	}
    	catch (Exception $e) {
    		//$this->_forward('denied');
    		return false;
    	}
    }
    
    
    public static function getServerPath(){
    	$urlParse = parse_url($_SERVER['REQUEST_URI']);
    	$path = explode('/',$urlParse ['path']);
    	$serverPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $path[1];
    
    	return $serverPath;
    }
    
    
    public static function getServerURL(){
    	$urlParse = parse_url($_SERVER['REQUEST_URI']);
    	$path = explode('/',$urlParse ['path']);
    	$serverURL = "http://" . $_SERVER['HTTP_HOST'] . "/" . $path[1];
    	return $serverURL;
    }
    
    
    public static function getAdminUserVO(){
    	$adminUserDataObj = Mage::getSingleton('admin/session')->getUser();
    	 
    	$adminUserVO = new Dakiya_VO_Miscellaneous_AdminUserVO();
    	$adminUserVO->setUserID($adminUserDataObj['user_id']);
    	$adminUserVO->setUserName($adminUserDataObj['username']);
    	$adminUserVO->setFirstName($adminUserDataObj['firstname']);
    	$adminUserVO->setLastName($adminUserDataObj['lastname']);
    	$adminUserVO->setFullName($adminUserDataObj['firstname'] .' '. $adminUserDataObj['lastname']);
    	$adminUserVO->setEmail($adminUserDataObj['email']);
		return $adminUserVO;    	
		
		
    }
    
    
    public static function checkPermissionByRoleIDs($roleIDsString){
    	
    	$currentRoleID = implode('', Mage::getSingleton('admin/session')->getUser()->getRoles());
    	if($roleIDsString != null && $roleIDsString != ''){
	    	$roleIDsArray = explode('~', $roleIDsString);
			if(in_array($currentRoleID, $roleIDsArray) ){
					return true;
			}
    	}else if($roleIDsString == null || $roleIDsString == ''){ // for default admin 
    		return true;
    	}
    	return false;
    }
    
    
    public static function getCurrentAdminRoleID(){
    	$currentRoleID = implode('', Mage::getSingleton('admin/session')->getUser()->getRoles());
    	return $currentRoleID;
    }
    
    
    public static function getCurrentAdminUserID(){
    	$currentRoleID = implode('', Mage::getSingleton('admin/session')->getUser()->getRoles());
    	return $currentRoleID;
    }
    
    
    public static function setContentTypeForExport($filename, $contentType){
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: " . $contentType);
    }
    
    
    public static function getTodayDate($format){
    	return date($format, Mage::getModel('core/date')->timestamp(time()));
    }

    
    public static function getConfigValueByConfigID($configID){
    	$model   = Mage::getModel('dakiya/Master_System_SystemConfig_SystemConfig');
    	$dataObj = $model->getResource()->getConfigValueByConfigID($configID);
    	return $dataObj['ConfigValue']; 
    }
    
    
    public static function getUniqueName(){
    	$FileName = rand(100000,999999) . '_' . date("Ymdhis")  ;
    	return $FileName;
    }
    
    public static function getCronJobAdminUserID(){
    	$cronJobAdminUserID = 12;
    	return $cronJobAdminUserID;
    }
    
  
}