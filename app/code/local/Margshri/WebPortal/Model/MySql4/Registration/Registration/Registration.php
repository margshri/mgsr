<?php
class Margshri_WebPortal_Model_Mysql4_Registration_Registration_Registration extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('webportal/apctwebstudentregistration', 'ID');
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_MedicalCamp_VO_RegistrationVO $registrationVO){
		
		$responseVO  = new Margshri_MedicalCamp_VO_RegistrationVO();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		
		$registrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
		
		
		if($registrationVO->getID() > 0 ){
			
			$rowSet = $registrationDTO->find( $registrationVO->getID() );
			$row    = $rowSet['_data'];
			
			$registrationVO->setUpdatedAt($serverDate);
			
			
		}else{
			$row = $registrationDTO->fetchNew();
			$registrationVO->setCreatedAt($serverDate);
			$registrationVO->setUpdatedAt($serverDate);
		}
		
		foreach($registrationVO->getDataArray() as $key=>$value){
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