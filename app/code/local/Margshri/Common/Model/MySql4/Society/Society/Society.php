<?php
class Margshri_Common_Model_Mysql4_Society_Society_Society extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Society_Society_SocietyVO::$tableAlias, Margshri_Common_VO_Society_Society_SocietyVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getByCode($code){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("Code =?", $code);
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
	    $list = $this->getList();
	    $option = array();
	    
	    foreach($list as $row){
	        $DTO = new Margshri_Common_VO_Society_Society_SocietyVO();
	        /* @var $VO Margshri_Common_VO_Society_Society_SocietyVO */
	        $VO = Margshri_Common_Helper_Utility::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getProgrammeName();
	    }
	    return 	$option;
	}
	
	public function saveDB(Margshri_Common_VO_Society_Society_SocietyVO $societyVO, Margshri_Common_VO_ResponseVO $responseVO){
	
	    try{
    	    
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$societyDTO = new Margshri_Common_VO_Society_Society_SocietyVO();
    		
    		$newSocietyDataObj = $this->getByCode($societyVO->getCode());
    		if($societyVO->getID() > 0 ){
    			
    		    if($newSocietyDataObj !== false){
    		        $newSocietyDTO = new Margshri_Common_VO_Society_Society_SocietyVO();
    		        /* @var $newSocietyVO Margshri_Common_VO_Society_Society_SocietyVO */
    		        $newSocietyVO = Margshri_Common_Helper_Utility::callInstanceFunction($newSocietyDTO, $newSocietyDataObj);
    		        
    		        if($societyVO->getID() != $newSocietyVO->getID()){
    		            Mage::throwException('Duplicate Entry.');
    		        }
    		    }
    		    
    		    $rowSet = $societyDTO->find($societyVO->getID());
    			$row = $rowSet['_data'];
    			
    			$societyVO->setUpdatedAt($serverDate);
    			$societyVO->setUpdatedBy($userID);
    			
    		}else{
    		    
    		    if($newSocietyDataObj !== false){
    		        Mage::throwException('Duplicate Entry.');
    		    }
    		    
    		    $row = $societyDTO->fetchNew();
    		    $societyVO->setCreatedAt($serverDate);
    		    $societyVO->setCreatedBy($userID);
    		    $societyVO->setUpdatedAt($serverDate);
    		    $societyVO->setUpdatedBy($userID);
    		}
    		
    		foreach($societyVO->getDataArray() as $key=>$value){
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