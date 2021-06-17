<?php
class Margshri_WebPortal_Model_Mysql4_Footer_VisitorCounter extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctwebvisitorcounter', 'ID');
	}

	
	public function getAll(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getLast(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->order("ID DESC")
		->limit(1);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function frontendSaveDB(Margshri_WebPortal_VO_Footer_VisitorCounterVO $visitorCounterVO){
		
		$response = array();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE
		$DTO = new Margshri_WebPortal_VO_Footer_VisitorCounterVO();
	
		if($visitorCounterVO->getID() > 0){
			$rowSet = $DTO->find($visitorCounterVO->getID());
			$row = $rowSet['_data'];
		}else{
			$visitorCounterVO->setCreatedAt($serverDate);
			$row = $DTO->fetchNew();
		}
	
		foreach($visitorCounterVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	
}