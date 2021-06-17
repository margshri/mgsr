<?php
class Margshri_WebPortal_Model_Mysql4_Master_SubPage_EntityAttribute extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebsubpageentityattribute', 'ID');
	}
	 
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getByEntityID($entityID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("EntityID =?", $entityID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveRecordByEntityID($entityID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("EntityID =?", $entityID)
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getByEntityIDAndAttributeID($entityID, $attributeID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("EntityID =?", $entityID)
		->where("AttributeID =?", $attributeID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	
	public function saveDB(Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO $entityAttributeVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE 
		$entityAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
	
		if($entityAttributeVO->getID() > 0){
			
			$dataObj = $this->getByEntityIDAndAttributeID($entityAttributeVO->getEntityID(), $entityAttributeVO->getAttributeID());
			
			if($dataObj !== false){
				$newEntityAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO();
				/* @var $newEntityAttributeVO Margshri_WebPortal_VO_Master_SubPage_EntityAttributeVO */
				$newEntityAttributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newEntityAttributeDTO, $dataObj);
				
				if($entityAttributeVO->getID() != $newEntityAttributeVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'This Attribute Already Mapped With This Entity !';
					return $response;
				}
			}
			
			
			$rowSet = $entityAttributeDTO->find( $entityAttributeVO->getID());
			$row    = $rowSet['_data'];
			
			$entityAttributeVO->setUpdatedAt($serverDate);
			$entityAttributeVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByEntityIDAndAttributeID($entityAttributeVO->getEntityID(), $entityAttributeVO->getAttributeID());
			
			if($dataObj !== false){
				
				$response['status']  = 'ERROR';
				$response['message'] = 'This Attribute Already Mapped With This Entity !';
				return $response;
			}	
			
			$row = $entityAttributeDTO->fetchNew();
			
			$entityAttributeVO->setCreatedAt($serverDate);
			$entityAttributeVO->setCreatedBy($userID);
			$entityAttributeVO->setUpdatedAt($serverDate);
			$entityAttributeVO->setUpdatedBy($userID);
		}
	
		foreach($entityAttributeVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}