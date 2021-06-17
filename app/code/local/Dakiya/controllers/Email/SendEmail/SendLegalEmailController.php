<?php
class Dakiya_Email_SendEmail_SendLegalEmailController extends Mage_Adminhtml_Controller_Action{
	
	protected function _initAction(){
		$this->loadLayout();
		$this->_setActiveMenu('communication');
		return $this;
	}
	
	
	public function indexAction(){
		$this->_initAction();
		$this->renderLayout();
	}
	
	public function sendEmailAction(){
	
		try{
	
			$responseVO = new Dakiya_VO_BaseVO();
			$adapter  = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			$post = $this->getRequest()->getPost();
			$isDBTransactionStart = false;
	
			if (empty($post)) {
				Mage::throwException('Invalid form data.');
			}
	
			$sendEmailDataObj = json_decode($post["SendEmailDataObj"],true);
				
			$sendEmailDTO = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			/* @var $sendEmailVO Dakiya_VO_Email_SendEmail_SendEmailVO */
			$sendEmailVO  = Dakiya_Helper_Utility::setVO($sendEmailDTO, $sendEmailDataObj);
			
			if($sendEmailVO->getEmailConfigID() == null){
				Mage::throwException('Please Select Sender Email.');
			}
			
			if($sendEmailVO->getEmailTemplateID() == null){
				Mage::throwException('Please Select Email Template.');
			}
	
			if($sendEmailVO->getReceiverEmail() == null){
				Mage::throwException('Please Enter Customer Email.');
			}
			
			if($sendEmailVO->getPNRNumber() == null){
				Mage::throwException('Please Enter PNR Number.');
			}
			
			if($sendEmailVO->getPaymentLink() == null){
				Mage::throwException('Please Enter Payment Link.');
			}
			
			if($sendEmailVO->getCollectibleAmount() == null){
				Mage::throwException('Please Enter Collectible Amount.');
			}

			// GET USER VO
			$userModel   = Mage::getModel('dakiya/User_User_User');
			$userDataObj = $userModel->getResource()->getByEmail($sendEmailVO->getReceiverEmail());
			if($userDataObj === false){
				Mage::throwException('UnRegistered Customer Email.');
				//$sendEmailVO->setRemarks('UnRegistered EmailID');
				//$sendEmailVO->setUserID(null);
			}
			$userDTO = new Dakiya_VO_User_User_UserVO();
			/* @var $userVO  Dakiya_VO_User_User_UserVO */
			$userVO  = Dakiya_Helper_Utility::setVO($userDTO, $userDataObj);
			$sendEmailVO->setUserID($userVO->getUserID());
			
			// GET TICKET VO
			$ticketModel = Mage::getModel('dakiya/Booking_Ticket_Ticket');
			$ticketDataObj=$ticketModel->getResource()->getByPNRNumber($sendEmailVO->getPNRNumber());
			if($ticketDataObj === false){
				Mage::throwException('PNR Number Not Exist !');
			}
			$ticketDTO = new Dakiya_VO_Booking_Ticket_TicketVO();
			$ticketVO  = Dakiya_Helper_Utility::setVO($ticketDTO, $ticketDataObj);
			$sendEmailVO->setRequestID($ticketVO->getRequestID());
	
			// SET EMAIL PARAM
			$sendEmailModel= Mage::getModel('dakiya/Email_SendEmail_SendEmail');
			$responseVO = $sendEmailModel->setEmailParam($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			
			$sendEmailVO = $responseVO->getResponseData();
			$emailContent= $sendEmailVO->getEmailBody();
			$dataObj['PNRNumber'] = $sendEmailVO->getPNRNumber();
			$dataObj['CollectibleAmount'] = $sendEmailVO->getCollectibleAmount();
			$dataObj['PaymentLink'] = $sendEmailVO->getPaymentLink();
			foreach ($dataObj as $key=>$value){
				$emailContent = str_replace("{".$key."}",$value,$emailContent);
			}
			$sendEmailVO->setEmailBody($emailContent);
			
			// SENDING EMAIL
			$responseVO = $sendEmailModel->sendEmail($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				$sendEmailVO->setStatusID(Dakiya_VO_Master_Email_SendEmailStatusVO::$FAILED);
				$sendEmailVO->setRemarks($responseVO->getErrorMessage());
				$errMsg['Status'] = "Error";
				$errMsg['Message'] = "Email Sending Failed !";
			}else{
				$sendEmailVO->setStatusID(Dakiya_VO_Master_Email_SendEmailStatusVO::$SENT);
				$sendEmailVO->setRemarks($responseVO->getSuccessMessage());
				$errMsg['Status'] = "Success";
				$errMsg['Message'] = "Successfully Sent !";
			}
				
			//SAVE EMAIL DATA
			$sendEmailVO->setSentEmailID(0); // 0 for insert OR n > 0 for update
			$adapter->getAdapter()->beginTransaction();
			$isDBTransactionStart = true;
			$responseVO = $sendEmailModel->getResource()->saveDB($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}    
			$adapter->getAdapter()->commit();

			if($errMsg['Status'] == 'Error'){
				$responseVO->setErrorMessage($errMsg['Message']);
			}else{
				$responseVO->setSuccessMessage($errMsg['Message']);
			}
			
		}catch (Exception $e) {
			if($isDBTransactionStart){
				$adapter->getAdapter()->rollBack();
			}
			$responseVO->setErrorMessage($e->getMessage());
		}
	
		$this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
		return;
	
	}
	 
}