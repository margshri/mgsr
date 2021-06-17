<?php
class Margshri_Common_Model_Mysql4_Directory_CityList_CityList extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Directory_CityList_CityListVO::$tableAlias, Margshri_Common_VO_Directory_CityList_CityListVO::$primaryKey);
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
		->where("StatusID =?", 1);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveOptions(){
		$activeAreaList = $this->getActiveList();
		$activeAreaOption = array();
	
		foreach($activeAreaList as $list){
		    $activeAreaOption[$list["ID"]]= array("Name"=>$list["Value"], "DistrictID"=>$list["DistrictID"] );
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
	
	public function saveDB(Margshri_Common_VO_Directory_CityList_CityListVO $cityListVO, Margshri_Common_VO_ResponseVO $responseVO){
	    
	    try{
	        
	        $userID = Mage::getSingleton('admin/session')->getUser()->getId();
	        $serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	        
	        $cityListDTO = new Margshri_Common_VO_Directory_CityList_CityListVO();
	        
	        $newCityListDataObj = $this->getByCode($cityListVO->getCode());
	        if($cityListVO->getID() > 0 ){
	            
	            if($newCityListDataObj !== false){
	                $newCityListDTO = new Margshri_Common_VO_Directory_CityList_CityListVO();
	                /* @var $newCityListVO Margshri_Common_VO_Directory_CityList_CityListVO */
	                $newCityListVO = Margshri_Common_Helper_Utility::callInstanceFunction($newCityListDTO, $newCityListDataObj);
	                
	                if($newCityListVO->getID() != $cityListVO->getID()){
	                    Mage::throwException("Duplicate City Code");
	                }
	            }
	            
	            
	            $rowSet = $cityListDTO->find($cityListVO->getID());
	            $row = $rowSet['_data'];
	            
	            $cityListVO->setUpdatedAt($serverDate);
	            $cityListVO->setUpdatedBy($userID);
	            
	        }else{
	            
	            if($newCityListDataObj !== false){
	                Mage::throwException("Duplicate City Code");
	            }
	            
	            $row = $cityListDTO->fetchNew();
	            $cityListVO->setCreatedAt($serverDate);
	            $cityListVO->setCreatedBy($userID);
	            $cityListVO->setUpdatedAt($serverDate);
	            $cityListVO->setUpdatedBy($userID);
	        }
	        
	        foreach($cityListVO->getDataArray() as $key=>$value){
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
