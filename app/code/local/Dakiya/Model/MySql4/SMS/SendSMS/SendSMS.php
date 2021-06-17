<?php
class Dakiya_Model_Mysql4_SMS_SendSMS_SendSMS extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct(){
		$this->_init('dakiya/dakiyasentsms', 'SentSMSID');
	}
	
	public function getByID(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
	 	return $rowSet;
	}
	 
	public function saveDB(Dakiya_VO_SMS_SendSMS_SendSMSVO $sendSMSVO){
		try{
			$responseVO = new Dakiya_VO_BaseVO();
			$adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
			$serverDate  = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		
			$sendSMSDTO = new Dakiya_VO_SMS_SendSMS_SendSMSVO();
			if($sendSMSVO->getSentSMSID() > 0){
				$rowSet = $sendSMSDTO->find( $sendSMSVO->getSentSMSID() );
				$row    = $rowSet['_data'];
				$sendSMSVO->setUpdatedAt($serverDate);
				$sendSMSVO->setUpdatedBy($adminUserID);
			}else{
				$row = $sendSMSDTO->fetchNew();
				$sendSMSVO->setCreatedAt($serverDate);
				$sendSMSVO->setCreatedBy($adminUserID);
				$sendSMSVO->setUpdatedAt($serverDate);
				$sendSMSVO->setUpdatedBy($adminUserID);
			}
		
			foreach($sendSMSVO->getDataArray() as $key=>$value){
				$row[$key] = $value;
			}
		
			$isSaved = $row->save();
		
			if($isSaved){
				$responseVO->setSuccessMessage('Successfully Saved');
			}else{
				$responseVO->setErrorMessage('Could Not Save !');
			}
			
		}catch (Exception $e) {
			$responseVO->setErrorMessage($e->getMessage());
		}
		return $responseVO;
	
	}
	
	
	public function frontSaveDB(Dakiya_VO_SMS_SendSMS_SendSMSVO $sendSMSVO){
	    try{
	        $responseVO = new Dakiya_VO_BaseVO();
	        $adminUserID = 1;
	        $serverDate  = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	        
	        $sendSMSDTO = new Dakiya_VO_SMS_SendSMS_SendSMSVO();
	        if($sendSMSVO->getSentSMSID() > 0){
	            $rowSet = $sendSMSDTO->find( $sendSMSVO->getSentSMSID() );
	            $row    = $rowSet['_data'];
	            $sendSMSVO->setUpdatedAt($serverDate);
	            $sendSMSVO->setUpdatedBy($adminUserID);
	        }else{
	            $row = $sendSMSDTO->fetchNew();
	            $sendSMSVO->setCreatedAt($serverDate);
	            $sendSMSVO->setCreatedBy($adminUserID);
	            $sendSMSVO->setUpdatedAt($serverDate);
	            $sendSMSVO->setUpdatedBy($adminUserID);
	        }
	        
	        foreach($sendSMSVO->getDataArray() as $key=>$value){
	            $row[$key] = $value;
	        }
	        
	        $isSaved = $row->save();
	        
	        if($isSaved){
	            $responseVO->setSuccessMessage('Successfully Saved');
	        }else{
	            $responseVO->setErrorMessage('Could Not Save !');
	        }
	        
	    }catch (Exception $e) {
	        $responseVO->setErrorMessage($e->getMessage());
	    }
	    return $responseVO;
	    
	}
	
}