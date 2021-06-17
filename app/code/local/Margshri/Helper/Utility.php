<?php
class Margshri_Helper_Utility extends Mage_Core_Helper_Abstract {
 
 	public static function getServerPath(){
 		$urlParse = parse_url($_SERVER['REQUEST_URI']);
 		$path = explode('/',$urlParse ['path']);
 		
 		if($path[1] == 'index.php'){
 			$serverPath = $_SERVER['DOCUMENT_ROOT'];
 		}else{
 			$serverPath = $_SERVER['DOCUMENT_ROOT'] . "/" . $path[1];
 		}
 		
 		return $serverPath;
 	}

 	public static function getServerURL(){
 		$urlParse = parse_url($_SERVER['REQUEST_URI']);
 		$path = explode('/',$urlParse ['path']);
 		$serverURL = "http://" . $_SERVER['HTTP_HOST'] . "/" . $path[1];
 		return $serverURL;
 	}

 	public static function setContentTypeForExport($filename, $contentType){
 		header("Content-Disposition: attachment; filename=\"$filename\"");
 		header("Content-Type: " . $contentType);
 	}

 	public static function getUniqueName(){
 		$FileName = rand(100000,999999) . '_' . date("Ymdhis")  ;
 		return $FileName;
 	}
 	
	public static function sendEmail(){
    	$res = require_once(Mage::getBaseDir('app') . '/code/local/Margshri/API/PHPMailer/PHPMailerAutoload.php');
        $mail = new PHPMailer;
			

		/*
		$mail->isSMTP();                                   // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                            // Enable SMTP authentication
		$mail->Username = 'vipin.2122@gmail.com';          // SMTP username
		$mail->Password = ''; 							   // SMTP password
		$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                 // TCP port to connect to
		*/

		$mail->isSMTP();
		$mail->Host = 'a2plcpnl0299.prod.iad2.secureserver.net';
		$mail->Port = 25;
		$mail->SMTPAuth = false;
		$mail->SMTPSecure = false;
 

		$mail->setFrom('acgroupvipin@gmail.com', 'Vipin');
		$mail->addReplyTo('acgroupvipin@gmail.com', 'Shakya');
		$mail->addAddress('acgroupvipin@gmail.com');   // Add a recipient
		//$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');

		$mail->isHTML(true);  // Set email format to HTML

		$bodyContent = '<h1>How to Send Email using PHP in Localhost by CodexWorld</h1>';
		$bodyContent .= '<p>This is the HTML email sent from localhost using PHP script by <b>CodexWorld</b></p>';

		$mail->Subject = 'Email from Localhost by CodexWorld';
		$mail->Body    = $bodyContent;

		if(!$mail->send()) {
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
		} else {
			echo 'Message has been sent';
		}

    }
    
    
    public static function isACLAllowed($resourceLookup){
    	try {
    		$role  = Mage::getSingleton('admin/session')->getUser()->getRole();
    		if($role->getData('role_id') == 1){
    			//admin role
    			return true;
    		}
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
    
 
}
