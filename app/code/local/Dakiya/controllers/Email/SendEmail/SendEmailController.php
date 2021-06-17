<?php
class Dakiya_Email_SendEmail_SendEmailController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='dakiya/Email_SendEmail_Grid';
	
	protected function _initAction(){
		$this->loadLayout();
		$this->_setActiveMenu('communication');
		return $this;
	}
	
	
	public function indexAction(){
		$this->_initAction();
		$this->renderLayout();
	}

	
	public function sentEmailListAction(){
		$this->_initAction();
		$this->renderLayout();
	}

	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}
	
	public function sendEmailAction(){
	
		try{
	
			$responseVO = new Dakiya_VO_BaseVO();
			$adapter  = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			$post = $this->getRequest()->getPost();
			$totalTran= 0; $passTran = 0; $failTran = 0; $skipTran = 0;
	
			if (empty($post)) {
				Mage::throwException($this->__('Invalid form data.'));
			}
	
			$sendEmailDataObj = json_decode($post["SendEmailDataObj"],true);
				
			$sendEmailDTO = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			/* @var $sendEmailVO Dakiya_VO_Email_SendEmail_SendEmailVO */
			$sendEmailVO  = Dakiya_Helper_Utility::setVO($sendEmailDTO, $sendEmailDataObj);
	
			if($sendEmailVO->getEmailTemplateID() == null){
				Mage::throwException($this->__('Please Select Email Template !'));
			}
	
			if($sendEmailVO->getEmailConfigID() == null){
				Mage::throwException($this->__('Please Select Sender Email !'));
			}
	
			if($sendEmailVO->getReceiverEmail() == null){
				Mage::throwException($this->__('Receiver Email Not Found !'));
			}
				
			$userEmails = explode(',', $sendEmailVO->getReceiverEmail());
			$totalTran = sizeof($userEmails);
			
			
			
			
			foreach($userEmails as $userEmail){
				/*
				$responseVO->setErrorMessage($userEmail);
				$this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
				return;
				*/
				
				$newSendEmailVO = new Dakiya_VO_Email_SendEmail_SendEmailVO();
	
				// GET USER VO
// 				$userModel   = Mage::getModel('dakiya/User_User_User');
// 				$userDataObj = $userModel->getResource()->getByEmail($userEmail);
// 				if($userDataObj === false){
// 					$newSendEmailVO->setRemarks('UnRegistered EmailID');
// 					$newSendEmailVO->setUserID(null);
// 				}else{
// 					$userDTO = new Dakiya_VO_User_User_UserVO();
// 					/* @var $userVO  Dakiya_VO_User_User_UserVO */
// 					$userVO  = Dakiya_Helper_Utility::setVO($userDTO, $userDataObj);
// 					$newSendEmailVO->setUserID($userVO->getUserID());
// 				}	
				$newSendEmailVO->setEmailTemplateID($sendEmailVO->getEmailTemplateID());
				$newSendEmailVO->setEmailConfigID($sendEmailVO->getEmailConfigID());
				$newSendEmailVO->setReceiverEmail($userEmail);
				//$newSendEmailVO->setRequestID($sendEmailVO->getRequestID());
	
				// SENDING EMAIL
				$sendEmailModel= Mage::getModel('dakiya/Email_SendEmail_SendEmail');
				/* @var $responseVO Dakiya_VO_BaseVO */
				$responseVO = $sendEmailModel->sendEmail($newSendEmailVO);
				if($responseVO->getErrorMessage() != null){
					$failTran++;
					$newSendEmailVO->setStatusID(Dakiya_VO_Master_Email_SendEmailStatusVO::$FAILED);
					$newSendEmailVO->setRemarks($newSendEmailVO->getRemarks() .' '. $responseVO->getErrorMessage());
				}else{
					$newSendEmailVO->setStatusID(Dakiya_VO_Master_Email_SendEmailStatusVO::$SENT);
					$newSendEmailVO->setRemarks($newSendEmailVO->getRemarks() .' '. $responseVO->getSuccessMessage());
				}
					
				//SAVE EMAIL DATA
				$newSendEmailVO->setSentEmailID(0); // 0 for insert OR n > 0 for update
				$adapter->getAdapter()->beginTransaction();
				$responseVO = $sendEmailModel->getResource()->saveDB($newSendEmailVO);
				if($responseVO->getErrorMessage() === false){
					$skipTran++;
					$adapter->getAdapter()->rollBack();
				}    
				
				$passTran++; 
				$adapter->getAdapter()->commit();
			} // END FOREACH
	
	
			if($failTran == 0){
				$responseVO->setSuccessMessage("Total=>" .$totalTran. " : Successed => " .$passTran. " : Failed => ".$failTran. " : Skipped => " .$skipTran);
				if($sendEmailVO->getRequestID() != null && $sendEmailVO->getRequestID() != ''){
					$commonModel = Mage::getModel('dakiya/Miscellaneous_Common_Common');
					$commonVO = $commonModel->getResource()->getCommonVOByRequestID($sendEmailVO->getRequestID());
					Mage::register('CurrentCommonVO', $commonVO);
					$userSentEmailHistoryBlock = $this->getLayout()->createBlock("dakiya/CRM_ComplaintRegistration_ComplaintRegistration_Form_UserSentEmailHistory");
					$responseVO->setResponseData($userSentEmailHistoryBlock->toHtml());
				}
			}else{
				$responseVO->setErrorMessage("Total=>" .$totalTran. " : Successed => " .$passTran. " : Failed => ".$failTran. " : Skipped => " .$skipTran);
			}
	
		}catch (Exception $e) {
			if($dbTransactionStart){
				$adapter->getAdapter()->rollBack();
			}
			$responseVO->setErrorMessage($e->getMessage());
		}
	
		$this->getResponse()->setBody(Mage::helper('dakiya/Utility')->jsonEncode($responseVO->getBaseDataArray()));
		return;
	
	}
	 
}