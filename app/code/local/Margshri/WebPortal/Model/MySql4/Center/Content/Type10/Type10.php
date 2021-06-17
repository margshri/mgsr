<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type10_Type10 extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->setInIt();
	}
	
	public function setInIt($tableCode=null){
		$this->_init('webportal/'.$tableCode, 'ID');
	}
	 
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type10_Type10VO $type10VO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$type10DTO = new Margshri_WebPortal_VO_Center_Content_Type10_Type10VO($type10VO->getTableName());;
	
		if($type10VO->getID() > 0){
			$rowSet = $type10DTO->find( $type10VO->getID());
			$row    = $rowSet['_data'];
			
			$type10VO->setUpdatedAt($serverDate);
			$type10VO->setUpdatedBy($userID);
		}else{
			$row = $type10DTO->fetchNew();
			
			$type10VO->setCreatedAt($serverDate);
			$type10VO->setCreatedBy($userID);
			$type10VO->setUpdatedAt($serverDate);
			$type10VO->setUpdatedBy($userID);
		}
	
		foreach($type10VO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}