<?php
class Dakiya_Model_SMS_SendSMS_SendSMS extends Mage_Core_Model_Abstract{
	
	protected function _construct(){
		parent::_construct();
		$this->_init('dakiya/SMS_SendSMS_SendSMS');
	}
	
	public function sendSMS(Dakiya_VO_SMS_SendSMS_SendSMSVO $sendSMSVO, $plateForm = null){
		try{
			Mage::log('=> Dakiya_Model_SMS_SendSMS_SendSMS->sendSMS', null, 'system.log', true);
			$responseVO = new Dakiya_VO_BaseVO();
			$adapter = new Dakiya_VO_SMS_SendSMS_SendSMSVO();
			$dbTransactionStart = false;
			$remarks = '';
			$totalTran= 0; $passTran = 0; $failTran = 0; $skipTran = 0;
			
			// GET SMS CONFIG VO
			$smsConfigModel  = Mage::getModel('dakiya/Master_SMS_SMSConfig');
			$smsConfigDataObj= $smsConfigModel->getResource()->getByID($sendSMSVO->getSMSConfigID());
			
			if($smsConfigDataObj === false){
				Mage::throwException('SMS Configuration Failed !');
			}
			
			$smsConfigDTO = new Dakiya_VO_Master_SMS_SMSConfigVO();
			/* @var $smsConfigVO Dakiya_VO_Master_SMS_SMSConfigVO */
			$smsConfigVO  = Dakiya_Helper_Utility::setVO($smsConfigDTO, $smsConfigDataObj);
			
			Mage::log('=> SMS Configuration Found', null, 'system.log', true);
			
			// GET TEMPLATE VO
			if($sendSMSVO->getSMSTemplateID() == null && $sendSMSVO->getSMSContent() != null){
				$sendSMSVO->setSMSTemplateID(Dakiya_VO_Master_SMS_SMSTemplateVO::$MANUAL_SMS_CONTENT);
				Mage::log('=> MANUAL SMS CONTENT', null, 'system.log', true);
			}
			
			$smsTemplateModel   = Mage::getModel('dakiya/Master_SMS_SMSTemplate');
			$smsTemplateDataObj = $smsTemplateModel->getResource()->getByID($sendSMSVO->getSMSTemplateID());
			
			if($smsTemplateDataObj === false){
				Mage::throwException('SMS Template Not Found !');
			}
			
			$smsTemplateDTO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
			/* @var $smsTemplateVO Dakiya_VO_Master_SMS_SMSTemplateVO */
			$smsTemplateVO  = Dakiya_Helper_Utility::setVO($smsTemplateDTO, $smsTemplateDataObj);
			Mage::log('=> SMS Template VO Found', null, 'system.log', true);
			
			// SET SMS CONTENT WITH QUERY / USER MANUAL SMS CONTENT
			if($smsTemplateVO->getQuery() != null && $smsTemplateVO->getQuery() != ''){
				$smsContent = $this->getResource()->getSMSContentByQuery($smsTemplateVO);
				$smsTemplateVO->setContent($smsContent);
				Mage::log('=> SMS Content By Query', null, 'system.log', true);
			}else if($sendSMSVO->getSMSContent() != null){
				$smsContent = $sendSMSVO->getSMSContent();
				$smsTemplateVO->setContent($smsContent);
				Mage::log('=> SMS Content From URI MANUAL', null, 'system.log', true);
			}
			
			
			// GET CUSTOMER (RECIEVER) MOBILE NUMBER
			$userMobileNumbers = explode(',', $sendSMSVO->getReceiverMobileNO());
			$totalTran = sizeof($userMobileNumbers);
			foreach($userMobileNumbers as $userMobileNumber){
				
				$sendSMSVO = new Dakiya_VO_SMS_SendSMS_SendSMSVO();
				
				// GET USER VO
// 				$userModel   = Mage::getModel('dakiya/User_User_User');
// 				$userDataObj = $userModel->getResource()->getByMobileNumber($userMobileNumber);
// 				if($userDataObj !== false){
// 					$userDTO = new Dakiya_VO_User_User_UserVO();
// 					/* @var $userVO  Dakiya_VO_User_User_UserVO */
// 					$userVO  = Dakiya_Helper_Utility::setVO($userDTO, $userDataObj);
// 					$sendSMSVO->setUserID($userVO->getUserID());
// 				}else{
// 					Mage::log('=> UnRegistered Mobile Number ', null, 'system.log', true);
// 					if($remarks == ''){
// 						$remarks = 'UnRegistered Mobile Number';
// 					}else{
// 						$remarks = $remarks . " | UnRegistered Mobile Number";
// 					}
// 					$sendSMSVO->setUserID(null);
// 				}
				
				$sendSMSVO->setUserID(null);
				$sendSMSVO->setSMSTemplateID($smsTemplateVO->getTemplateID());
				$sendSMSVO->setSMSConfigID($smsConfigVO->getConfigID());
				$sendSMSVO->setReceiverMobileNO($userMobileNumber);
				
				// SET CONNECTION AUTHENTICATION
				$sendSMSVO->setAuthKey($smsConfigVO->getAuthKey());
				$sendSMSVO->setSenderID($smsConfigVO->getSenderID());
				$sendSMSVO->setRoute($smsConfigVO->getRoute());
				$sendSMSVO->setURL($smsConfigVO->getURL());
				
				// GET SMS SENDER VO
				$sendSMSVO->setSenderMobileNO($smsConfigVO->getSenderMobileNO());
				$sendSMSVO->setSenderName($smsConfigVO->getSenderName());
				
				// SET RECEIVER INFO
				$sendSMSVO->setReceiverMobileNO($userMobileNumber);
				
				// SET SMS SUBJECT AND BODY
				$sendSMSVO->setSMSContent($smsTemplateVO->getContent());
				
				// SEND SMS
				$responseVO = Dakiya_API_SMSSender_AStar::sendSMS($sendSMSVO);
				
				if($responseVO->getSuccessMessage() != null){
					$passTran++;
					if($remarks == ''){
						$remarks = $responseVO->getSuccessMessage();
					}else{
						$remarks = $remarks . " | " . $responseVO->getSuccessMessage();
					}
					$sendSMSVO->setStatusID(Dakiya_VO_Master_SMS_SendSMSStatusVO::$SENT);
				}else if($responseVO->getErrorMessage() != null){
					$failTran++;
					if($remarks == ''){
						$remarks = $responseVO->getErrorMessage();
					}else{
						$remarks = $remarks . " | " . $responseVO->getErrorMessage();
					}
					$sendSMSVO->setStatusID(Dakiya_VO_Master_SMS_SendSMSStatusVO::$FAILED);
				}else{
					//$sendSMSVO->setRemarks($remarks);
					//$sendSMSVO->setStatusID(Dakiya_VO_Master_SMS_SendSMSStatusVO::$FAILED);
					$skipTran++;
					continue;
				}	
				
				// SAVE SMS DATA
				$adapter->getAdapter()->beginTransaction();
				$dbTransactionStart = true;
				
				if($plateForm == "frontend"){
				    $responseVO = $this->getResource()->frontSaveDB($sendSMSVO);
				}else{
				    $responseVO = $this->getResource()->saveDB($sendSMSVO);
				}
				
				if($responseVO->getErrorMessage() != null){
					$adapter->getAdapter()->rollBack();
					Mage::log('=> Dakiya_Model_SMS_SendSMS_SendSMS->SAVE SMS DATA Error'. $responseVO->getErrorMessage() , null, 'system.log', true);
					continue;
				}
				
				$adapter->getAdapter()->commit();
				
			} // END FOREACH
			
			$responseMSG = "Total => " . $totalTran . " : Successed => " . $passTran . " : Failed => " . $failTran . " : Skipped => " . $skipTran;
			if($passTran == 0){
				Mage::throwException($responseMSG);
			}else{
				$responseVO->setSuccessMessage($responseMSG);
				Mage::log('=> Dakiya_Model_SMS_SendSMS_SendSMS->Success'. $responseMSG, null, 'system.log', true);
			}	
		}catch (Exception $e) {
			if($dbTransactionStart){
				$adapter->getAdapter()->rollBack();
			}
			$responseVO->setErrorMessage($e->getMessage());
		}
		
		return $responseVO; 
	}
}