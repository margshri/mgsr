<?php
class Dakiya_Model_Job_CronJob_CronJob extends Mage_Core_Model_Abstract  {

	/**
	 * Initialize resource model
	 */
	protected function _construct(){
		parent::_construct();
		$this->_init('dakiya/Job_CronJob_CronJob');
	}
	
	
	public function sendBluedartShipmentReminder(){
		
		try{
			$responseVO= new Dakiya_VO_BaseVO();
			$todayDate   = date('Y-m-d', Mage::getModel('core/date')->timestamp(time()));
			//$todayDate = "2017-06-01";
			$journeyFromDate = $todayDate;
			$journeyToDate = date('Y-m-d', strtotime("+4 days", strtotime($todayDate)));
			$bookingDate = $todayDate;
			
			$bookingFromDate = date('Y-m-d', strtotime("-1 days", strtotime($todayDate)));
			$bookingToDate   = $todayDate;
			
			$collection = Mage::getModel("dakiya/Booking_Request_UserBookingRequest")->getCollection();
			$adapter = new Dakiya_VO_Booking_Request_UserBookingRequestVO();
			
			$read =  $adapter->getAdapter();
			$select  = $read->select()
			->from(array("lubr"=>$collection->getTable("dakiya/localuserbookingrequest")), array("CODFirstName", "CODLastName", "CODAddress1", "CODAddress2", "CODPincode", "MobileNo"))
			->joinInner(array("lt"=>$collection->getTable("dakiya/localticket")), "lubr.RequestID=lt.RequestID", array("PNRNumber"=>"lt.PNRNumber", "CollectibleAmount"=>"lt.NetTicketAmount", "JourneyDate"=>new Zend_Db_Expr(" date(lt.JourneyDate)")))
			->joinInner(array("lc"=>$collection->getTable("dakiya/localcity")), "lubr.CODCity=lc.CityID", array("CODCityName"=>"lc.CityName"))
			->joinInner(array("ls"=>$collection->getTable("dakiya/localstateregion")), "lubr.CODState=ls.StateRegionID", array("CODStateName"=>"ls.StateRegionName"))
			->joinInner(array("lmdshipment"=>$collection->getTable("dakiya/locallmdshipment")), "lubr.RequestID=lmdshipment.RequestID", array("WaybillNo"=>"lmdshipment.WaybillNo"))
			->joinInner(array("lss"=>$collection->getTable("dakiya/locallmdstatus")), "lmdshipment.StatusID=lss.LMDStatusID", array("ShipmentStatus"=>"lss.StatusName"))
			->where('lubr.CurrStatusID = ?', Dakiya_VO_Master_Booking_UserBookingRequestStatusVO::$DISPATCHED)
			->where('lubr.PaymentMethodID=?', Dakiya_VO_Master_Payment_PaymentMethodVO::$COD)
			//->where( new Zend_Db_Expr("date(lt.BookedOn) = '".$bookingDate."'"))
			->where( new Zend_Db_Expr("date(lt.BookedOn) BETWEEN '".$bookingFromDate. "' AND '" . $bookingToDate. "'"))
			->where( new Zend_Db_Expr("date(lt.JourneyDate) BETWEEN '".$journeyFromDate. "' AND '" . $journeyToDate. "'"));
			$dataObjs = $read->fetchAll($select);
			
			if(sizeof($dataObjs) == 0){
				Mage::throwException("No Record Found !");
			}
			
			$content = '';
			
			$content .= '<p>Hi Arvind</p>';
			//$content .= '<p>&nbsp;</p>';
			$content .= '<p>Below are the list of shipments that needs to be delivered on priority. Request you to kindly instruct the respective branch for urgent delivery today itself.</p>';
			$content .= '<div>&nbsp;</div>';
			$content .= '<table border="1">';
			$content .= '<tr>';
			$content .= '<th>WayBillNO</th>';
			$content .= '<th>PNR NO</th>';
			$content .= '<th>Collectible Amt</th>';
			$content .= '<th>BlueDart Status</th>';
			$content .= '<th>Pincode</th>';
			$content .= '<th>Address</th>';
			$content .= '<th>Mobile NO</th>';
			$content .= '<th>Journey Date</th>';
			$content .= '</tr>';
			
			$shipmentTrackingModel = Mage::getModel("dakiya/shipping_shipment_shipmentTracking");
			foreach ($dataObjs as $dataObj){
				$address = $dataObj['CODFirstName'] ." ". $dataObj['CODLastName'] ." ". $dataObj['CODAddress1'] ." ". $dataObj['CODAddress2'];
				
				
				$shipmentTrackingDataObj = $shipmentTrackingModel->getResource()->getByWayBillNO($dataObj['WaybillNo']);
				if($shipmentTrackingDataObj != false){
					$shipmentTrackingDTO = new Dakiya_VO_Shipping_Shipment_ShipmentTrackingVO();
					/* @var $shipmentTrackingVO Dakiya_VO_Shipping_Shipment_ShipmentTrackingVO */
					$shipmentTrackingVO  = Dakiya_Helper_Utility::setVO($shipmentTrackingDTO, $shipmentTrackingDataObj);
					$shipmentStatus = $shipmentTrackingVO->getRemarks();
				}
				
				
				$content .= '<tr>';
				$content .= '<td>'.$dataObj['WaybillNo'].'</td>';
				$content .= '<td>'.$dataObj['PNRNumber'].'</td>';
				$content .= '<td>'.$dataObj['CollectibleAmount'].'</td>';
				$content .= '<td>'.$shipmentStatus.'</td>';
				$content .= '<td>'.$dataObj['CODPincode'].'</td>';
				$content .= '<td>'.$address.'</td>';
				$content .= '<td>'.$dataObj['MobileNo'].'</td>';
				$content .= '<td>'.date("M d, Y", strtotime($dataObj['JourneyDate'])).'</td>';
				$content .= '</tr>';
			}
			
			$content .= '</table>';
			
			$content .= '<div>&nbsp;</div>';
			$content .= '<div>&nbsp;</div>';
			$content .= '<div>&nbsp;</div>';
			$content .= '<p>Regards</p>';
			$content .= '<p>Anurag</p>';
			
			
			$sendEmailVO  = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			
			// SET EMAIL CONFIG ID
			$sendEmailVO->setEmailConfigID(Dakiya_VO_Master_Email_EmailConfigVO::$ANURAG_TEAM);
			
			// SET EMAIL CONFIG TEMPLATE ID
			$sendEmailVO->setEmailTemplateID(Dakiya_VO_Master_Email_EmailTemplateVO::$BLUEDART_SHIPMENT_REMINDER);
			
			// SET EMAIL SUBJECT
			$sendEmailVO->setEmailSubject("Priority Delivery Required - Anduril - ". date("M d, Y", strtotime($todayDate)) );
			
			// SET RECEIVER EMAIL
			//$sendEmailVO->setReceiverEmail("vipin.shakya@anduriltechnologies.com");
			$sendEmailVO->setReceiverEmail("arvindc@bluedart.com");
			//$sendEmailVO->setReceiverEmail("anurag@anduriltechnologies.com");
			
			
			// SET EMAIL PARAM
			$sendEmailModel = Mage::getModel('dakiya/Email_SendEmail_SendEmail');
			$responseVO = $sendEmailModel->setEmailParam($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			$sendEmailVO = $responseVO->getResponseData();
			
			// SET EMAIL CONTENT
			$sendEmailVO->setEmailBody($content);
			
			// SET CC
			//$sendEmailVO->setReceiverCCAddress(array('shriram.sharma@anduriltechnologies.com', 'nitish@anduriltechnologies.com', 'anurag@anduriltechnologies.com'));
			$sendEmailVO->setReceiverCCAddress(array('shriram.sharma@anduriltechnologies.com', 'anurag@anduriltechnologies.com'));
			
			// SEND EMAIL PARAM
			$responseVO = $sendEmailModel->sendEmail($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			
			// INSERT INTO SENT EMAIL TABLE
			$sendEmailVO->setSentEmailID(0);
			$sendEmailVO->setStatusID(Dakiya_VO_Master_Email_SendEmailStatusVO::$SENT);
			$sendEmailVO->setRemarks($responseVO->getSuccessMessage());
			
			//SAVE EMAIL DATA
			$adapter = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			$adapter->getAdapter()->beginTransaction();
			$dbTransactionStart = true;
			$responseVO = $sendEmailModel->getResource()->saveDB($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			$adapter->getAdapter()->commit();
			
		}catch (Exception $e){
			Mage::log('=> Dakiya_Model_Booking_Request_UserBookingRequest->bluedartShipmentReminder method...' . $responseVO->getErrorMessage(), null, 'system.log', true);
			//$responseVO->setErrorMessage($e->getMessage());
		}
		//return $responseVO;
	}
	
	
	public function sendCancellationWarningEmail(){
		
		try{
			
			$responseVO = new Dakiya_VO_BaseVO();
			$dbTransactionStart = false;
			
			//$todayDate   = date('Y-m-d', Mage::getModel('core/date')->timestamp(time()));
			$todayDate = "2017-06-01";
			$journeyFromDate = $todayDate;
			$journeyToDate = date('Y-m-d', strtotime("+4 days", strtotime($todayDate)));
			$bookingDate = $todayDate;
			
			//$bookingFromDate = date('Y-m-d', strtotime("-1 days", strtotime($todayDate)));
			//$bookingToDate   = $todayDate;
			
			$collection = Mage::getModel("dakiya/Booking_Request_UserBookingRequest")->getCollection();
			$adapter = new Dakiya_VO_Booking_Request_UserBookingRequestVO();
			
			$read =  $adapter->getAdapter();
			$select  = $read->select()
			->from(array("lubr"=>$collection->getTable("dakiya/localuserbookingrequest")), array("RequestID"=>"lubr.RequestID", "PaymentGatewayID"=>"lubr.PaymentGatewayID"))
			->joinInner(array("lt"=>$collection->getTable("dakiya/localticket")), "lubr.RequestID=lt.RequestID", array("PNRNumber"=>"lt.PNRNumber", "NetTicketAmount"=>"lt.NetTicketAmount", "JourneyDate"=>new Zend_Db_Expr(" date(lt.JourneyDate) ")))
			->joinInner(array("lu"=>$collection->getTable("dakiya/localuser")), "lubr.UserID=lu.UserID", array("UserID"=>"lu.UserID", "ReceiverEmail"=>"lu.EmailID", "MobileNO"=>"lu.MobileNO", "IRCTCUserName"=>"lu.IRCTCUserName", "FirstName"=>"lu.FirstName", "LastName"=>"lu.LastName"))
			->joinInner(array("lmdshipment"=>$collection->getTable("dakiya/locallmdshipment")), "lubr.RequestID=lmdshipment.RequestID", array("WaybillNo"=>"lmdshipment.WaybillNo"))
			->joinInner(array("lss"=>$collection->getTable("dakiya/locallmdstatus")), "lmdshipment.StatusID=lss.LMDStatusID", array("ShipmentStatus"=>"lss.StatusName"))
			->where('lubr.CurrStatusID = ?', Dakiya_VO_Master_Booking_UserBookingRequestStatusVO::$DISPATCHED)
			->where('lubr.PaymentMethodID=?', Dakiya_VO_Master_Payment_PaymentMethodVO::$COD)
			//->where( new Zend_Db_Expr("date(lt.BookedOn) = '".$bookingDate."'"))
			->where( new Zend_Db_Expr("date(lt.JourneyDate) BETWEEN '".$journeyFromDate. "' AND '" . $journeyToDate. "'"));
			$dataObjs = $read->fetchAll($select);
				
			$sendEmailModel= Mage::getModel('dakiya/Email_SendEmail_SendEmail');
			$cancelledTicketModel= Mage::getModel('dakiya/Cancellation_Ticket_CancelledTicket');
			foreach ($dataObjs as $dataObj){
				
				$requestID = $dataObj['RequestID'];
				$userID = $dataObj['UserID'];
				$MobileNumber = $dataObj['MobileNO'];
				$irctcUserName= $dataObj['IRCTCUserName'];
				$userFirstName= $dataObj['FirstName'];
				$userLastName = $dataObj['LastName'];
				//$receiverEmail = $dataObj['ReceiverEmail'];
				$receiverEmail = "vipin.shakya@anduriltechnologies.com";
				$paymentGatewayID = $dataObj['PaymentGatewayID'];
				$cancellationWarningHours = "24 hours";
				$pnrNumber = $dataObj['PNRNumber'];
				$netTicketAmount = $dataObj['NetTicketAmount'];
				$journeyDate = $dataObj['JourneyDate'];
					
				// GET EXPECTED CANCELLATION CHARGES
				$responseVO = $cancelledTicketModel->getExpectedCancellationCharges($requestID);
				if($responseVO->getErrorMessage() != null){
					Mage::log('Model_Job_CronJob_CronJob::sendCancellationWarningEmail =>'. $responseVO->getErrorMessage(), null, 'system.log', true);
					continue;
				}
				$cancellationCharges = $responseVO->getResponseData();
				$cancellationWarningAmount = $cancellationCharges['CancellationCharge'];
				if($cancellationWarningAmount == null || $cancellationWarningAmount == "" || $cancellationWarningAmount < 0){
					Mage::log('Model_Job_CronJob_CronJob::sendCancellationWarningEmail => Invalid Cancellation Amount'. $cancellationWarningAmount, null, 'system.log', true);
					continue;
				} 
				
				$sendEmailVO = new Dakiya_VO_Email_SendEmail_SendEmailVO();

				// SET RECEIVER EMAIL
				$sendEmailVO->setReceiverEmail($receiverEmail);
				
				// SET EMAIL CONFIG ID
				if($paymentGatewayID == Dakiya_VO_Master_Payment_PaymentGatewayVO::$IRCTC_COD || $paymentGatewayID == Dakiya_VO_Master_Payment_PaymentGatewayVO::$IRCTC_COD_MOB ){
					$sendEmailVO->setEmailConfigID(Dakiya_VO_Master_Email_EmailConfigVO::$PAYONDELIVERY_TEAM);
				}
				
				if($paymentGatewayID == null || $paymentGatewayID == ''){
					$sendEmailVO->setEmailConfigID(Dakiya_VO_Master_Email_EmailConfigVO::$SUPPORT_TEAM);
				}
				
				// SET EMAIL CONFIG TEMPLATE ID
				$sendEmailVO->setEmailTemplateID(Dakiya_VO_Master_Email_EmailTemplateVO::$CANCELLATION_WARNING_BULK_EMAIL);
				
				// SET EMAIL SUBJECT
				$sendEmailVO->setEmailSubject("IRCTC Ticket Payment Collection - PNR: ". $pnrNumber . ": Unsuccessful");
				
				// SET EMAIL PARAM
				$responseVO = $sendEmailModel->setEmailParam($sendEmailVO);
				if($responseVO->getErrorMessage() != null){
					Mage::log('Model_Job_CronJob_CronJob::sendCancellationWarningEmail =>'. $responseVO->getErrorMessage(), null, 'system.log', true);
					continue;
				}
				
				// SET EMAIL CONTENT
				$emailContent = '';
				$sendEmailVO  = $responseVO->getResponseData();
				$emailContent = $sendEmailVO->getEmailBody();
				
				$emailContentVariables = array();
				$emailContentVariables['CancellationWarningHours']  = $cancellationWarningHours;
				$emailContentVariables['CancellationWarningAmount'] = $cancellationWarningAmount;
				$emailContentVariables['PNRNumber'] = $pnrNumber;
				$emailContentVariables['NetTicketAmount'] = $netTicketAmount;
				$emailContentVariables['JourneyDate']  = date("M d, Y", strtotime($journeyDate));
				
				foreach ($emailContentVariables as $key=>$value){
					$emailContent = str_replace("{".$key."}",$value,$emailContent);
				}
				
				$sendEmailVO->setEmailBody($emailContent);
				
				// SEND EMAIL
				$responseVO = $sendEmailModel->sendEmail($sendEmailVO);
				if($responseVO->getErrorMessage() != null){
					Mage::log('Model_Job_CronJob_CronJob::sendCancellationWarningEmail =>'. $responseVO->getErrorMessage(), null, 'system.log', true);
					continue;
				}
				
				// INSERT INTO SENT EMAIL TABLE
				$sendEmailVO->setSentEmailID(0);
				$sendEmailVO->setStatusID(Dakiya_VO_Master_Email_SendEmailStatusVO::$SENT);
				$sendEmailVO->setRemarks($responseVO->getSuccessMessage());
				
				$adapter = new Dakiya_VO_Email_SendEmail_SendEmailVO();
				$adapter->getAdapter()->beginTransaction();
				$responseVO = $sendEmailModel->getResource()->saveDB($sendEmailVO);
				if($responseVO->getErrorMessage() != null){
					Mage::log('Model_Job_CronJob_CronJob::sendCancellationWarningEmail =>'. $responseVO->getErrorMessage(), null, 'system.log', true);
					$adapter->getAdapter()->rollBack();
					continue;
				}
				
				// INSERT INTO UserCallHistory TABLE
				$userCallHistoryVO = new Dakiya_VO_User_UserCallHistory_UserCallHistoryVO();
				$userCallHistoryVO->setHistoryID(0);
				$userCallHistoryVO->setRequestID($requestID);
				$userCallHistoryVO->setUserID($userID);
				$userCallHistoryVO->setIsIRCTCUser(1);
				$userCallHistoryVO->setIRCTCUserName($irctcUserName);
				$userCallHistoryVO->setCustomerName($userFirstName . ' ' . $userLastName);
				$userCallHistoryVO->setMobileNumber($MobileNumber);
				$userCallHistoryVO->setEmail($receiverEmail);
				$userCallHistoryVO->setPNRNumber($pnrNumber);
				$userCallHistoryVO->setCallingReasonID(Dakiya_VO_Master_User_CallingReason_CallingReasonVO::$CANCELLATION_WARNING_EMAIL);
				$userCallHistoryVO->setCallingTypeID(Dakiya_VO_Master_User_CallingType_CallingTypeVO::$COMMUNICATION_EMAIL);
				$userCallHistoryVO->setUserTypeID(Dakiya_VO_Master_User_UserType_UserTypeVO::$REGISTER_USER_WITH_TRANSACTION);
				$userCallHistoryVO->setRemarks($cancellationWarningHours . ' , cc charge '. $cancellationWarningAmount);
				$userCallHistoryModel = Mage::getModel("dakiya/User_UserCallHistory_UserCallHistory");
				$responseVO = $userCallHistoryModel->getResource()->saveDB($userCallHistoryVO);
				
				if($responseVO->getErrorMessage() != null){
					Mage::log('Model_Job_CronJob_CronJob::sendCancellationWarningEmail =>'. $responseVO->getErrorMessage(), null, 'system.log', true);
					$adapter->getAdapter()->rollBack();
					continue;
				}
				
				$adapter->getAdapter()->commit();
				
				break;
			} // End Foreach 
			
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		
	}
	
	
	/*
	 * 
	 * SEND EMAIL WHEN BOOKING HAPPAN AGAINST VIRTUAL BLOCKED USERNAME OR PASSENGERS
	 * 
	 */
	public function sendVirtualBlockedBookingReminder(){
		
		try{
			Mage::log('=> Dakiya_Model_Job_CronJob_CronJob->sendVirtualBlockedBookingReminder method...START', null, 'system.log', true);
			
			$responseVO= new Dakiya_VO_BaseVO();
			$todayDate = date('Y-m-d', Mage::getModel('core/date')->timestamp(time()));
			
			$content = '';
			$content .= '<p>Hi Team</p>';
			$content .= '<p>Below are the list of virtual blocked booking . Request you to kindly follow up in urgent basis itself.</p>';
			$content .= '<div>&nbsp;</div>';
			$content .= '<table border="1">';
			$content .= '<tr>';
			$content .= '<th>TxnID</th>';
			$content .= '<th>PNR NO</th>';
			$content .= '<th>PassengerName</th>';
			$content .= '<th>Booking Date</th>';
			$content .= '<th>Journey Date</th>';
			$content .= '<th>Status</th>';
			$content .= '<th>User Name</th>';
			$content .= '<th>MobileNO</th>';
			$content .= '<th>Alternate MobileNO</th>';
			$content .= '<th>Ticket Amt</th>';
			$content .= '</tr>';
			
			$userBookingRequestModel = Mage::getModel("dakiya/Booking_Request_UserBookingRequest");
			$virtualBlockedModel = Mage::getModel("dakiya/User_UserCallHistory_UserCallHistory");
			$virtualBlockedDataObjs=$virtualBlockedModel->getResource()->getAllForVirtualBlocked();
			if(sizeof($virtualBlockedDataObjs) == 0){
				Mage::throwException("Record Not Found In Virtual Blocked!");
			}
			Mage::log('=> Dakiya_Model_Job_CronJob_CronJob->sendVirtualBlockedBookingReminder Virtual Blocked Record Found !', null, 'system.log', true);
			$isRecordFound = false;
			foreach ($virtualBlockedDataObjs as $virtualBlockedDataObj){
				
				$virtualBlockedDTO = new Dakiya_VO_User_UserCallHistory_UserCallHistoryVO();
				/* @var $virtualBlockedVO Dakiya_VO_User_UserCallHistory_UserCallHistoryVO */
				$virtualBlockedVO = Dakiya_Helper_Utility::setVO($virtualBlockedDTO, $virtualBlockedDataObj);
				
				$userBookingRequestDataObjs = $userBookingRequestModel->getResource()->getByVOForVirtualBlocked($virtualBlockedVO);
				if(sizeof($userBookingRequestDataObjs) == 0){
					continue;
				}
				foreach ($userBookingRequestDataObjs as $userBookingRequestDataObj){
					$isRecordFound = true;
					$content .= '<tr>';
					$content .= '<td>'.$userBookingRequestDataObj['RequestID'].'</td>';
					$content .= '<td>'.$userBookingRequestDataObj['PNRNumber'].'</td>';
					$content .= '<td>'.$userBookingRequestDataObj['PassengerName'].'</td>';
					$content .= '<td>'.date("M d, Y", strtotime($userBookingRequestDataObj['BookingDate'])).'</td>';
					$content .= '<td>'.date("M d, Y", strtotime($userBookingRequestDataObj['JourneyDate'])).'</td>';
					$content .= '<td>'.$userBookingRequestDataObj['StatusName'].'</td>';
					$content .= '<td>'.$userBookingRequestDataObj['IRCTCUserName'].'</td>';
					$content .= '<td>'.$userBookingRequestDataObj['RegMobileNo'].'</td>';
					$content .= '<td>'.$userBookingRequestDataObj['AlternateMobileNo'].'</td>';
					$content .= '<td>'.$userBookingRequestDataObj['NetTicketAmount'].'</td>';
					$content .= '</tr>';
				}
			}
			
			if($isRecordFound == false){
				Mage::throwException("Record Not Found In User Booking !");
			}
			
			$content .= '</table>';
			
			$content .= '<div>&nbsp;</div>';
			$content .= '<div>&nbsp;</div>';
			$content .= '<div>&nbsp;</div>';
			$content .= '<p>Regards</p>';
			$content .= '<p>Anurag</p>';
			
			
			$sendEmailVO  = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			
			// SET EMAIL CONFIG ID
			$sendEmailVO->setEmailConfigID(Dakiya_VO_Master_Email_EmailConfigVO::$ANURAG_TEAM);
			
			// SET EMAIL CONFIG TEMPLATE ID
			$sendEmailVO->setEmailTemplateID(Dakiya_VO_Master_Email_EmailTemplateVO::$VIRTUAL_BLOCKED_BOOKING_REMINDER);
			
			// SET EMAIL SUBJECT
			$sendEmailVO->setEmailSubject("Virtual Blocked Booking - Anduril - ". date("M d, Y", strtotime($todayDate)) );
			
			// SET RECEIVER EMAIL
			$sendEmailVO->setReceiverEmail("vipin.shakya@anduriltechnologies.com");
			//$sendEmailVO->setReceiverEmail("anurag@anduriltechnologies.com");
			
			
			// SET EMAIL PARAM
			$sendEmailModel = Mage::getModel('dakiya/Email_SendEmail_SendEmail');
			$responseVO = $sendEmailModel->setEmailParam($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			$sendEmailVO = $responseVO->getResponseData();
			
			// SET EMAIL CONTENT
			$sendEmailVO->setEmailBody($content);
			
			// SET CC
			//$sendEmailVO->setReceiverCCAddress(array('shriram.sharma@anduriltechnologies.com', 'anurag@anduriltechnologies.com'));
			//$sendEmailVO->setReceiverCCAddress(array('shriram.sharma@anduriltechnologies.com'));
			
			// SEND EMAIL PARAM
			$responseVO = $sendEmailModel->sendEmail($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			
			// INSERT INTO SENT EMAIL TABLE
			$sendEmailVO->setSentEmailID(0);
			$sendEmailVO->setStatusID(Dakiya_VO_Master_Email_SendEmailStatusVO::$SENT);
			$sendEmailVO->setRemarks($responseVO->getSuccessMessage());
			
			//SAVE EMAIL DATA
			$adapter = new Dakiya_VO_Email_SendEmail_SendEmailVO();
			$adapter->getAdapter()->beginTransaction();
			$dbTransactionStart = true;
			$responseVO = $sendEmailModel->getResource()->saveDB($sendEmailVO);
			if($responseVO->getErrorMessage() != null){
				Mage::throwException($responseVO->getErrorMessage());
			}
			$adapter->getAdapter()->commit();
			
		}catch (Exception $e){
			Mage::log('=> Dakiya_Model_Job_CronJob_CronJob->sendVirtualBlockedBookingReminder method...' . $e->getMessage(), null, 'system.log', true);
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	}
}