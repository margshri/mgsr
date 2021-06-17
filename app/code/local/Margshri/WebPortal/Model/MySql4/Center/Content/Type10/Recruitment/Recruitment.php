<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type10_Recruitment_Recruitment extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebrecruitment', 'ID');
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

	public function getAllActiveRecord(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO $recruitmentVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$recruitmentDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO();
	
		if($recruitmentVO->getID() > 0){
			
			$dataObj = $this->getByCode($recruitmentVO->getCode());
			
			if($dataObj !== false){
				$newRecruitmentDTO = new Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO();
				/*  @var $newRecruitmentVO  Margshri_WebPortal_VO_Center_Content_Type10_Recruitment_RecruitmentVO */
				$newRecruitmentVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newRecruitmentDTO, $dataObj);
				
				if($newRecruitmentVO->getID() != $recruitmentVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			
			$rowSet = $recruitmentDTO->find( $recruitmentVO->getID() );
			$row    = $rowSet['_data'];
			
			$recruitmentVO->setUpdatedAt($serverDate);
			$recruitmentVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByCode($recruitmentVO->getCode());
				
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			
			
			$row = $recruitmentDTO->fetchNew();
			
			$recruitmentVO->setCreatedAt($serverDate);
			$recruitmentVO->setCreatedBy($userID);
			$recruitmentVO->setUpdatedAt($serverDate);
			$recruitmentVO->setUpdatedBy($userID);
			
		}
	
		foreach($recruitmentVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}