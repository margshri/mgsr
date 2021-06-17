<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type6_ContactUs_ContactUs extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebcontactus', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getByCode($code){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('Code =?', $code);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}	

	public function getByMobileNumber1($mobileNumber1){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('MobileNumber1 =?', $mobileNumber1);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO $hospitalVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$hospitalDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO();
	
		if($hospitalVO->getID() > 0){
			
			$dataObj = $this->getByMobileNumber1($hospitalVO->getMobileNumber1());
			
			if($dataObj !== false){
				$newHospitalDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO();
				/*  @var $newHospitalVO  Margshri_WebPortal_VO_Center_Content_Type10_Hospital_HospitalVO */
				$newHospitalVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newHospitalDTO, $dataObj);
				
				if($newHospitalVO->getID() != $hospitalVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			
			$rowSet = $hospitalDTO->find( $hospitalVO->getID() );
			$row    = $rowSet['_data'];
			
			$hospitalVO->setUpdatedAt($serverDate);
			$hospitalVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByMobileNumber1($hospitalVO->getMobileNumber1());
				
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			
			
			$row = $hospitalDTO->fetchNew();
			
			$hospitalVO->setCreatedAt($serverDate);
			$hospitalVO->setCreatedBy($userID);
			$hospitalVO->setUpdatedAt($serverDate);
			$hospitalVO->setUpdatedBy($userID);
			
		}
	
		foreach($hospitalVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}