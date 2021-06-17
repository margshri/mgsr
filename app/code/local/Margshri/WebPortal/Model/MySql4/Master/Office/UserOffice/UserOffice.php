<?php
class Margshri_WebPortal_Model_Mysql4_Master_Office_UserOffice_UserOffice extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebuseroffice', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getByAdminUserID($adminUserID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('AdminUserID =?', $adminUserID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getByAdminUserIDAndOfficeID($adminUserID, $officeID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('AdminUserID =?', $adminUserID)
		->where('OfficeID =?', $officeID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	 
	public function saveDB(Margshri_WebPortal_VO_Master_Office_UserOfficeVO $userOfficeVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$userOfficeDTO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
	
		if($userOfficeVO->getID() > 0){
			
			$dataObj = $this->getByAdminUserIDAndOfficeID($userOfficeVO->getAdminUserID(), $userOfficeVO->getOfficeID());
			if($dataObj !== false){
				$newUserOfficeDTO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
				/*  @var $newUserOfficeVO  Margshri_WebPortal_VO_Master_Office_UserOfficeVO */
				$newUserOfficeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newUserOfficeDTO, $dataObj);
				
				if($newUserOfficeVO->getID() != $userOfficeVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Office Code Already Exist';
					return $response;
				}
			}
			
			
			
			$rowSet = $userOfficeDTO->find( $userOfficeVO->getID() );
			$row    = $rowSet['_data'];
			
			$userOfficeVO->setUpdatedAt($serverDate);
			$userOfficeVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByAdminUserIDAndOfficeID($userOfficeVO->getAdminUserID(), $userOfficeVO->getOfficeID());
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Office Code Already Exist';
				return $response;
			}
			
			$row = $userOfficeDTO->fetchNew();
			
			$userOfficeVO->setCreatedAt($serverDate);
			$userOfficeVO->setCreatedBy($userID);
			$userOfficeVO->setUpdatedAt($serverDate);
			$userOfficeVO->setUpdatedBy($userID);
			
		}
	
		foreach($userOfficeVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}