<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type11_Type11 extends Mage_Core_Model_Mysql4_Abstract{
	
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
	
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type11_Type11VO $type11VO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$type11DTO = new Margshri_WebPortal_VO_Center_Content_Type11_Type11VO($type11VO->getTableName());;
	
		if($type11VO->getID() > 0){
			$rowSet = $type11DTO->find( $type11VO->getID());
			$row    = $rowSet['_data'];
			
			$type11VO->setUpdatedAt($serverDate);
			$type11VO->setUpdatedBy($userID);
		}else{
			$row = $type11DTO->fetchNew();
			
			$type11VO->setCreatedAt($serverDate);
			$type11VO->setCreatedBy($userID);
			$type11VO->setUpdatedAt($serverDate);
			$type11VO->setUpdatedBy($userID);
		}
	
		foreach($type11VO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}