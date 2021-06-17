<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type8_Type8 extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->setInIt();
	}
	
	public function setInIt($tableCode=null){
		$this->_init('webportal/'.$tableCode, 'ID');
	}
	 
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type8_Type8VO $type8VO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		$tableVOs = $type8VO->getTableVOs();
		foreach ($tableVOs as $tableVO){
			
			// INSERT OR UPDATE 
			$type8DTO = new Margshri_WebPortal_VO_Center_Content_Type8_Type8VO($tableVO->getCode());;
		
			if($type8VO->getID() > 0){
				$rowSet = $type8DTO->find( $type8VO->getID());
				$row    = $rowSet['_data'];
				
				$type8VO->setUpdatedAt($serverDate);
				$type8VO->setUpdatedBy($userID);
			}else{
				$row = $type8DTO->fetchNew();
				
				$type8VO->setCreatedAt($serverDate);
				$type8VO->setCreatedBy($userID);
				$type8VO->setUpdatedAt($serverDate);
				$type8VO->setUpdatedBy($userID);
			}
		
			foreach($type8VO->getDataArray() as $key=>$value){
				$row[$key] = $value;
			}
			$row->save();
		}
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	
	public function saveDBNotInUse(Margshri_WebPortal_VO_Center_Content_Type8_Type8VO $type8VO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE
		$type8DTO = new Margshri_WebPortal_VO_Center_Content_Type8_Type8VO($type8VO->getTableName());;
	
		if($type8VO->getID() > 0){
			$rowSet = $type8DTO->find( $type8VO->getID());
			$row    = $rowSet['_data'];
				
			$type8VO->setUpdatedAt($serverDate);
			$type8VO->setUpdatedBy($userID);
		}else{
			$row = $type8DTO->fetchNew();
				
			$type8VO->setCreatedAt($serverDate);
			$type8VO->setCreatedBy($userID);
			$type8VO->setUpdatedAt($serverDate);
			$type8VO->setUpdatedBy($userID);
		}
	
		foreach($type8VO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}