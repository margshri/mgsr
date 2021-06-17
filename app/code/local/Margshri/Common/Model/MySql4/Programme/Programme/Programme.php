<?php
class Margshri_Common_Model_Mysql4_Programme_Programme_Programme extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Programme_Programme_ProgrammeVO::$tableAlias, Margshri_Common_VO_Programme_Programme_ProgrammeVO::$primaryKey);
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
	        $DTO = new Margshri_Common_VO_Programme_Programme_ProgrammeVO();
	        /* @var $VO Margshri_Common_VO_Programme_Programme_ProgrammeVO */
	        $VO = Margshri_Common_Helper_Utility::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getProgrammeName();
	    }
	    return 	$option;
	}
	
	public function saveDB(Margshri_Common_VO_Programme_Programme_ProgrammeVO $programmeVO, Margshri_Common_VO_ResponseVO $responseVO){
	
	    try{
    	    
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$programmeDTO = new Margshri_Common_VO_Programme_Programme_ProgrammeVO();
    		
    		// $newUserDataObj = $this->getByNameAndMobileNumber($userVO->getName(), $userVO->getMobileNumber1());
    		if($programmeVO->getID() > 0 ){
    			
//     		    if($newUserDataObj !== false){
//     		        $newUserDTO = new Margshri_Common_VO_User_User_UserVO();
//     		        /* @var $newUserVO Margshri_Common_VO_User_User_UserVO */
//     		        $newUserVO = Margshri_Common_Helper_Utility::callInstanceFunction($newUserDTO, $newUserDataObj);
    		        
//     		        if($userVO->getID() != $newUserVO->getID()){
    		            
//     		        }
//     		    }
    		    
    		    $rowSet = $programmeDTO->find($programmeVO->getID());
    			$row = $rowSet['_data'];
    			
    			$programmeVO->setUpdatedAt($serverDate);
    			$programmeVO->setUpdatedBy($userID);
    			
    		}else{
    		    $row = $programmeDTO->fetchNew();
    		    $programmeVO->setCreatedAt($serverDate);
    		    $programmeVO->setCreatedBy($userID);
    		    $programmeVO->setUpdatedAt($serverDate);
    		    $programmeVO->setUpdatedBy($userID);
    		}
    		
    		foreach($programmeVO->getDataArray() as $key=>$value){
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