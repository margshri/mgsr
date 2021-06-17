<?php
class Margshri_Common_Model_Mysql4_Member_Member_Member extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Member_Member_MemberVO::$tableAlias, Margshri_Common_VO_Member_Member_MemberVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getMemberList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable());
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	public function getByUserID($userID){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("UserID =?", $userID);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getExecutiveMemberList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("IsExecutive =?", 1)
	    ->order("DisplayOrder");
	    $rowSet =  $read->fetchAll($select);
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