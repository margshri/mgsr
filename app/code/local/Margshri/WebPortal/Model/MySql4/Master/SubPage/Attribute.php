<?php
class Margshri_WebPortal_Model_Mysql4_Master_SubPage_Attribute extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebsubpageattribute', 'ID');
	}
	 
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getActiveRecordByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id)
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getByValue($value){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("Value =?", $value);
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
	
	public function getOptions(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $attribute){
			/* @var $attributeVO Margshri_WebPortal_VO_Master_SubPage_AttributeVO */
			$attributeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
			$attributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($attributeDTO, $attribute);
			$option[$attributeVO->getID()]= $attributeVO->getValue();
		}
		return 	$option;
	}
	
	public function saveDB(Margshri_WebPortal_VO_Master_SubPage_AttributeVO $attributeVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE 
		$attributeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
	
		if($attributeVO->getID() > 0){
			
			$dataObj = $this->getByValue($attributeVO->getValue());
			
			if($dataObj !== false){
				$newAttributeDTO = new Margshri_WebPortal_VO_Master_SubPage_AttributeVO();
				/* @var $newAttributeVO Margshri_WebPortal_VO_Master_SubPage_AttributeVO */
				$newAttributeVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newAttributeDTO, $dataObj);
				
				if($attributeVO->getID() != $newAttributeVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Attribute Name !';
					return $response;
				}
			}
			
			
			$rowSet = $attributeDTO->find( $attributeVO->getID());
			$row    = $rowSet['_data'];
			
			$attributeVO->setUpdatedAt($serverDate);
			$attributeVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByValue($attributeVO->getValue());
			
			if($dataObj !== false){
				
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Attribute Name !';
				return $response;
			}	
			
			$row = $attributeDTO->fetchNew();
			
			$attributeVO->setCreatedAt($serverDate);
			$attributeVO->setCreatedBy($userID);
			$attributeVO->setUpdatedAt($serverDate);
			$attributeVO->setUpdatedBy($userID);
		}
	
		foreach($attributeVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}