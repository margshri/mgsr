<?php
class Margshri_WebPortal_Model_Mysql4_Right_BidTran extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebbidtran', 'ID');
	}
	
	public function getByCustomerID($customerID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $customerID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getByBidIDAndCustomerID($bidID,$customerID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidID =?", $bidID)
		->where("CustomerID =?", $customerID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getLastByBidIDAndCustomerID($bidID,$customerID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidID =?", $bidID)
		->where("CustomerID =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	
	public function getBidTranCustomerWise($bidID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable(), array("Points"=>new zend_db_expr('SUM ( CASE WHEN Points != null THEN Points ELSE 0 END )')))
		->where("BidID =?", $bidID)
		->group("CustomerID");
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getCurrentBidTranByBidID($bidID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidID =?", $bidID);
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
	
	
	public function getLastByBidID($bidID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidID =?", $bidID)
		->order("ID Desc")
		->limit(1);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function saveDB(Margshri_WebPortal_VO_Right_BidTranVO $bidTranVO){
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		$bidTranVO->setCreatedAt($serverDate);
		$response = array();
		$bidTranDTO = new Margshri_WebPortal_VO_Right_BidTranVO();
		$row = $bidTranDTO->fetchNew();
		foreach($bidTranVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	}
	
	public function frontendSaveDB(Margshri_WebPortal_VO_Right_BidTranVO $bidTranVO){
	
		$response = array();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE
		$bidTranDTO = new Margshri_WebPortal_VO_Right_BidTranVO();
	
		if($bidTranVO->getID() > 0){
			$rowSet = $bidTranDTO->find($bidTranVO->getID());
			$row    = $rowSet['_data'];
		}else{
			$row = $bidTranDTO->fetchNew();
		}
	
		foreach($bidTranVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	
}