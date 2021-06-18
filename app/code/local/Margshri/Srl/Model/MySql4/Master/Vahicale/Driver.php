<?php
class Margshri_Transport_Model_Mysql4_Master_Vahicale_Driver extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Master_Vahicale_DriverVO::$tableAlias, Margshri_Transport_VO_Master_Vahicale_DriverVO::$primaryKey);
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
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_DriverVO */
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
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_DriverVO */
	        $VO  = Margshri_Common_Helper_Utility::setVO($DTO, $dataObj);
	        $options[$VO->getID()]= $VO->getName();
	    }
	    return 	$options;
	}
	
	public function getByVOCheckDuplicate(Margshri_Transport_VO_Master_Vahicale_DriverVO $driverVO){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("MobileNo =?", $driverVO->getMobileNo());
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	
	public function saveDB(Margshri_Transport_VO_Master_Vahicale_DriverVO $driverVO){
	
	    try{
	        $responseVO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$driverDTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
    		
    		$newDriverDataObj = $this->getByVOCheckDuplicate($driverVO);
    		if($driverVO->getID() > 0 ){
    		    
    		    if($newDriverDataObj !== false){
    		        $newDriverDTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
    		        /* @var $newDriverVO Margshri_Transport_VO_Master_Vahicale_DriverVO */
    		        $newDriverVO = Margshri_Common_Helper_Utility::callInstanceFunction($newDriverDTO, $newDriverDataObj);
    		        
    		        if($driverVO->getID() != $newDriverVO->getID()){
    		            Mage::throwException("Duplicate Entry!");
    		        }
    		    }
    		    
    		    $rowSet = $driverDTO->find($driverVO->getID());
    			$row = $rowSet['_data'];
    			
    			$driverVO->setUpdatedAt($serverDate);
    			$driverVO->setUpdatedBy($userID);
    			
    		}else{
    		    
    		    if($newDriverDataObj !== false){
		            Mage::throwException("Duplicate Entry!");
		        }
    		    
		        $row = $driverDTO->fetchNew();
		        $driverVO->setCreatedAt($serverDate);
		        $driverVO->setCreatedBy($userID);
		        $driverVO->setUpdatedAt($serverDate);
		        $driverVO->setUpdatedBy($userID);
    		}
    		
    		foreach($driverVO->getDataArray() as $key=>$value){
    			$row[$key] = $value;
    		}
    		$isSaved = $row->save();
			
    		$responseData = array();
    		if($isSaved){
    			$responseVO->setSuccessMessage('Successfully Saved !');
    			$responseData['DriverID'] = $row['ID'];
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