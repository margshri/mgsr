<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type7_News_News extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebnews', 'ID');
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
	
	
	public function getAllActiveRecord(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('StatusID =?', Margshri_WebPortal_VO_StatusVO::$ACTIVE)
		->order('ID desc');
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO $newsVO, $imageFileObj=null, $personImageFileObj=null, $person2ImageFileObj=null){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		if($imageFileObj != null){
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$newsVO->setImage('/web_portal/frontend/news/'.$newsVO->getCode().'.'.$ext);
		}
		 
		if($personImageFileObj != null){
			$ext = substr(strrchr($personImageFileObj["name"], '.'), 1);
			$newsVO->setPersonImage('/web_portal/frontend/news/'.$newsVO->getCode().'_Person.'.$ext);
		}
		
		if($person2ImageFileObj != null){
			$ext = substr(strrchr($person2ImageFileObj["name"], '.'), 1);
			$newsVO->setPerson2Image('/web_portal/frontend/news/'.$newsVO->getCode().'_Person2.'.$ext);
		}
		
		
		// INSERT OR UPDATE 
		$newsDTO = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();
	
		if($newsVO->getID() > 0){
			
			$dataObj = $this->getByCode($newsVO->getCode());
			
			if($dataObj !== false){
				$newNewsDTO = new Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO();
				/*  @var $newNewsVO  Margshri_WebPortal_VO_Center_Content_Type7_News_NewsVO */
				$newNewsVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newNewsDTO, $dataObj);
				
				if($newNewsVO->getID() != $newsVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			
			$rowSet = $newsDTO->find( $newsVO->getID() );
			$row    = $rowSet['_data'];
			
			$newsVO->setUpdatedAt($serverDate);
			$newsVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByCode($newsVO->getCode());
				
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			
			
			$row = $newsDTO->fetchNew();
			
			$newsVO->setCreatedAt($serverDate);
			$newsVO->setCreatedBy($userID);
			$newsVO->setUpdatedAt($serverDate);
			$newsVO->setUpdatedBy($userID);
			
		}
	
		foreach($newsVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		// SAVE IMAGE FILE
		if($imageFileObj != null){
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
			
			$pa = $helper->getServerPath();
			
			$res = move_uploaded_file($imageFileObj["tmp_name"], $helper->getServerPath() . '/media/web_portal/frontend/news/' . $newsVO->getCode().'.'.$ext);
		}
		
		
		// SAVE Person IMAGE FILE
		if($personImageFileObj != null){
			$ext = substr(strrchr($personImageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
				
			$pa = $helper->getServerPath();
				
			$res = move_uploaded_file($personImageFileObj["tmp_name"], $helper->getServerPath() . '/media/web_portal/frontend/news/' . $newsVO->getCode().'_Person.'.$ext);
		}
		
		
		// SAVE Person2 IMAGE FILE
		if($person2ImageFileObj != null){
			$ext = substr(strrchr($person2ImageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
		
			$pa = $helper->getServerPath();
		
			$res = move_uploaded_file($person2ImageFileObj["tmp_name"], $helper->getServerPath() . '/media/web_portal/frontend/news/' . $newsVO->getCode().'_Person2.'.$ext);
		}
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}
