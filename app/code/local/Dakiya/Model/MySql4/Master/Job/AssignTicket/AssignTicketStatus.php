<?php
class Dakiya_Model_Mysql4_Master_Job_AssignTicket_AssignTicketStatus extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('newdakiya/dakiyaassignticketstatus', 'StatusID');
	}
	
	public function getByID($statusID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", $statusID);
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
			$DTO = new Dakiya_VO_Master_Job_AssignTicket_AssignTicketStatusVO();
			/* @var $VO Dakiya_VO_Master_Job_AssignTicket_AssignTicketStatusVO */
			$VO  = Dakiya_Helper_Utility::setVO($DTO, $dataObj);
			$options[$VO->getStatusID()]= $VO->getStatusName();
		}
		return 	$options;
	}
	 
	
}