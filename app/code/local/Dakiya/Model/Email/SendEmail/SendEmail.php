<?php
class Dakiya_Model_Email_SendEmail_SendEmail extends Mage_Core_Model_Abstract  {
	
	protected function _construct(){
		parent::_construct();
		$this->_init('dakiya/Email_SendEmail_SendEmail');
	}
	
	
	public function setEmailParam(Dakiya_VO_Email_SendEmail_SendEmailVO $sendEmailVO){
	
		try{
			$responseVO = new Dakiya_VO_BaseVO();
			
			// GET EMAIL CONFIG VO
			$emailConfigModel  = Mage::getModel('dakiya/Master_Email_EmailConfig');
			$emailConfigDataObj= $emailConfigModel->getResource()->getByID($sendEmailVO->getEmailConfigID());
			if($emailConfigDataObj === false){
				Mage::throwException('Email Configuration Failed !');
			}
			$emailConfigDTO = new Dakiya_VO_Master_Email_EmailConfigVO();
			/* @var $emailConfigVO Dakiya_VO_Master_Email_EmailConfigVO */
			$emailConfigVO  = Dakiya_Helper_Utility::setVO($emailConfigDTO, $emailConfigDataObj);
			
			// GET TEMPLATE VO
			/* @var $emailTemplateVO Dakiya_VO_Master_Email_EmailTemplateVO */
			$emailTemplateVO = $sendEmailVO->getEmailTemplateVO();
			if($emailTemplateVO == null){
				$emailTemplateModel   = Mage::getModel('dakiya/Master_Email_EmailTemplate');
				$emailTemplateDataObj = $emailTemplateModel->getResource()->getByID($sendEmailVO->getEmailTemplateID());
		
				if($emailTemplateDataObj === false){
					Mage::throwException('Email Template Not Found !');
				}
				$emailTemplateDTO = new Dakiya_VO_Master_Email_EmailTemplateVO();
				$emailTemplateVO  = Dakiya_Helper_Utility::setVO($emailTemplateDTO, $emailTemplateDataObj);
				
				// SET EMAIL CONTENT
				/* @var $sendEmailVO Dakiya_VO_Email_SendEmail_SendEmailVO */
				if($sendEmailVO->getEmailContent() != null && $sendEmailVO->getEmailContent() != ''){
					$emailContent = $sendEmailVO->getEmailContent();
				}elseif($emailTemplateVO->getContent() != null && $emailTemplateVO->getContent() != '' && $emailTemplateVO->getQuery() != null && $emailTemplateVO->getQuery() != ''){
					$emailContent = $emailTemplateModel->getResource()->getEmailContentByQuery($emailTemplateVO);
				}elseif($emailTemplateVO->getContent() != null && $emailTemplateVO->getContent() != ''){
					$emailContent = $emailTemplateVO->getContent();
				}else{
					Mage::throwException('Email Template Query Is Empty Or Email Content Is Empty !');
				}
				
				// SET EMAIL SUBJECT
				if($sendEmailVO->getEmailSubject() != null && $sendEmailVO->getEmailSubject() != ''){
					$emailSubject = $sendEmailVO->getEmailSubject();
				}elseif($emailTemplateVO->getSubject() != null && $emailTemplateVO->getSubject() != ''){
					$emailSubject = $emailTemplateVO->getSubject();
				}else{
					Mage::throwException('Email Subject Not Set !');
				}
				
			}	
			
			// SET CONNECTION AUTHENTICATION
			$sendEmailVO->setHostName($emailConfigVO->getHostName());
			$sendEmailVO->setUserEmail($emailConfigVO->getUserEmail());
			$sendEmailVO->setUserPass($emailConfigVO->getUserPass());
			$sendEmailVO->setSMTPSecure($emailConfigVO->getSMTPSecure());
			$sendEmailVO->setPort($emailConfigVO->getPort());
			
			// GET EMAIL SENDER VO
			$sendEmailVO->setSenderEmail($emailConfigVO->getSenderEmail());
			$sendEmailVO->setSenderName($emailConfigVO->getSenderName());
			$sendEmailVO->setReplyToEmail($emailConfigVO->getReplyToEmail());
			$sendEmailVO->setReplyToName($emailConfigVO->getReplyToName());
			
			// SET RECEIVER INFO
			$sendEmailVO->setReceiverEmailAddress(array($sendEmailVO->getReceiverEmail()));
			//$sendEmailVO->setReceiverEmailAddress(array("vipin.2122@gmail.com"));
			
			// SET EMAIL SUBJECT AND BODY
			
			$sendEmailVO->setEmailSubject($emailSubject);
			$sendEmailVO->setEmailBody($emailContent);
			
			$responseVO->setSuccessMessage("Set Email Param Successfully.");
			$responseVO->setResponseData($sendEmailVO);
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	}
	
	
	public function sendEmail(Dakiya_VO_Email_SendEmail_SendEmailVO $sendEmailVO){
		
		try{
			$responseVO = new Dakiya_VO_BaseVO();
			require_once(Mage::getBaseDir('app') . '/code/local/Dakiya/API/PHPMailer/PHPMailerAutoload.php');
			
			// SET EMAIL PARAM
			$responseVO = $this->setEmailParam($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			/* @var $sendEmailVO Dakiya_VO_Email_SendEmail_SendEmailVO */
			$sendEmailVO = $responseVO->getResponseData();
			
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = $sendEmailVO->getSMTPSecure(); // Enable TLS encryption, `ssl` also accepted
			$mail->Port = $sendEmailVO->getPort();
			$mail->Host = $sendEmailVO->getHostName();
			$mail->Username = $sendEmailVO->getUserEmail();
			$mail->Password = $sendEmailVO->getUserPass();
				
			$mail->setFrom($sendEmailVO->getSenderEmail(), $sendEmailVO->getSenderName());
			$mail->addReplyTo($sendEmailVO->getReplyToEmail(), $sendEmailVO->getReplyToName());
				
			foreach ($sendEmailVO->getReceiverEmailAddress() as $emailAddress){
				$mail->addAddress($emailAddress);
			}
		
			foreach ($sendEmailVO->getReceiverCCAddress() as $ccAddress){
				$mail->addCC($ccAddress);
			}
				
			foreach ($sendEmailVO->getReceiverBCCAddress() as $bccAddress){
				$mail->addBCC($bccAddress);
			}
				
			$mail->isHTML(true);
			$mail->Subject = $sendEmailVO->getEmailSubject();
			// $mail->Body = $sendEmailVO->getEmailBody();
			$mail->Body = str_replace(chr(194)," ",$sendEmailVO->getEmailBody()); 
				
			if(!$mail->send()){
				$responseVO->setErrorMessage('Mailer Error: ' . $mail->ErrorInfo);
			} else {
				$responseVO->setSuccessMessage('Email has been sent');
			}
			
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;	
	}
 
	
}
