<?php
class Margshri_WebPortal_Model_Mysql4_Firm_Firm_Firm extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebfirm', 'ID');
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_WebPortal_VO_Firm_Firm_FirmVO $firmVO){
	
		$responseVO  = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		
		$newFirmDTO = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
		
		
		if($firmVO->getID() > 0 ){
			
			$rowSet = $newFirmDTO->find( $firmVO->getID() );
			$row    = $rowSet['_data'];
			
			$firmVO->setUpdatedAt($serverDate);
			$firmVO->setUpdatedBy($userID);
			
		}else{
			$row = $newFirmDTO->fetchNew();
			$firmVO->setCreatedAt($serverDate);
			$firmVO->setCreatedBy($userID);
			$firmVO->setUpdatedAt($serverDate);
			$firmVO->setUpdatedBy($userID);
		}
		
		foreach($firmVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$isSaved = $row->save();
			
		
		if($isSaved){
			$responseVO->setSuccessMessage('Successfully Saved !');
		}else{
			$responseVO->setErrorMessage('Could not Saved !');
		}
		
		return $responseVO;
	
	}
	
	 
}