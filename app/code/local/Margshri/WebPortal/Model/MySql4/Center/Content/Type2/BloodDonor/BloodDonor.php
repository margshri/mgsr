<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type2_BloodDonor_BloodDonor extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebblooddonor', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getByCustomerID($customerID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('CustomerID =?', $customerID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function frontendSaveDB(Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO $bloodDonorVO){
	
		$response = array();
		// $userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$userID = 1;
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		 
		
		// INSERT OR UPDATE 
		$bloodDonorDTO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
	
		if($bloodDonorVO->getID() > 0){
			
			$rowSet = $bloodDonorDTO->find( $bloodDonorVO->getID() );
			$row    = $rowSet['_data'];
			
			$bloodDonorVO->setUpdatedAt($serverDate);
			$bloodDonorVO->setUpdatedBy($userID);
			
		}else{
			
			$row = $bloodDonorDTO->fetchNew();
			
			$bloodDonorVO->setCreatedAt($serverDate);
			$bloodDonorVO->setCreatedBy($userID);
			$bloodDonorVO->setUpdatedAt($serverDate);
			$bloodDonorVO->setUpdatedBy($userID);
			
		}
	
		foreach($bloodDonorVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO $bloodDonorVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
			
	
		// INSERT OR UPDATE
		$bloodDonorDTO = new Margshri_WebPortal_VO_Center_Content_Type2_BloodDonor_BloodDonorVO();
	
		if($bloodDonorVO->getID() > 0){
				
			$rowSet = $bloodDonorDTO->find( $bloodDonorVO->getID() );
			$row    = $rowSet['_data'];
				
			$bloodDonorVO->setUpdatedAt($serverDate);
			$bloodDonorVO->setUpdatedBy($userID);
				
		}else{
				
			$row = $bloodDonorDTO->fetchNew();
				
			$bloodDonorVO->setCreatedAt($serverDate);
			$bloodDonorVO->setCreatedBy($userID);
			$bloodDonorVO->setUpdatedAt($serverDate);
			$bloodDonorVO->setUpdatedBy($userID);
				
		}
	
		foreach($bloodDonorVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}