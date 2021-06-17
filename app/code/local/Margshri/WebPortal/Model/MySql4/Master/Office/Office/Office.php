<?php
class Margshri_WebPortal_Model_Mysql4_Master_Office_Office_Office extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctweboffice', 'ID');
	}

	
	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $status){
			$DTO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $status);
			$option[$VO->getID()]= $VO->getValue();
		}
		return 	$option;
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
	
	 
	public function saveDB(Margshri_WebPortal_VO_Master_Office_OfficeVO $officeVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$officeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
	
		if($officeVO->getID() > 0){
			
			$dataObj = $this->getByCode($officeVO->getCode());
			if($dataObj !== false){
				$newOfficeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeVO();
				/*  @var $newOfficeVO  Margshri_WebPortal_VO_Master_Office_OfficeVO */
				$newOfficeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newOfficeDTO, $dataObj);
				
				if($newOfficeVO->getID() != $officeVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Office Code Already Exist';
					return $response;
				}
			}
			
			
			
			$rowSet = $officeDTO->find( $officeVO->getID() );
			$row    = $rowSet['_data'];
			
			$officeVO->setUpdatedAt($serverDate);
			$officeVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByCode($officeVO->getCode());
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Office Code Already Exist';
				return $response;
			}
			
			$row = $officeDTO->fetchNew();
			
			$officeVO->setCreatedAt($serverDate);
			$officeVO->setCreatedBy($userID);
			$officeVO->setUpdatedAt($serverDate);
			$officeVO->setUpdatedBy($userID);
			
		}
	
		foreach($officeVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}