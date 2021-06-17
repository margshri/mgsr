<?php
class Dakiya_Model_Mysql4_Master_SMS_SMSConfig extends Mage_Core_Model_Mysql4_Abstract
{
	protected function _construct(){
		$this->_init('dakiya/dakiyasmsconfig', 'ConfigID');
	}
	
	
	public function getByID($configID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ConfigID=?", $configID);
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
			$DTO = new Dakiya_VO_Master_SMS_SMSConfigVO();
			/* @var $VO Dakiya_VO_Master_SMS_SMSConfigVO */
			$VO  = Dakiya_Helper_Utility::setVO($DTO, $dataObj);
			$options[$VO->getConfigID()]= $VO->getConfigName();
		}
		return 	$options;
	}
	

	public function getSMSSenderOptions(){
		$dataObjs = $this->getList();
		$options = array();
	
		foreach($dataObjs as $dataObj){
			$DTO = new Dakiya_VO_Master_SMS_SMSConfigVO();
			/* @var $VO Dakiya_VO_Master_SMS_SMSConfigVO */
			$VO  = Dakiya_Helper_Utility::setVO($DTO, $dataObj);
			$options[$VO->getConfigID()]= $VO->getSenderName();
		}
		return 	$options;
	}
	
	
}