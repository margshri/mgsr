<?php
class Margshri_Common_Model_Mysql4_User_User_User extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_User_User_UserVO::$tableAlias, Margshri_Common_VO_User_User_UserVO::$primaryKey);
	}
	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->order("Name");
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	public function getOptions(){
	    $list = $this->getList();
	    $option = array();
	    
	    foreach($list as $row){
	        $DTO = new Margshri_Common_VO_User_User_UserVO();
	        /* @var $VO Margshri_Common_VO_User_User_UserVO */
	        $VO = Margshri_Common_Helper_Utility::callInstanceFunction($DTO, $row);
	        
	        $areaVO = new Margshri_Common_VO_Directory_AreaList_AreaListVO();
	        if($VO->getAreaID() != null){
	            $areaModel = Mage::getModel(Margshri_Common_VO_Directory_AreaList_AreaListVO::$modelName);
	            $areaDataObj = $areaModel->getResource()->getByID($VO->getAreaID());
	            if($areaDataObj !== false){
	                $areaDTO = new Margshri_Common_VO_Directory_AreaList_AreaListVO();
	                $areaVO = Margshri_Common_Helper_Utility::callInstanceFunction($areaDTO, $areaDataObj);
	            }
	        }
	        $option[$VO->getID()]= $VO->getName() . " - " . $VO->getMobileNumber1() . " - " . $VO->getAddress() . " - " . $areaVO->getValue();
	    }
	    return 	$option;
	}
	
	
	public function getGridOptions(){
	    $list = $this->getList();
	    $option = array();
	    
	    foreach($list as $row){
	        $DTO = new Margshri_Common_VO_User_User_UserVO();
	        /* @var $VO Margshri_Common_VO_User_User_UserVO */
	        $VO = Margshri_Common_Helper_Utility::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getName() . "(" .$VO->getID(). ")";
	    }
	    return 	$option;
	}
	
	public function getActiveList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("StatusID =?", Margshri_Common_VO_Status_StatusVO::$ACTIVE)
	    ->order("Name");
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	public function getActiveOptions(){
	    $list = $this->getActiveList();
	    $option = array();
	    
	    foreach($list as $row){
	        $DTO = new Margshri_Common_VO_User_User_UserVO();
	        /* @var $VO Margshri_Common_VO_User_User_UserVO */
	        $VO = Margshri_Common_Helper_Utility::callInstanceFunction($DTO, $row);
	        
	        $areaVO = new Margshri_Common_VO_Directory_AreaList_AreaListVO();
	        $cityVO = new Margshri_Common_VO_Directory_CityList_CityListVO();
	        if($VO->getAreaID() != null){
	            $areaModel = Mage::getModel(Margshri_Common_VO_Directory_AreaList_AreaListVO::$modelName);
	            $areaDataObj = $areaModel->getResource()->getByID($VO->getAreaID());
	            if($areaDataObj !== false){
	                $areaDTO = new Margshri_Common_VO_Directory_AreaList_AreaListVO();
	                $areaVO = Margshri_Common_Helper_Utility::callInstanceFunction($areaDTO, $areaDataObj);
	                
	                $cityModel = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
	                $cityDataObj = $cityModel->getResource()->getByID($areaVO->getCityID());
	                if($cityDataObj !== false){
	                    $cityDTO = new Margshri_Common_VO_Directory_CityList_CityListVO();
	                    $cityVO = Margshri_Common_Helper_Utility::callInstanceFunction($cityDTO, $cityDataObj);
	                }
	            }
	        }
	        $option[$VO->getID()] =  $VO->getName() . " (". $VO->getID() .") - " . $VO->getFatherName() . " - " . $VO->getMobileNumber1() . " - " . $VO->getAddress() . " - " . $areaVO->getValue() . " - " . $cityVO->getValue();
	    }
	    return 	$option;
	}
	 
	public function getBloodDonorList(Margshri_Common_VO_User_User_UserVO $userVO){
	    $read = $this->_getReadAdapter();
	    $select = $read->select()->from(array("user"=>$this->getMainTable()));
	    $select->joinLeft(array("area"=>$this->getTable(Margshri_Common_VO_Directory_AreaList_AreaListVO::$tableAlias)), "area.ID=user.AreaID", array("CityID"=>"area.CityID"));
	    $select->where("user.StatusID =?", Margshri_Common_VO_Status_StatusVO::$ACTIVE);
	    
	    if($userVO->getBloodGroupID() != null){
	        $select->where("user.BloodGroupID =?", $userVO->getBloodGroupID());
	    }
	    
	    if($userVO->getIsStpEligible() != null){
	        $select->where("user.IsStpEligible =?", $userVO->getIsStpEligible());
	    }
	    
	    if($userVO->getCityID() != null){
	        $select->where("area.CityID =?", $userVO->getCityID());
	    }
	    
	    $select->where(new Zend_Db_Expr(" user.BloodGroupID is not null "));
	    $select->where(new Zend_Db_Expr(" user.MobileNumber1 is not null "));
	    
	    $select->order("user.Name");
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
	
	public function saveDB(Margshri_Common_VO_User_User_UserVO $userVO, Margshri_Common_VO_ResponseVO $responseVO){
	
	    try{
    	    
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$userDTO = new Margshri_Common_VO_User_User_UserVO();
    		
    		$newUserDataObj = $this->getByNameAndMobileNumber($userVO->getName(), $userVO->getMobileNumber1());
    		if($userVO->getID() > 0 ){
    			
    		    if($newUserDataObj !== false){
    		        $newUserDTO = new Margshri_Common_VO_User_User_UserVO();
    		        /* @var $newUserVO Margshri_Common_VO_User_User_UserVO */
    		        $newUserVO = Margshri_Common_Helper_Utility::callInstanceFunction($newUserDTO, $newUserDataObj);
    		        
    		        if($userVO->getID() != $newUserVO->getID()){
    		            
    		        }
    		    }
    		    
    		    $rowSet = $userDTO->find($userVO->getID());
    			$row    = $rowSet['_data'];
    			
    			$userVO->setUpdatedAt($serverDate);
    			$userVO->setUpdatedBy($userID);
    			
    		}else{
    		    $row = $userDTO->fetchNew();
    			$userVO->setCreatedAt($serverDate);
    			$userVO->setCreatedBy($userID);
    			$userVO->setUpdatedAt($serverDate);
    			$userVO->setUpdatedBy($userID);
    		}
    		
    		foreach($userVO->getDataArray() as $key=>$value){
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