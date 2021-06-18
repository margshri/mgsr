<?php
class Margshri_Transport_Model_Mysql4_Consignment_Consignment_ConsignmentNote extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO::$tableAlias, Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
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
	
	public function getByVOCheckDuplicate(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO $consignmentNoteVO){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("ConsignmentNo =?", $consignmentNoteVO->getConsignmentNo());
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	
	public function saveDB(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO $consignmentNoteVO){
	
	    try{
	        $responseVO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$consignmentNoteDTO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
    		
    		// $newConsignmentNoteDataObj = $this->getByVOCheckDuplicate($consignmentNoteVO);
    		if($consignmentNoteVO->getID() > 0 ){
    		    
//     		    if($newConsignmentNoteDataObj !== false){
//     		        $newConsignmentNoteDTO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
//     		        /* @var $newConsignmentNoteVO Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO */
//     		        $newConsignmentNoteVO = Margshri_Common_Helper_Utility::callInstanceFunction($newConsignmentNoteDTO, $newConsignmentNoteDataObj);
    		        
//     		        if($consignmentNoteVO->getID() != $newConsignmentNoteVO->getID()){
//     		            Mage::throwException("Duplicate Entry!");
//     		        }
//     		    }
    		    
    		    $rowSet = $consignmentNoteDTO->find($consignmentNoteVO->getID());
    			$row = $rowSet['_data'];
    			
    			$consignmentNoteVO->setUpdatedAt($serverDate);
    			$consignmentNoteVO->setUpdatedBy($userID);
    			
    		}else{
    		    
    		    /*
    		    if($newConsignmentNoteDataObj !== false){
		            Mage::throwException("Duplicate Entry!");
		        }
		        */
    		    
		        $row = $consignmentNoteDTO->fetchNew();
		        $consignmentNoteVO->setCreatedAt($serverDate);
		        $consignmentNoteVO->setCreatedBy($userID);
		        $consignmentNoteVO->setUpdatedAt($serverDate);
		        $consignmentNoteVO->setUpdatedBy($userID);
    		}
    		
    		foreach($consignmentNoteVO->getDataArray() as $key=>$value){
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