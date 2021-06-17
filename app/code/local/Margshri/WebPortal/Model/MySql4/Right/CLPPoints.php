<?php
class Margshri_WebPortal_Model_Mysql4_Right_CLPPoints extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctwebclppoints', 'ID');
	}
	
	
	public function getByCustomerID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $id);
		$rowSet = $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function saveDB(Margshri_WebPortal_VO_Right_CLPPointsVO $clpPointsVO){
		$response = array();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		$clpPointsDTO = new Margshri_WebPortal_VO_Right_CLPPointsVO();
		if($clpPointsVO->getID() > 0){
			
			$rowSet = $clpPointsDTO->find( $clpPointsVO->getID() );
			$row    = $rowSet['_data'];
			$clpPointsVO->setUpdatedAt($serverDate);
			
		}else{
			$row = $clpPointsDTO->fetchNew();
			$clpPointsVO->setCreatedAt($serverDate);
			$clpPointsVO->setUpdatedAt($serverDate);
		}
		 
		foreach($clpPointsVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		
		if($clpPointsVO->getID() > 0){
			$clpPointsID = $clpPointsVO->getID();
		}else{
			$clpPointsID = $clpPointsDTO->getAdapter()->lastInsertId();;
		}
		
		$response['data'] = $clpPointsID;
		return $response;
	}
	 
}