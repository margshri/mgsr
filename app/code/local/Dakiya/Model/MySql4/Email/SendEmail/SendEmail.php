<?php
class Dakiya_Model_Mysql4_Email_SendEmail_SendEmail extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('dakiya/dakiyasentemail', 'SentEmailID');
	}
	
	
	public function getUserSentEmailHistoryByRequestID($requestID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from(array("dse"=>$this->getMainTable()), array("Remarks"=>"dse.Remarks", "CreatedAt"=>"dse.CreatedAt", "ReceiverEmail"=>"dse.ReceiverEmail"))
		->joinLeft(array("det"=>$this->getTable('newdakiya/dakiyaemailtemplate')), 'dse.EmailTemplateID = det.TemplateID',  array("TemplateName"=>"det.TemplateName", "EmailSubject"=>"det.Subject", "EmailContent"=>"det.Content",))
		->joinLeft(array("dec"=>$this->getTable('newdakiya/dakiyaemailconfig')), 'dse.EmailConfigID = dec.ConfigID',  array("ConfigName"=>"dec.ConfigName", "SenderName"=>"dec.SenderName"))
		->joinLeft(array("au"=>$this->getTable('newdakiya/adminuser')), 'dse.CreatedBy = au.user_id',  array("AdminUserName"=>"au.username"))
		->where("dse.RequestID=?", $requestID)
		->order("dse.SentEmailID desc");
		return $read->fetchAll($select);
	}
	
	public function getByRequestID($requestID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("RequestID=?", $requestID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function saveDB(Dakiya_VO_Email_SendEmail_SendEmailVO $sendEmailVO){
		$responseVO = new Dakiya_VO_BaseVO();
		$adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate  = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		$sendEmailDTO = new Dakiya_VO_Email_SendEmail_SendEmailVO();
		if($sendEmailVO->getSentEmailID() > 0){
			$rowSet = $sendEmailDTO->find( $sendEmailVO->getSentEmailID() );
			$row    = $rowSet['_data'];
			$sendEmailVO->setUpdatedAt($serverDate);
			$sendEmailVO->setUpdatedBy($adminUserID);
		}else{
			$row = $sendEmailDTO->fetchNew();
			$sendEmailVO->setCreatedAt($serverDate);
			$sendEmailVO->setCreatedBy($adminUserID);
			$sendEmailVO->setUpdatedAt($serverDate);
			$sendEmailVO->setUpdatedBy($adminUserID);
				
		}
	
		foreach($sendEmailVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		
		$isSaved = $row->save();
		
		if($isSaved){
			$responseVO->setSuccessMessage('Successfully Saved');
		}else{
			$responseVO->setErrorMessage('Could Not Save !');
		}
		return $responseVO;
		
		
	}
}