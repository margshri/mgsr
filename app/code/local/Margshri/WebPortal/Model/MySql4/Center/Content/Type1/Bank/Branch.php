<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type1_Bank_Branch extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebbankbranch', 'ID');
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
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO $branchVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$branchDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
	
		if($branchVO->getID() > 0){
			
			$dataObj = $this->getByCode($branchVO->getCode());
			
			if($dataObj !== false){
				$newBranchDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
				/*  @var $newBranchVO  Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO */
				$newBranchVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newBranchDTO, $dataObj);
				
				if($newBranchVO->getID() != $branchVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			
			$rowSet = $branchDTO->find( $branchVO->getID() );
			$row    = $rowSet['_data'];
			
			$branchVO->setUpdatedAt($serverDate);
			$branchVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByCode($branchVO->getCode());
				
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			
			
			$row = $branchDTO->fetchNew();
			
			$branchVO->setCreatedAt($serverDate);
			$branchVO->setCreatedBy($userID);
			$branchVO->setUpdatedAt($serverDate);
			$branchVO->setUpdatedBy($userID);
			
		}
	
		foreach($branchVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}