<?php
class Margshri_WebPortal_Model_Mysql4_Master_Right_CLPConfig extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebclpconfig', 'ID');
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveRecord(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $entity){
			/* @var $entityVO Margshri_WebPortal_VO_Master_SubPage_EntityVO */
			$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
			$entityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($entityDTO, $entity);
			$option[$entityVO->getID()]= $entityVO->getValue();
		}
		return 	$option;
	}
	
	public function getByTableCode($tableCode){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("TableCode =?", $tableCode);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getActiveRecordByTableCode($tableCode){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("TableCode =?", $tableCode)
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_WebPortal_VO_Master_SubPage_EntityVO $entityVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE 
		$entityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
	
		if($entityVO->getID() > 0){
			
			$dataObj = $this->getByTableCode($entityVO->getTableCode());
			
			if($dataObj !== false){
				$newEntityDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityVO();
				/* @var $newEntityVO Margshri_WebPortal_VO_Master_SubPage_EntityVO */
				$newEntityVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newEntityDTO, $dataObj);
				
				if($entityVO->getID() != $newEntityVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Table Code !';
					return $response;
				}
			}
			
			
			$rowSet = $entityDTO->find( $entityVO->getID());
			$row    = $rowSet['_data'];
			
			$entityVO->setUpdatedAt($serverDate);
			$entityVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByTableCode($entityVO->getTableCode());
			
			if($dataObj !== false){
				
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Table Code !';
				return $response;
			}	
			
			$row = $entityDTO->fetchNew();
			
			$entityVO->setCreatedAt($serverDate);
			$entityVO->setCreatedBy($userID);
			$entityVO->setUpdatedAt($serverDate);
			$entityVO->setUpdatedBy($userID);
		}
	
		foreach($entityVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}