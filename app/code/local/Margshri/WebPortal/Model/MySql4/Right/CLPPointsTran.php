<?php
class Margshri_WebPortal_Model_Mysql4_Right_CLPPointsTran extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebclppointstran', 'ID');
	}
	
	public function getByCustomerID($customerID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $customerID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getTodayToBeDisabled($customerID){
		$todayDate  = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $customerID)
		->where("ModeID =?", Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$EARN)
		->where("EntityID =?", Margshri_WebPortal_VO_Master_Right_EntityVO::$SUB_PAGE_VISIT)
		->where("date(CreatedAt) =?", $todayDate);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getRecordForEarnCLPPoints($customerID, $entityTransactionID, $createdAt){
		$todayDate  = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $customerID)
		->where("ModeID =?", Margshri_WebPortal_VO_Master_Right_CLPPointsModeVO::$EARN)
		->where("EntityID =?", Margshri_WebPortal_VO_Master_Right_EntityVO::$CLP_PAGE_VISIT)
		->where("EntityTransactionID =?", $entityTransactionID)
		->where("date(CreatedAt) =?", $createdAt);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	
	public function getLastRecordByCustomerID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $id)
		->order("ID Desc")
		->limit(1);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getByVO(Margshri_WebPortal_VO_Right_CLPPointsTranVO $clpPointsTranVO){
	
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $clpPointsTranVO->getCustomerID())
		->where("TypeID =?", $clpPointsTranVO->getTypeID())
		->where("ModeID =?", $clpPointsTranVO->getModeID())
		->where("EntityID =?", $clpPointsTranVO->getEntityID())
		->where("EntityTransactionID =?", $clpPointsTranVO->getEntityTransactionID())
		->where(new zend_db_expr("DATE(CreatedAt) = '" . $clpPointsTranVO->getCreatedAt() . "'"));
		$rowSet = $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_WebPortal_VO_Right_CLPPointsTranVO $clpPointsTranVO){
		$response = array();
		$clpPointsTranDTO = new Margshri_WebPortal_VO_Right_CLPPointsTranVO();
		$row = $clpPointsTranDTO->fetchNew();
		foreach($clpPointsTranVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	}
}