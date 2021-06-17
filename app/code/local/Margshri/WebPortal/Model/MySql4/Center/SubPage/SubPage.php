<?php
class Margshri_WebPortal_Model_Mysql4_Center_SubPage_SubPage extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebsubpage', 'ID');
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getActiveRecordByRecordIDAndEntityAttributeID($recordID, $entityAttributeID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("RecordID =?", $recordID)
		->where("EntityAttributeID =?", $entityAttributeID)
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getByRecordIDAndEntityAttributeID($recordID, $entityAttributeID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("RecordID =?", $recordID)
		->where("EntityAttributeID =?", $entityAttributeID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	 
	
	
	public function getCustomerIDByMobileNumber($mobileNumber){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getTable("webportal/customerentityvarchar"), array("CustomerID"=>"entity_id"))
		->where("attribute_id =?", 139)
		->where("value =?", $mobileNumber);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getCustomerDetailByID($customerID){
		
		$customerDataObj = array();
		$read = $this->_getReadAdapter();
		
		$select  = $read->select()
		->from($this->getTable("webportal/customerentityvarchar"), array("FirstName"=>"value"))
		->where("attribute_id =?", 5)
		->where("entity_id =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		$customerDataObj['FirstName'] = $rowSet['FirstName'];
		
		$select  = $read->select()
		->from($this->getTable("webportal/customerentityvarchar"), array("LastName"=>"value"))
		->where("attribute_id =?", 7)
		->where("entity_id =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		$customerDataObj['LastName'] = $rowSet['LastName'];
		
		$select  = $read->select()
		->from($this->getTable("webportal/customerentityvarchar"), array("ImagePath"=>"value"))
		->where("attribute_id =?", 140)
		->where("entity_id =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		$customerDataObj['ImagePath'] = $rowSet['ImagePath'];
		
		
		$select  = $read->select()
		->from($this->getTable("webportal/customerentitydatetime"), array("DOM"=>"value"))
		->where("attribute_id =?", 141)
		->where("entity_id =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		$customerDataObj['DOM'] = $rowSet['DOM'];
		
		$select  = $read->select()
		->from($this->getTable("webportal/customerentityint"), array("Gender"=>"value"))
		->where("attribute_id =?", 18)
		->where("entity_id =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		$customerDataObj['Gender'] = $rowSet['Gender'];
		
		
		$select  = $read->select()
		->from($this->getTable("webportal/apctwebprofessional"), array("ProfessionID"=>"ProfessionID"))
		->where("CustomerID =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		$customerDataObj['ProfessionID'] = $rowSet['ProfessionID'];
		
		return $customerDataObj;
		  
	}
	
	
	
	public function saveDB($subPageVOs){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));

		/* @var $subPageVO Margshri_WebPortal_VO_Center_SubPage_SubPageVO */
		foreach ($subPageVOs as $subPageVO){
		
			$subPageDTO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
			
			$subPageDataObj = $this->getByRecordIDAndEntityAttributeID($subPageVO->getRecordID(), $subPageVO->getEntityAttributeID());
			if($subPageDataObj !== false){
				$newSubPageDTO = new Margshri_WebPortal_VO_Center_SubPage_SubPageVO();
				/* @var $newSubPageVO Margshri_WebPortal_VO_Center_SubPage_SubPageVO */
				$newSubPageVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newSubPageDTO, $subPageDataObj);
				
				$rowSet = $subPageDTO->find( $newSubPageVO->getID() );
				$row    = $rowSet['_data'];
				$subPageVO->setUpdatedAt($serverDate);
				$subPageVO->setUpdatedBy($userID);
				
			}else{
				$row = $subPageDTO->fetchNew();
				$subPageVO->setCreatedAt($serverDate);
				$subPageVO->setCreatedBy($userID);
				$subPageVO->setUpdatedAt($serverDate);
				$subPageVO->setUpdatedBy($userID);
			}
			
			foreach($subPageVO->getDataArray() as $key=>$value){
				$row[$key] = $value;
			}
			$row->save();
			
		}
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	 
}