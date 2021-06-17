<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type7_Achivement_Achivement extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebachivement', 'ID');
	}

	
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}

	public function getByCode($code){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('Code =?', $code);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}	

	public function getByMobileNumber1($mobileNumber1){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('MobileNumber1 =?', $mobileNumber1);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO $achivementVO, $imageFileObj=null){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		if($imageFileObj != null){
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$achivementVO->setImage('/web_portal/frontend/achivement/'.$achivementVO->getCode().'.'.$ext);
		}
		 
		
		// INSERT OR UPDATE 
		$achivementDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();
	
		if($achivementVO->getID() > 0){
			
			$dataObj = $this->getByCode($achivementVO->getCode());
			
			if($dataObj !== false){
				$newAchivementDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO();
				/*  @var $newAchivementVO  Margshri_WebPortal_VO_Center_Content_Type7_Achivement_AchivementVO */
				$newAchivementVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newAchivementDTO, $dataObj);
				
				if($newAchivementVO->getID() != $achivementVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			
			$rowSet = $achivementDTO->find( $achivementVO->getID() );
			$row    = $rowSet['_data'];
			
			$achivementVO->setUpdatedAt($serverDate);
			$achivementVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByCode($achivementVO->getCode());
				
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			
			
			$row = $achivementDTO->fetchNew();
			
			$achivementVO->setCreatedAt($serverDate);
			$achivementVO->setCreatedBy($userID);
			$achivementVO->setUpdatedAt($serverDate);
			$achivementVO->setUpdatedBy($userID);
			
		}
	
		foreach($achivementVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		// SAVE IMAGE FILE
		if($imageFileObj != null){
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
			
			$pa = $helper->getServerPath();
			
			$res = move_uploaded_file($imageFileObj["tmp_name"], $helper->getServerPath() . '/media/web_portal/frontend/achivement/' . $achivementVO->getCode().'.'.$ext);
		}
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}