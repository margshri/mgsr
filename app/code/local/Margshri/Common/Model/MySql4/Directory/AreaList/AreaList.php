<?php
class Margshri_Common_Model_Mysql4_Directory_AreaList_AreaList extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Directory_AreaList_AreaListVO::$tableAlias, Margshri_Common_VO_Directory_AreaList_AreaListVO::$primaryKey);
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
		$cityList = $this->getList();
		$cityOption = array();
	
		foreach($cityList as $list){
			$cityOption[$list["ID"]]= array("Name"=>$list["Value"], "DistrictID"=>$list["DistrictID"] );
		}
		return 	$cityOption;
	}
	
	public function getActiveList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", 1)
		->order("Value");
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveOptions(){
		$activeAreaList = $this->getActiveList();
		$activeAreaOption = array();
	
		foreach($activeAreaList as $list){
		    $activeAreaOption[$list["ID"]]= array("Name"=>$list["Value"], "CityID"=>$list["CityID"] );
		}
		return 	$activeAreaOption;
	}
	
	
	public function getGridOptions(){
		$cityList= $this->getList();
		$cityOption = array();
		
		foreach($cityList as $list){
			$cityOption[$list["ID"]]= $list["Value"];
		}
		return 	$cityOption;
	}
	
	public function getByDistrictID($districtID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("DistrictID =?", $districtID);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function saveDB(Margshri_Common_VO_Directory_AreaList_AreaListVO $areaListVO, Margshri_Common_VO_ResponseVO $responseVO){
	    
	    try{
	        
	        $userID = Mage::getSingleton('admin/session')->getUser()->getId();
	        $serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	        
	        $areaListDTO = new Margshri_Common_VO_Directory_AreaList_AreaListVO();
	        
	        $newAreaListDataObj = $this->getByCode($areaListVO->getCode());
	        if($areaListVO->getID() > 0 ){
	            
	            if($newAreaListDataObj !== false){
	                $newAreaListDTO = new Margshri_Common_VO_Directory_AreaList_AreaListVO();
                    /* @var $newAreaListVO Margshri_Common_VO_Directory_AreaList_AreaListVO */
	                $newAreaListVO = Margshri_Common_Helper_Utility::callInstanceFunction($newAreaListDTO, $newAreaListDataObj);
                    
	                if($areaListVO->getID() != $newAreaListVO->getID()){
                        Mage::throwException("Duplicate Area Code");
                    }
                }
	            
	            
                $rowSet = $areaListDTO->find($areaListVO->getID());
	            $row = $rowSet['_data'];
	            
	            $areaListVO->setUpdatedAt($serverDate);
	            $areaListVO->setUpdatedBy($userID);
	            
	        }else{
	            
	            if($newAreaListDataObj !== false){
                    Mage::throwException("Duplicate Area Code");
                }
	            
                $row = $areaListDTO->fetchNew();
                $areaListVO->setCreatedAt($serverDate);
                $areaListVO->setCreatedBy($userID);
                $areaListVO->setUpdatedAt($serverDate);
                $areaListVO->setUpdatedBy($userID);
	        }
	        
	        foreach($areaListVO->getDataArray() as $key=>$value){
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
