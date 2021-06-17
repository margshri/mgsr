<?php
class Margshri_Common_Model_Mysql4_Customer_Customer extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
		$this->_init('common/apctcustomer', 'ID');
	}
	
	
	public function getByCustomerID($customerID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("CustomerID =?", $customerID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getByMobileNumber($mobileNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("MobileNumber =?", $mobileNumber);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getByEmailID($emailID){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("EmailID =?", $emailID);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	public function saveDB(Margshri_Common_VO_Customer_CustomerVO $customerVO){
	
		$response = array();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		
		// INSERT OR UPDATE 
		$customerDTO = new Margshri_Common_VO_Customer_CustomerVO();
		$customerDataObj = $this->getByCustomerID($customerVO->getCustomerID());
		if($customerVO->getID() > 0){
			if($customerDataObj !== false){
				$newCustomerDTO = new Margshri_Common_VO_Customer_CustomerVO();
				/* @var $newCustomerVO Margshri_Common_VO_Customer_CustomerVO */
				$newCustomerVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newCustomerDTO, $customerDataObj);
				
				if($newCustomerVO->getID() != $customerVO->getID()){
					$response['status']  = "ERROR";
					$response['message'] = "Duplicate Entry !";
					return $response; 
				}
			}
			
			$rowSet = $customerDTO->find($customerVO->getID());
			$row = $rowSet['_data'];
			
			$customerVO->setUpdatedAt($serverDate);
			$customerVO->setUpdatedBy($userID);
			
		}else{
			
			if($customerDataObj !== false){
				$response['status']  = "ERROR";
				$response['message'] = "Duplicate Entry !";
				return $response;
			}
			
			$row = $customerDTO->fetchNew();
			$customerVO->setCreatedAt($serverDate);
			$customerVO->setCreatedBy($userID);
			$customerVO->setUpdatedAt($serverDate);
			$customerVO->setUpdatedBy($userID);
		}
	
		foreach($customerVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	
	public function saveFrontDB(Margshri_Common_VO_Customer_CustomerVO $customerVO){
	    
	    $response = array();
	    $serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	    $userID = 1;
	    
	    // INSERT OR UPDATE
	    $customerDTO = new Margshri_Common_VO_Customer_CustomerVO();
	    $customerDataObj = $this->getByCustomerID($customerVO->getCustomerID());
	    if($customerVO->getID() > 0){
	        if($customerDataObj !== false){
	            $newCustomerDTO = new Margshri_Common_VO_Customer_CustomerVO();
	            /* @var $newCustomerVO Margshri_Common_VO_Customer_CustomerVO */
	            $newCustomerVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newCustomerDTO, $customerDataObj);
	            
	            if($newCustomerVO->getID() != $customerVO->getID()){
	                $response['status']  = "ERROR";
	                $response['message'] = "Duplicate Entry !";
	                return $response;
	            }
	        }
	        
	        $rowSet = $customerDTO->find($customerVO->getID());
	        $row = $rowSet['_data'];
	        
	        $customerVO->setUpdatedAt($serverDate);
	        $customerVO->setUpdatedBy($userID);
	        
	    }else{
	        
	        if($customerDataObj !== false){
	            $response['status']  = "ERROR";
	            $response['message'] = "Duplicate Entry !";
	            return $response;
	        }
	        
	        $row = $customerDTO->fetchNew();
	        $customerVO->setCreatedAt($serverDate);
	        $customerVO->setCreatedBy($userID);
	        $customerVO->setUpdatedAt($serverDate);
	        $customerVO->setUpdatedBy($userID);
	    }
	    
	    foreach($customerVO->getDataArray() as $key=>$value){
	        $row[$key] = $value;
	    }
	    $row->save();
	    
	    $response['status']  = 'SUCCESS';
	    $response['message'] = 'Successfully Saved';
	    return $response;
	    
	}
	
}