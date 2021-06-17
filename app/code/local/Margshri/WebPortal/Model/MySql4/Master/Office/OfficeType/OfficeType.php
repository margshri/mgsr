<?php
class Margshri_WebPortal_Model_Mysql4_Master_Office_OfficeType_OfficeType extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebofficetype', 'ID');
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
	
		foreach($list as $row){
			$DTO = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
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

	
	public function saveDB(Margshri_WebPortal_VO_Master_Office_OfficeTypeVO $officeTypeVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE
		$officeTypeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
	
		if($officeTypeVO->getID() > 0){
				
			$dataObj = $this->getByCode($officeTypeVO->getCode());
			if($dataObj !== false){
				$newOfficeTypeDTO = new Margshri_WebPortal_VO_Master_Office_OfficeTypeVO();
				/*  @var $newOfficeTypeVO  Margshri_WebPortal_VO_Master_Office_OfficeTypeVO */
				$newOfficeTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newOfficeTypeDTO, $dataObj);
	
				if($newOfficeTypeVO->getID() != $officeTypeVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Office Type Code Already Exist';
					return $response;
				}
			}
				
				
				
			$rowSet = $officeTypeDTO->find( $officeTypeVO->getID() );
			$row    = $rowSet['_data'];
				
			$officeTypeVO->setUpdatedAt($serverDate);
			$officeTypeVO->setUpdatedBy($userID);
		}else{
				
			$dataObj = $this->getByCode($officeTypeVO->getCode());
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Office Code Already Exist';
				return $response;
			}
				
			$row = $officeTypeDTO->fetchNew();
				
			$officeTypeVO->setCreatedAt($serverDate);
			$officeTypeVO->setCreatedBy($userID);
			$officeTypeVO->setUpdatedAt($serverDate);
			$officeTypeVO->setUpdatedBy($userID);
				
		}
	
		foreach($officeTypeVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	 
}