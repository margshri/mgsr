<?php
class Dakiya_Model_Mysql4_Master_Email_EmailSender extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct(){
		$this->_init('dakiya/localemailsender', 'SenderID');
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
			$DTO = new Dakiya_VO_Master_Email_EmailSenderVO();
			/* @var $VO Dakiya_VO_Master_Email_EmailSenderVO */
			$VO  = Dakiya_Helper_Utility::setVO($DTO, $dataObj);
			$options[$VO->getSenderID()]= $VO->getSenderName();
		}
		return 	$options;
	}
	
	public function getByID($senderID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("SenderID=?", $senderID);
		$rowSet =  $read->fetchRow($select);
	 	return $rowSet;
	}
	
}