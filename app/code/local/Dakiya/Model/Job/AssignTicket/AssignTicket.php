<?php
class Dakiya_Model_Job_AssignTicket_AssignTicket extends Mage_Core_Model_Abstract  {
	
	protected function _construct(){
		parent::_construct();
		$this->_init('dakiya/Job_AssignTicket_AssignTicket');
	}
	
	public function autoAssignTicket(){
		
		Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Start Testing' , null, 'system.log', true);
		
		// LOCAL DECLATION
		$collection = Mage::getModel("dakiya/Booking_Request_UserBookingRequest")->getCollection();
		$adapter = new Dakiya_VO_Booking_Request_UserBookingRequestVO();
		$assignTicketModel= Mage::getModel("dakiya/Job_AssignTicket_AssignTicket");
		$newAdapter = new Dakiya_VO_Job_AssignTicket_AssignTicketVO();
		$dbTransactionStart= false;
		
		// GET SEARCH CRITERIA
		$assignTicketDataObjs = $assignTicketModel->getResource()->getLastByAssignToWise();
		
		if(sizeof($assignTicketDataObjs) == 0){
			Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Assigned Record Not Found' , null, 'system.log', true);
		}
		
		foreach ($assignTicketDataObjs as $assignTicketDataObj){
			$assignTicketDTO = new Dakiya_VO_Job_AssignTicket_AssignTicketVO();
			/* @var $assignTicketVO Dakiya_VO_Job_AssignTicket_AssignTicketVO */  
			$assignTicketVO  = Dakiya_Helper_Utility::setVO($assignTicketDTO, $assignTicketDataObj);
			
			// GET ADMIN USER BY ADMIN ID
			$assignToDataObj = Mage::getModel('admin/user')->load($assignTicketVO->getAssignTo())->getData();
			$assignToUserName= $assignToDataObj['username'];
			
			$currAdminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
			$assignByDataObj = Mage::getModel('admin/user')->load($currAdminUserID)->getData();
			$assignByUserName= $assignByDataObj['username'];
			
			$filterString = $assignTicketVO->getFilterString();
			if($filterString == null || $filterString == ''){
				Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Null Filter String For User ' . $assignToUserName , null, 'system.log', true);
				continue;
			}
			
			$filterDataObjs = Mage::helper('adminhtml')->prepareFilterString($filterString);
			Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Filter String '. $filterString .' For User ' . $assignToUserName , null, 'system.log', true);
			
			if(sizeof($filterDataObjs) > 0){
				
				$where = array();
				 
				if(array_key_exists('RequestID', $filterDataObjs)){
					$where['lubr.RequestID'] = " = " . $filterDataObjs['RequestID'];
				}
				
				if(array_key_exists('PNRNumber', $filterDataObjs)){
					$where['lt.PNRNumber'] = " = " . $filterDataObjs['PNRNumber'];
				}
				
				if(array_key_exists('IRCTCUserName', $filterDataObjs)){
					$where['lu.IRCTCUserName'] = " = " . $filterDataObjs['IRCTCUserName'];
				}
				
				if(array_key_exists('MobileNO', $filterDataObjs)){
					$where['lu.MobileNO'] = " = " . $filterDataObjs['MobileNO'];
				}
				
				if(array_key_exists('EmailID', $filterDataObjs)){
					$where['lu.EmailID'] = " = " . $filterDataObjs['EmailID'];
				}
				
				if(array_key_exists('WaybillNo', $filterDataObjs)){
					$where['lmdshipment.WaybillNo'] = " = " . $filterDataObjs['WaybillNo'];
				}
				
				if(array_key_exists('TrainNo', $filterDataObjs)){
					$where['lubr.TrainNo'] = " = " . $filterDataObjs['TrainNo'];
				}
				 
				if(array_key_exists('SourceStationCode', $filterDataObjs)){
					$where['lubr.SourceStationCode'] = " = " . $filterDataObjs['SourceStationCode'];
				}
				
				if(array_key_exists('DestinationStationCode', $filterDataObjs)){
					$where['lubr.DestinationStationCode'] = " = " . $filterDataObjs['DestinationStationCode'];
				}
				
				if(array_key_exists('Quota', $filterDataObjs)){
					$where['lt.Quota'] = " = " . $filterDataObjs['Quota'];
				}
				
				if(array_key_exists('NetTicketAmount', $filterDataObjs)){
					$where['lt.NetTicketAmount'] = " = " . $filterDataObjs['NetTicketAmount'];
				}
				
				if(array_key_exists('PaymentMethodID', $filterDataObjs)){
					$where['lubr.PaymentMethodID'] = " IN (" . $filterDataObjs['PaymentMethodID'] . ") ";
				}
				
				if(array_key_exists('PaymentGatewayID', $filterDataObjs)){
					$where['lubr.PaymentGatewayID'] = " IN (" . $filterDataObjs['PaymentGatewayID'] . ") ";
				}
				
				if(array_key_exists('CurrStatusID', $filterDataObjs)){
					$where['lubr.CurrStatusID'] = " IN (" . $filterDataObjs['CurrStatusID'] . ") ";
				}
				
				if(array_key_exists('CreatedAt', $filterDataObjs)){
					if( array_key_exists('from', $filterDataObjs['CreatedAt']) && array_key_exists('to', $filterDataObjs['CreatedAt']) ){
						$createdAtFromDate = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['from']));
						$createdAtToDate   = date('Y-m-d', strtotime($filterDataObjs['CreatedAt']['to']));
						$where['date(lt.BookedOn)']= " between '" . $createdAtFromDate . "' and '" . $createdAtToDate . "'";
						
					}elseif(array_key_exists('from', $filterDataObjs['CreatedAt'])){
						$where['date(lt.BookedOn)']= " >= '" . $createdAtFromDate . "'";
					}elseif(array_key_exists('to', $filterDataObjs['CreatedAt']) ){
						$where['date(lt.BookedOn)']= " <= '" . $createdAtToDate . "'";
					}
					 
				}
				
				if(array_key_exists('JourneyDate', $filterDataObjs)){
					if( array_key_exists('from', $filterDataObjs['JourneyDate']) && array_key_exists('to', $filterDataObjs['JourneyDate']) ){
						$journeyDateFromDate = date('Y-m-d', strtotime($filterDataObjs['JourneyDate']['from']));
						$journeyDateToDate = date('Y-m-d', strtotime($filterDataObjs['JourneyDate']['to']));
						$where['date(lt.JourneyDate)']= " between '" . $journeyDateFromDate . "' and '" . $journeyDateToDate . "'";
						
					}elseif(array_key_exists('from', $filterDataObjs['JourneyDate'])){
						$where['date(lt.JourneyDate)']= " >= '" . $journeyDateFromDate . "'";
					}elseif(array_key_exists('to', $filterDataObjs['JourneyDate']) ){
						$where['date(lt.JourneyDate)']= " <= '" . $journeyDateToDate. "'";
					}
					
				}
		 
				
			}else{
				Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Object Not Created To Filter String '. $filterString .' For User ' . $assignToUserName , null, 'system.log', true);
				continue;
			}
			
			$read = $adapter->getAdapter();
			$sql  = "Select lubr.RequestID as RequestID from `local_userbookingrequest` lubr inner join local_ticket lt on lubr.RequestID = lt.RequestID inner join local_user lu on lubr.UserID = lu.UserID left join local_lmdshipment lmdshipment on lubr.RequestID = lmdshipment.RequestID "; 
			$cond = " where ";
			
			$count = 0;
			$total = sizeof($where);
			
			foreach ($where as $k=>$val){
				
				if($total == 1 || $count == 0){
					$cond = $cond . " " . $k ." ". $val;
				}else{
					$cond = $cond . " AND " . $k ." ". $val;
				}
					
				$count++;
			}
			
			$sql .= $cond;
			
			Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| SQL Statment '. $sql .' For User ' . $assignToUserName , null, 'system.log', true);
			
			$dataObjs = $read->fetchAll($sql);
			
			Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Fetch Passed Total Record '. sizeof($dataObjs) .' Found For User ' . $assignToUserName , null, 'system.log', true);
			
			foreach ($dataObjs as $dataObj){
				$requestID = $dataObj['RequestID'];
				
				// GET BY REQUEST ID FROM ASSIGN TICKET TABLE
				$newAssignTicketDataObj = $assignTicketModel->getResource()->getByRequestID($requestID);
				if($newAssignTicketDataObj !== false){
					//Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Already Assign RequestID '. $requestID .' For User ' . $assignToUserName , null, 'system.log', true);
					continue;
				}
				
				// INSERT INTO ASSIGN TICKET TABLE
				$newAssignTicketVO = new Dakiya_VO_Job_AssignTicket_AssignTicketVO();
				$newAssignTicketVO->setAssignTicketID(0);
				$newAssignTicketVO->setStatusID(Dakiya_VO_Master_Job_AssignTicket_AssignTicketStatusVO::$OPEN);
				$newAssignTicketVO->setAssignTo($assignTicketVO->getAssignTo());
				$newAssignTicketVO->setRequestID($requestID);
				$newAssignTicketVO->setFilterString($assignTicketVO->getFilterString());
				$newAssignTicketVO->setRemarks("Assign By " . $assignByUserName . " To " . $assignToUserName);
				
				$newAdapter->getAdapter()->beginTransaction();
				$responseVO = $assignTicketModel->getResource()->saveDB($newAssignTicketVO);
				if($responseVO->getErrorMessage() != null){
					$newAdapter->getAdapter()->rollBack();
					Mage::log('Model =>Job_AssignTicket_AssignTicket::autoAssignTicket' . '| Insert Failed RequestID '. $requestID .' For User ' . $assignToUserName , null, 'system.log', true);
					continue;
				}
				$newAdapter->getAdapter()->commit();
			}	
		}
		
	}
	 
}