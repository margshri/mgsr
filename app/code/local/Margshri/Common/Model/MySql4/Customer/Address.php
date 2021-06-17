<?php
class Margshri_Common_Model_Mysql4_Customer_Address extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('common/apctcustomeraddress', 'ID');
	}
	 
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	

	public function getByCustomerIDAndTypeID($customerID, $typeID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $customerID)
		->where("TypeID =?", $typeID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function saveDB(Margshri_Common_VO_Customer_AddressVO $addressVO){
	
		$response = array();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		
		// INSERT OR UPDATE 
		$addressDTO = new Margshri_Common_VO_Customer_AddressVO();
	
		if($addressVO->getID() > 0){
			
			$addressDataObj = $this->getByCustomerIDAndTypeID($addressVO->getCustomerID(), $addressVO->getTypeID()); 
			
			if($addressDataObj !== false){
				$newAddressDTO = new Margshri_Common_VO_Customer_AddressVO();
				/* @var $newAddressVO Margshri_Common_VO_Customer_AddressVO */
				$newAddressVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newAddressDTO, $addressDataObj);
				
				if($newAddressVO->getID() != $addressVO->getID()){
					$response['status']  = "ERROR";
					$response['message'] = "Duplicate Entry !";
					return $response; 
				}
			}
			
			$rowSet = $addressDTO->find( $addressVO->getID() );
			$row    = $rowSet['_data'];
			
			$addressVO->setUpdatedAt($serverDate);
			
		}else{
			
			$addressDataObj = $this->getByCustomerIDAndTypeID($addressVO->getCustomerID(), $addressVO->getTypeID());
			
			if($addressDataObj !== false){
				$response['status']  = "ERROR";
				$response['message'] = "Duplicate Entry !";
				return $response;
			}
			
			$row = $addressDTO->fetchNew();
			$addressVO->setCreatedAt($serverDate);
			$addressVO->setUpdatedAt($serverDate);
		}
	
		foreach($addressVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}