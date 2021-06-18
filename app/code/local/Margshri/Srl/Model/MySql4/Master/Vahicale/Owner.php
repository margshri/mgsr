<?php
class Margshri_Transport_Model_Mysql4_Master_Vahicale_Owner extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$tableAlias, Margshri_Transport_VO_Master_Vahicale_OwnerVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getByMobileNo($mobileNo){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("MobileNo =?", $mobileNo);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	public function getList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable());
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	
	public function getOptions(){
	    $dataObjs = $this->getList();
	    $options = array();
	    
	    foreach($dataObjs as $dataObj){
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_OwnerVO */
	        $VO  = Margshri_Common_Helper_Utility::setVO($DTO, $dataObj);
	        $options[$VO->getID()]= $VO->getName();
	    }
	    return 	$options;
	}
	
	
	public function getActiveList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("StatusID =?", Margshri_Common_VO_Status_StatusVO::$ACTIVE);
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	
	public function getActiveOptions(){
	    $dataObjs = $this->getActiveList();
	    $options = array();
	    
	    foreach($dataObjs as $dataObj){
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_OwnerVO */
	        $VO  = Margshri_Common_Helper_Utility::setVO($DTO, $dataObj);
	        $options[$VO->getID()]= $VO->getName();
	    }
	    return 	$options;
	}
	
	
	public function getByVOCheckDuplicate(Margshri_Transport_VO_Master_Vahicale_OwnerVO $ownerVO){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("MobileNo =?", $ownerVO->getMobileNo());
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function saveDB(Margshri_Transport_VO_Master_Vahicale_OwnerVO $ownerVO){
	
	    try{
	        $responseVO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$ownerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
    		
    		$newOwnerDataObj = $this->getByVOCheckDuplicate($ownerVO);
    		if($ownerVO->getID() > 0 ){
    		    
    		    if($newOwnerDataObj !== false){
    		        $newOwnerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
    		        /* @var $newOwnerVO Margshri_Transport_VO_Master_Vahicale_OwnerVO */
    		        $newOwnerVO = Margshri_Common_Helper_Utility::callInstanceFunction($newOwnerDTO, $newOwnerDataObj);
    		        
    		        if($ownerVO->getID() != $newOwnerVO->getID()){
    		            Mage::throwException("Duplicate Entry!");
    		        }
    		    }
    		    
    		    $rowSet = $ownerDTO->find($ownerVO->getID());
    			$row = $rowSet['_data'];
    			
    			$ownerVO->setUpdatedAt($serverDate);
    			$ownerVO->setUpdatedBy($userID);
    			
    		}else{
    		    
    		    if($newOwnerDataObj !== false){
		            Mage::throwException("Duplicate Entry!");
		        }
    		    
		        $row = $ownerDTO->fetchNew();
		        $ownerVO->setCreatedAt($serverDate);
		        $ownerVO->setCreatedBy($userID);
		        $ownerVO->setUpdatedAt($serverDate);
		        $ownerVO->setUpdatedBy($userID);
    		}
    		
    		foreach($ownerVO->getDataArray() as $key=>$value){
    			$row[$key] = $value;
    		}
    		
    		$isSaved = $row->save();
    		
    		
			
    		$responseData = array();
    		if($isSaved){
    			$responseVO->setSuccessMessage('Successfully Saved !');
    			$responseData['OwnerID'] = $row['ID'];
    			$responseVO->setResponseData("ResponseData", $responseData);
    		}else{
    			$responseVO->setErrorMessage('Could not Saved !');
    		}
    		
	    } catch (Exception $e) {
	        $responseVO->setErrorMessage($e->getMessage());
	    }
		return $responseVO;
	
	}
	
	 
}