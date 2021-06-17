<?php
class Margshri_MedicalCamp_Model_Mysql4_Registration_Registration extends Mage_Core_Model_Mysql4_Abstract{

	protected function _construct(){
		$this->_init('medicalcamp/studentregistration', 'ID');
	}
	
	
	public function getAll(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from(array("maintable"=>$this->getMainTable() ))
	    ->joinLeft(array("city"=>$this->getTable('medicalcamp/citylist')), "maintable.CityID=city.ID", array("CityName"=>"city.Value") )
	    ->order("maintable.ID Desc");
	    // ->where("ID =?", $id);
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getByAadhaarNumber($aadhaarNumber){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("AddharCardNumber =?", $aadhaarNumber);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getByTransactionID($transactionID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("TransactionID =?", $transactionID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	

	public function getByTransactionIDAndMobileNumber($transactionID, $mobileNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("TransactionID =?", $transactionID)
	    ->where("MobileNumber =?", $mobileNumber);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getLastRecord(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->order("ID DESC")
	    ->limit(1);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getForCheckDuplicate(Margshri_MedicalCamp_VO_RegistrationVO $registrationVO){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("Name =?", $registrationVO->getName())
	    ->where("MobileNumber =?", $registrationVO->getMobileNumber())
	    ->where(new Zend_Db_Expr( "DATE(CreatedAt) > '2019-12-01' ") );
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	public function saveDB(Margshri_MedicalCamp_VO_RegistrationVO $registrationVO){
		
		$response = array();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		$registrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
		
		if($registrationVO->getID() > 0){
		    
		    $persistedDataObj = $this->getForCheckDuplicate($registrationVO);
		    if($persistedDataObj !== false){
		        $persistedRegistrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
		        $persistedRegistrationVO = Margshri_MedicalCamp_Model_DataAccess::callInstanceFunction($persistedRegistrationDTO, $persistedDataObj);
		        
		        if($persistedRegistrationVO->getID() != $registrationVO->getID()){
		            $response['status']  = "Error";
		            $response['message'] = "You have already registered.";
		            return $response;
		        }
		    }
		    
		    
			$rowSet = $registrationDTO->find( $registrationVO->getID() );
			$row    = $rowSet['_data'];
			$registrationVO->setUpdatedAt($serverDate);
		}else{
		    
		    $persistedDataObj = $this->getForCheckDuplicate($registrationVO);
		    if($persistedDataObj !== false){
                $response['status']  = "Error";
                $response['message'] = "You have already registered.";
                return $response;
		    }
		    
			$row = $registrationDTO->fetchNew();
			$registrationVO->setCreatedAt($serverDate);
			$registrationVO->setUpdatedAt($serverDate);
		}
	
		foreach($registrationVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$isSaved = $row->save();
		
		if($isSaved){
			$response['status']  = "Success";
			$response['message'] = "Successfully Saved !";
			$response['data'] = $registrationDTO->getAdapter()->lastInsertId();
		}else{
			$response['status']  = "Error";
			$response['message'] = "Not Saved !";
		}
		return $response;	
		
	}
}