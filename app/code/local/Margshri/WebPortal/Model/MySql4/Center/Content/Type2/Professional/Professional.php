<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type2_Professional_Professional extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebprofessional', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getByCustomerIDAndProfessionID($customerID, $professionID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('CustomerID =?', $customerID)
		->where('ProfessionID =?', $professionID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type2_Professional_ProfessionalVO $professionalVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		 
		
		// INSERT OR UPDATE 
		$professionalDTO = new Margshri_WebPortal_VO_Center_Content_Type2_Professional_ProfessionalVO();
	
		if($professionalVO->getID() > 0){
			
			$dataObj = $this->getByCustomerIDAndProfessionID($professionalVO->getCustomerID(), $professionalVO->getProfessionID());
			
			if($dataObj !== false){
				$newProfessionalDTO = new Margshri_WebPortal_VO_Center_Content_Type2_Professional_ProfessionalVO();
				/*  @var $newProfessionalVO  Margshri_WebPortal_VO_Center_Content_Type2_Professional_ProfessionalVO */
				$newProfessionalVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newProfessionalDTO, $dataObj);
				
				if($newProfessionalVO->getID() != $professionalVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			
			$rowSet = $professionalDTO->find( $professionalVO->getID() );
			$row    = $rowSet['_data'];
			
			$professionalVO->setUpdatedAt($serverDate);
			$professionalVO->setUpdatedBy($userID);
			
		}else{
			
			$dataObj = $this->getByCustomerIDAndProfessionID($professionalVO->getCustomerID(), $professionalVO->getProfessionID());
				
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			
			
			$row = $professionalDTO->fetchNew();
			
			$professionalVO->setCreatedAt($serverDate);
			$professionalVO->setCreatedBy($userID);
			$professionalVO->setUpdatedAt($serverDate);
			$professionalVO->setUpdatedBy($userID);
			
		}
	
		foreach($professionalVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}