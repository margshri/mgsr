<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type7_Event_Event extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebevent', 'ID');
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
	
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO $eventVO, $imageFileObj=null, $personImageFileObj=null, $person2ImageFileObj=null){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		if($imageFileObj != null){
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$eventVO->setImage('/web_portal/frontend/event/'.$eventVO->getCode().'.'.$ext);
		}

		if($personImageFileObj != null){
			$ext = substr(strrchr($personImageFileObj["name"], '.'), 1);
			$eventVO->setPersonImage('/web_portal/frontend/event/'.$eventVO->getCode().'_Person.'.$ext);
		}
		
		if($person2ImageFileObj != null){
			$ext = substr(strrchr($person2ImageFileObj["name"], '.'), 1);
			$eventVO->setPerson2Image('/web_portal/frontend/event/'.$eventVO->getCode().'_Person2.'.$ext);
		}
		
		
		// INSERT OR UPDATE 
		$eventDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
	
		if($eventVO->getID() > 0){
			
			$dataObj = $this->getByCode($eventVO->getCode());
			
			if($dataObj !== false){
				$newEventDTO = new Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO();
				/*  @var $newEventVO  Margshri_WebPortal_VO_Center_Content_Type7_Event_EventVO */
				$newEventVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newEventDTO, $dataObj);
				
				if($newEventVO->getID() != $eventVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Entry';
					return $response;
				}
			}
			
			$rowSet = $eventDTO->find( $eventVO->getID() );
			$row    = $rowSet['_data'];
			
			$eventVO->setUpdatedAt($serverDate);
			$eventVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByCode($eventVO->getCode());
				
			if($dataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Entry';
				return $response;
			}
			
			
			$row = $eventDTO->fetchNew();
			
			$eventVO->setCreatedAt($serverDate);
			$eventVO->setCreatedBy($userID);
			$eventVO->setUpdatedAt($serverDate);
			$eventVO->setUpdatedBy($userID);
			
		}
	
		foreach($eventVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		// SAVE IMAGE FILE
		if($imageFileObj != null){
			$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
			
			$pa = $helper->getServerPath();
			
			$res = move_uploaded_file($imageFileObj["tmp_name"], $helper->getServerPath() . '/media/web_portal/frontend/event/' . $eventVO->getCode().'.'.$ext);
		}
		
		
		// SAVE Person IMAGE FILE
		if($personImageFileObj != null){
			$ext = substr(strrchr($personImageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
		
			$pa = $helper->getServerPath();
		
			$res = move_uploaded_file($personImageFileObj["tmp_name"], $helper->getServerPath() . '/media/web_portal/frontend/event/' . $eventVO->getCode().'_Person.'.$ext);
		}
		
		
		// SAVE Person2 IMAGE FILE
		if($person2ImageFileObj != null){
			$ext = substr(strrchr($person2ImageFileObj["name"], '.'), 1);
			$helper = Mage::helper("margshri/Utility");
		
			$pa = $helper->getServerPath();
		
			$res = move_uploaded_file($person2ImageFileObj["tmp_name"], $helper->getServerPath() . '/media/web_portal/frontend/event/' . $eventVO->getCode().'_Person2.'.$ext);
		}
		
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}