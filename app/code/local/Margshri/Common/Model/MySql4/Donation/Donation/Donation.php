<?php
class Margshri_Common_Model_Mysql4_Donation_Donation_Donation extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Donation_Donation_DonationVO::$tableAlias, Margshri_Common_VO_Donation_Donation_DonationVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getDonorList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable());
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	public function getByNameAndMobileNumber($name, $mobileNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("Name =?", $name)
	    ->where("MobileNumber1 =?", $mobileNumber);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getByProgrammeID($programmeID){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("ProgrammeID =?", $programmeID)
	    ->order("DonatedAmount DESC");
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	public function getByReceiptNumber($receiptNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("ReceiptNumber =?", $receiptNumber);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	public function getGroupProgrammeList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from(array("donation"=>$this->getMainTable()) , array("ProgrammeID"=>"donation.ProgrammeID") )
	    ->joinInner(array("programme"=>$this->getTable("common/mgsrprogramme")), "donation.ProgrammeID = programme.ID", array("ProgrammeName"=>"programme.ProgrammeName" ) )
	    ->where("donation.StatusID =?", Margshri_Common_VO_Status_StatusVO::$ACTIVE)
	    ->where("programme.StatusID =?", Margshri_Common_VO_Master_Programme_ProgrammeStatusVO::$RUNNING)
	    ->group("donation.ProgrammeID")
	    ->order("donation.ProgrammeID DESC");
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	
	public function getLastByBloodDonorID($donorID){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("StatusID =?", Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$PAID)
	    ->where("UserID =?", $donorID)
	    ->where(new Zend_Db_Expr("DonationTypeID = ". Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$BLOOD . " OR DonationTypeID = ". Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$BLOOD_SDP))
	    ->group("UserID")
	    ->order("UserID DESC");
	    $rowSet = $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function saveDB(Margshri_Common_VO_Donation_Donation_DonationVO $donationVO, Margshri_Common_VO_ResponseVO $responseVO){
	
	    try{
    	    
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$donationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
    		
    		$newDonationDataObj = $this->getByReceiptNumber($donationVO->getReceiptNumber());
    		if($donationVO->getID() > 0 ){
    			
    		    if($donationVO->getReceiptNumber() != null){
        		    if($newDonationDataObj !== false){
        		        $newDonationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
        		        /* @var $newDonationVO Margshri_Common_VO_Donation_Donation_DonationVO */
        		        $newDonationVO = Margshri_Common_Helper_Utility::callInstanceFunction($newDonationDTO, $newDonationDataObj);
        		        
        		        if($donationVO->getID() != $newDonationVO->getID()){
        		            Mage::throwException("Duplicate Receipt Number");
        		        }
        		    }
    		    }
    		    
    		    $rowSet = $donationDTO->find($donationVO->getID());
    			$row    = $rowSet['_data'];
    			
    			$donationVO->setUpdatedAt($serverDate);
    			$donationVO->setUpdatedBy($userID);
    			
    		}else{
    		    
    		    if($donationVO->getReceiptNumber() != null){
    		        if($newDonationDataObj !== false){
    		            Mage::throwException("Duplicate Receipt Number");
    		        }
    		    }
    		    
    		    
    		    $row = $donationDTO->fetchNew();
    		    $donationVO->setCreatedAt($serverDate);
    		    $donationVO->setCreatedBy($userID);
    		    $donationVO->setUpdatedAt($serverDate);
    		    $donationVO->setUpdatedBy($userID);
    		}
    		
    		foreach($donationVO->getDataArray() as $key=>$value){
    			$row[$key] = $value;
    		}
    		$isSaved = $row->save();
			
		
    		if($isSaved){
    			$responseVO->setSuccessMessage('Successfully Saved !');
    		}else{
    			$responseVO->setErrorMessage('Could not Saved !');
    		}
    		
	    } catch (Exception $e) {
	        $responseVO->setErrorMessage($e->getMessage());
	    }
		return $responseVO;
	
	}
	
	 
}