<?php
class Dakiya_API_SMSSender_AStar{

	public static function sendSMS(Dakiya_VO_SMS_SendSMS_SendSMSVO $sendSMSVO){
		try{
			Mage::log('=> Dakiya_API_SMSSender_AStar->sendSMS Method.. ', null, 'system.log', true);
			$responseVO = new Dakiya_VO_BaseVO();
			
			//Prepare you post parameters
			$url = $sendSMSVO->getURL();
			$port = 80;
			$api_url = $url."username=".urlencode($sendSMSVO->getSenderName())."&password=".urlencode($sendSMSVO->getAuthKey())."&sender=". $sendSMSVO->getSenderID() ."&message=". urlencode($sendSMSVO->getSMSContent())."&numbers=".$sendSMSVO->getReceiverMobileNO()."&unicode=false&flash=false";
			
			
			$ch = curl_init( );
			curl_setopt ( $ch, CURLOPT_URL, $api_url );
			curl_setopt ( $ch, CURLOPT_PORT, $port );
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			// Allowing cUrl funtions 20 second to execute
			curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
			// Waiting 20 seconds while trying to connect
			curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
			 
			Mage::log('=> Dakiya_API_SMSSender_AStar->Before Curl Call', null, 'system.log', true);
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
			    
			    $smsSentJsonResStr = $output;
			    $smsSentJsonRes = json_decode($smsSentJsonResStr, true);
			    if($smsSentJsonRes['return'] == false){
			        Mage::throwException($smsSentJsonRes['message']);
			    }
			    
				$responseVO->setSuccessMessage("Successfully Sent !");
			}
			Mage::log('=> Dakiya_API_SMSSender_AStar->After Curl Call', null, 'system.log', true);
			$responseVO->setResponseData($output);
			
		}catch (Exception $e) {
			Mage::log('=> Dakiya_API_SMSSender_AStar->Error'. $e->getMessage(), null, 'system.log', true);
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;

	}

}