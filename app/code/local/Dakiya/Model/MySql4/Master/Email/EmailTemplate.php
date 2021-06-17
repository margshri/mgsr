<?php
class Dakiya_Model_Mysql4_Master_Email_EmailTemplate extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct(){
		$this->_init('dakiya/dakiyaemailtemplate', 'TemplateID');
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
			$DTO = new Dakiya_VO_Master_Email_EmailTemplateVO();
			/* @var $VO Dakiya_VO_Master_Email_EmailTemplateVO */
			$VO  = Dakiya_Helper_Utility::setVO($DTO, $dataObj);
			$options[$VO->getTemplateID()]= $VO->getTemplateName();
		}
		return 	$options;
	}
	
	public function getEmailContentByQuery(Dakiya_VO_Master_Email_EmailTemplateVO $emailTemplateVO){
		$con = Mage::getSingleton('core/resource')->getConnection('dakiya_read');
    	$stmnt = $con->prepare($emailTemplateVO->getQuery());
    	$stmnt->execute();
    	$dataObjs = $stmnt->fetchAll();
    	$emailContent = $emailTemplateVO->getContent();
    	foreach ($dataObjs as $dataObj){
	    	foreach ($dataObj as $key=>$value){
	    		$emailContent = str_replace("{".$key."}",$value,$emailContent);
	    	}
    	}	
    	return $emailContent;
    }
	
	
	public function saveDB(Dakiya_VO_Master_Email_EmailTemplateVO $emailTemplateVO){
		$responseVO  = new Dakiya_VO_Master_Email_EmailTemplateVO;
		$adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate  = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		$emailTemplateDTO = new Dakiya_VO_Master_Email_EmailTemplateVO();
		if($emailTemplateVO->getTemplateID() > 0){
				
			$dataObj = $this->getByCode($emailTemplateVO->getTemplateCode());
			if($dataObj !== false){
				$newEmailTemplateDTO = new Dakiya_VO_Master_Email_EmailTemplateVO();
				/* @var $newEmailTemplateVO Dakiya_VO_Master_Email_EmailTemplateVO */
				$newEmailTemplateVO  = Dakiya_Helper_Utility::setVO($newEmailTemplateDTO, $dataObj);
					
				if($newEmailTemplateVO->getTemplateID() != $emailTemplateVO->getTemplateID()){
					$responseVO->setErrorMessage('Duplicate Template Code !');
					return $responseVO;
				}
			}
				
			$rowSet = $emailTemplateDTO->find( $emailTemplateVO->getTemplateID() );
			$row    = $rowSet['_data'];
				
			$emailTemplateVO->setUpdatedAt($serverDate);
			$emailTemplateVO->setUpdatedBy($adminUserID);
		}else{
			$dataObj = $this->getByCode($emailTemplateVO->getTemplateCode());
			if($dataObj !== false){
				$responseVO->setErrorMessage('Duplicate Template Code !');
				return $responseVO;
			}
				
			$row = $emailTemplateDTO->fetchNew();
				
			$emailTemplateVO->setCreatedAt($serverDate);
			$emailTemplateVO->setCreatedBy($adminUserID);
			$emailTemplateVO->setUpdatedAt($serverDate);
			$emailTemplateVO->setUpdatedBy($adminUserID);
		}
	
		foreach($emailTemplateVO->getDataArray() as $key=>$value){
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