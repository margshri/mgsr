<?php
class Margshri_WebPortal_Model_Mysql4_Master_Table_TableType extends Mage_Core_Model_Mysql4_Abstract{

	protected function _construct()
	{
		$this->_init('webportal/apctwebtabletype', 'ID');
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
			$DTO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= $VO->getValue();
		}
		return 	$option;
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getByCode($code){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("Code =?", $code);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_WebPortal_VO_Master_Table_TableTypeVO $tableTypeVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE
		$tableTypeDTO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
	
		if($tableTypeVO->getID() > 0){
			
			$tableTypeDataObj = $this->getByCode($tableTypeVO->getCode());
			if($tableTypeDataObj !== false){
				
				$newTableTypeDTO = new Margshri_WebPortal_VO_Master_Table_TableTypeVO();
				/* @var $newTableTypeVO Margshri_WebPortal_VO_Master_Table_TableTypeVO */
				$newTableTypeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newTableTypeDTO, $tableTypeDataObj);
				
				if($tableTypeVO->getID() != $newTableTypeVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Code';
					return $response;
				}	 
			}
			
			$rowSet = $tableTypeDTO->find( $tableTypeVO->getID() );
			$row    = $rowSet['_data'];
			
			$tableTypeVO->setUpdatedAt($serverDate);
			$tableTypeVO->setUpdatedBy($userID);
		}else{
			
			$tableTypeDataObj = $this->getByCode($tableTypeVO->getCode());
			if($tableTypeDataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Code';
				return $response;
			}
			
			$row = $tableTypeDTO->fetchNew();
			$tableTypeVO->setCreatedAt($serverDate);
			$tableTypeVO->setCreatedBy($userID);
			$tableTypeVO->setUpdatedAt($serverDate);
			$tableTypeVO->setUpdatedBy($userID);
		}
	
		foreach($tableTypeVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}