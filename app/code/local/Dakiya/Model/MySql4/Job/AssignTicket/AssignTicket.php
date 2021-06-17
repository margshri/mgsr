<?php
class Dakiya_Model_Mysql4_Job_AssignTicket_AssignTicket extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('newdakiya/dakiyaassignticket', 'AssignTicketID');
	}

	public function getByID($assignTicketID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from(array("main_table"=>$this->getMainTable()))
		->where('AssignTicketID=?', $assignTicketID);
		return $read->fetchRow($select);
	}
	
	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getByRequestID($requestID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from(array("main_table"=>$this->getMainTable()))
		->where('RequestID=?', $requestID);
		return $read->fetchRow($select);
	}
	
	
	public function getByAssignTo($assignTo){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from(array("main_table"=>$this->getMainTable()))
		->where('AssignTO=?', $assignTo);
		return $read->fetchAll($select);
	}
	
	
	public function getPendingTicketByAssignTo($assignTo){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from(array("main_table"=>$this->getMainTable()))
		->where('AssignTO=?', $assignTo)
		->where('StatusID !=?', Dakiya_VO_Master_Job_AssignTicket_AssignTicketStatusVO::$CLOSE);
		return $read->fetchAll($select);
	}
	
	
	public function getLastByAssignToWise(){
		$read = $this->_getReadAdapter();
		$tmpQuery  = $read->select()
		->from($this->getMainTable())
		->where(new Zend_Db_Expr(" FilterString is not null "))
		->order("AssignTicketID DESC");
		
		$select  = $read->select()
		->from(array("dat"=>$tmpQuery))
		->group("AssignTo");
		
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function saveDB(Dakiya_VO_Job_AssignTicket_AssignTicketVO $assignTicketVO){
		try {
			
			$responseVO  = new Dakiya_VO_BaseVO();
			$adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
			$serverDate  = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			
			$assignTicketDataObj = $this->getByRequestID($assignTicketVO->getRequestID());
			
			$assignTicketDTO = new Dakiya_VO_Job_AssignTicket_AssignTicketVO();
			if($assignTicketVO->getAssignTicketID() > 0){
				
				if($assignTicketDataObj !== false){
					$newAssignTicketDTO = new Dakiya_VO_Job_AssignTicket_AssignTicketVO();
					/* @var $newAssignTicketVO Dakiya_VO_Job_AssignTicket_AssignTicketVO */
					$newAssignTicketVO  = Dakiya_Helper_Utility::setVO($newAssignTicketDTO, $assignTicketDataObj);
					
					if($assignTicketVO->getAssignTicketID() != $newAssignTicketVO->getAssignTicketID()){
						Mage::throwException('Duplicate entry for request id '. $assignTicketVO->getRequestID());
					}
				}
				
				
				$rowSet = $assignTicketDTO->find($assignTicketVO->getAssignTicketID());
				$row    = $rowSet['_data'];
				
				if($assignTicketVO->getAssignTo() != null){
					$assignTicketVO->setAssignAt($serverDate);
					$assignTicketVO->setAssignBy($adminUserID);
					$assignTicketVO->setRemarks($row['Remarks'] . " " . $assignTicketVO->getRemarks());
					$assignTicketVO->setAssignCount($row['AssignCount'] + 1);
					$assignTicketVO->setIsReAssign(1);
				}
				$assignTicketVO->setUpdatedAt($serverDate);
				$assignTicketVO->setUpdatedBy($adminUserID);
			}else{
				
				if($assignTicketDataObj !== false){
					Mage::throwException('Duplicate entry for request id '. $assignTicketVO->getRequestID());
				}
				
				$row = $assignTicketDTO->fetchNew();
				$assignTicketVO->setAssignCount(1);
				$assignTicketVO->setAssignAt($serverDate);
				$assignTicketVO->setAssignBy($adminUserID);
				$assignTicketVO->setCreatedAt($serverDate);
				$assignTicketVO->setCreatedBy($adminUserID);
				$assignTicketVO->setUpdatedAt($serverDate);
				$assignTicketVO->setUpdatedBy($adminUserID);
			}
			
			foreach($assignTicketVO->getDataArray() as $key=>$value){
				$row[$key] = $value;
			}
			$isSaved = $row->save();
			
			if(!$isSaved){
				Mage::throwException('Could Not Save Or Update !');
			}
			
			if($assignTicketVO->getAssignTicketID() > 0){
				$responseVO->setResponseData($assignTicketVO->getAssignTicketID());
			}else{
				$responseVO->setResponseData($assignTicketDTO->getAdapter()->lastInsertId());
			}
			$responseVO->setSuccessMessage('Successfully Saved ');
			
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	}
}