<?php
class Dakiya_API_SMSSender_MSG91{

	public static function sendSMS(Dakiya_VO_SMS_SendSMS_SendSMSVO $sendSMSVO){
		try{
			Mage::log('=> Dakiya_API_SMSSender_MSG91->sendSMS Method.. ', null, 'system.log', true);
			$responseVO = new Dakiya_VO_BaseVO();
			
			//Prepare you post parameters
			$postData = array(
					'authkey' => $sendSMSVO->getAuthKey(),
					'message' => urlencode($sendSMSVO->getSMSContent()),
					'sender' => $sendSMSVO->getSenderID(),
					'route' => $sendSMSVO->getRoute(),
					'mobiles' => $sendSMSVO->getReceiverMobileNO()
			);
	
			// init the resource
			$ch = curl_init();
			curl_setopt_array($ch, array(
					CURLOPT_URL => $sendSMSVO->getURL(),
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_POST => true,
					CURLOPT_POSTFIELDS => $postData
					//,CURLOPT_FOLLOWLOCATION => true
			));
			Mage::log('=> Dakiya_API_SMSSender_MSG91->Before Curl Call', null, 'system.log', true);
			//get response
			$output = curl_exec($ch);
			curl_close($ch);
			
			if (curl_errno($ch)) {
				$c_error = curl_error($ch);
				if (empty($c_error)) {
					$c_error = 'Some server error';
				}
				Mage::throwException($c_error);
			}else{
				$responseVO->setSuccessMessage("Successfully Sent !");
			}
			Mage::log('=> Dakiya_API_SMSSender_MSG91->After Curl Call', null, 'system.log', true);
			$responseVO->setResponseData($output);
			
		}catch (Exception $e) {
			Mage::log('=> Dakiya_API_SMSSender_MSG91->Error'. $e->getMessage(), null, 'system.log', true);
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;

	}

}