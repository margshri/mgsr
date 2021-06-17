<?php
class Dakiya_Model_Mysql4_Master_SMS_SMSTemplate extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct(){
		$this->_init('dakiya/dakiyasmstemplate', 'TemplateID');
	}
	
	
	public function getByID($templateID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("TemplateID=?", $templateID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getByCode($templateCode){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("TemplateCode=?", $templateCode);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$dataObjs = $this->getList();
		$options = array();
	
		foreach($dataObjs as $dataObj){
			$DTO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
			/* @var $VO Dakiya_VO_Master_SMS_SMSTemplateVO */
			$VO  = Dakiya_Helper_Utility::setVO($DTO, $dataObj);
			$options[$VO->getTemplateID()]= $VO->getTemplateName();
		}
		return 	$options;
	}
	
	public function getSMSContentByQuery(Dakiya_VO_Master_SMS_SMSTemplateVO $smsTemplateVO){
		$con = Mage::getSingleton('core/resource')->getConnection('dakiya_read');
    	$stmnt = $con->prepare($smsTemplateVO->getQuery());
    	$stmnt->execute();
    	$dataObjs = $stmnt->fetchAll();
    	$smsContent = $smsTemplateVO->getContent();
    	foreach ($dataObjs as $dataObj){
	    	foreach ($dataObj as $key=>$value){
	    		$smsContent = str_replace("{".$key."}",$value,$smsContent);
	    	}
    	}	
    	return $smsContent;
    }
	
	
	public function saveDB(Dakiya_VO_Master_SMS_SMSTemplateVO $smsTemplateVO){
		$responseVO  = new Dakiya_VO_Master_SMS_SMSTemplateVO;
		$adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate  = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		$smsTemplateDTO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
		if($smsTemplateVO->getTemplateID() > 0){
				
			$dataObj = $this->getByCode($smsTemplateVO->getTemplateCode());
			if($dataObj !== false){
				$newSMSTemplateDTO = new Dakiya_VO_Master_SMS_SMSTemplateVO();
				/* @var $newSMSTemplateVO Dakiya_VO_Master_SMS_SMSTemplateVO */
				$newSMSTemplateVO  = Dakiya_Helper_Utility::setVO($newSMSTemplateDTO, $dataObj);
					
				if($newSMSTemplateVO->getTemplateID() != $smsTemplateVO->getTemplateID()){
					$responseVO->setErrorMessage('Duplicate Template Code !');
					return $responseVO;
				}
			}
				
			$rowSet = $smsTemplateDTO->find( $smsTemplateVO->getTemplateID() );
			$row    = $rowSet['_data'];
				
			$smsTemplateVO->setUpdatedAt($serverDate);
			$smsTemplateVO->setUpdatedBy($adminUserID);
		}else{
			$dataObj = $this->getByCode($smsTemplateVO->getTemplateCode());
			if($dataObj !== false){
				$responseVO->setErrorMessage('Duplicate Template Code !');
				return $responseVO;
			}
				
			$row = $smsTemplateDTO->fetchNew();
				
			$smsTemplateVO->setCreatedAt($serverDate);
			$smsTemplateVO->setCreatedBy($adminUserID);
			$smsTemplateVO->setUpdatedAt($serverDate);
			$smsTemplateVO->setUpdatedBy($adminUserID);
		}
	
		foreach($smsTemplateVO->getDataArray() as $key=>$value){
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