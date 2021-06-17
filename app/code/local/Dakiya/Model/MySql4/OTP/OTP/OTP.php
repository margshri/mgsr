<?php
class Dakiya_Model_Mysql4_OTP_OTP_OTP extends Mage_Core_Model_Mysql4_Abstract{
    
    
	protected function _construct(){
		$this->_init('dakiya/dakiyaotp', 'ID');
	}
	
	
	public function getByID(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
	 	return $rowSet;
	}
	
	
	public function getByMobileNumber($mobileNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("MobileNumber =?", $mobileNumber);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getLastByMobileNumber($mobileNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("MobileNumber =?", $mobileNumber)
	    ->order("ID DESC")
	    ->limit(1);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	
	public function saveFrontDB(Dakiya_VO_OTP_OTP_OTPVO $otpVO){
		try{
			$responseVO = new Dakiya_VO_BaseVO();
			// $userID = 1;
			$serverDate  = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		
			$otpDTO = new Dakiya_VO_OTP_OTP_OTPVO();
			if($otpVO->getID() > 0){
			    $rowSet = $otpDTO->find($otpVO->getID());
				$row = $rowSet['_data'];
				//$sendSMSVO->setUpdatedAt($serverDate);
				//$sendSMSVO->setUpdatedBy($adminUserID);
			}else{
				$row = $otpDTO->fetchNew();
				$otpVO->setCreatedAt($serverDate);
				//$sendSMSVO->setCreatedBy($adminUserID);
				//$sendSMSVO->setUpdatedAt($serverDate);
				//$sendSMSVO->setUpdatedBy($adminUserID);
			}
		
			foreach($otpVO->getDataArray() as $key=>$value){
				$row[$key] = $value;
			}
		
			$isSaved = $row->save();
		
			if($isSaved){
				$responseVO->setSuccessMessage('Successfully Saved');
				$responseVO->setResponseData(array("OTPID"=>$row['ID']));
			}else{
				$responseVO->setErrorMessage('Could Not Save !');
			}
			
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	
	}
	
}