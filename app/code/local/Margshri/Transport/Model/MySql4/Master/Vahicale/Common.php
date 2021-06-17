<?php
class Margshri_Transport_Model_Mysql4_Master_Vahicale_Common extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Master_Vahicale_CommonVO::$tableAlias, Margshri_Transport_VO_Master_Vahicale_CommonVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
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
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_CommonVO */
	        $VO  = Margshri_Common_Helper_Utility::setVO($DTO, $dataObj);
	        $options[$VO->getID()]= $VO->getVahicaleNumber();
	    }
	    return 	$options;
	}
	
	
	
	public function getByVahicaleNumber($vahicaleNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("VahicaleNumber =?", $vahicaleNumber);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getByVOCheckDuplicate(Margshri_Transport_VO_Master_Vahicale_CommonVO $commonVO){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("VahicaleID =?", $commonVO->getVahicaleID())
	    ->where("OwnerID =?", $commonVO->getOwnerID())
	    ->where("DriverID =?", $commonVO->getDriverID());
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	
	public function saveDB(Margshri_Transport_VO_Master_Vahicale_CommonVO $commonVO){
	
	    try{
	        $responseVO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$commonDTO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
    		
    		$newCommonDataObj = $this->getByVOCheckDuplicate($commonVO);
    		if($commonVO->getID() > 0 ){
    		    
    		    if($newCommonDataObj !== false){
    		        $newCommonDTO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
    		        /* @var $newCommonVO Margshri_Transport_VO_Master_Vahicale_CommonVO */
    		        $newCommonVO = Margshri_Common_Helper_Utility::callInstanceFunction($newCommonDTO, $newCommonDataObj);
    		        
    		        if($commonVO->getID() != $newCommonVO->getID()){
    		            Mage::throwException("Duplicate Entry!");
    		        }
    		    }
    		    
    		    $rowSet = $commonDTO->find($commonVO->getID());
    			$row = $rowSet['_data'];
    			
    			$commonVO->setUpdatedAt($serverDate);
    			$commonVO->setUpdatedBy($userID);
    			
    		}else{
    		    
    		    if($newCommonDataObj !== false){
		            Mage::throwException("Duplicate Entry!");
		        }
    		    
		        $row = $commonDTO->fetchNew();
		        $commonVO->setCreatedAt($serverDate);
		        $commonVO->setCreatedBy($userID);
		        $commonVO->setUpdatedAt($serverDate);
		        $commonVO->setUpdatedBy($userID);
    		}
    		
    		foreach($commonVO->getDataArray() as $key=>$value){
    			$row[$key] = $value;
    		}
    		$isSaved = $row->save();
			
		
    		$responseData = array();
    		if($isSaved){
    		    $responseVO->setSuccessMessage('Successfully Saved !');
    		    $responseData['CommonID'] = $row['ID'];
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