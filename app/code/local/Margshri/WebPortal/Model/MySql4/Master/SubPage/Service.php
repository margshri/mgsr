<?php
class Margshri_WebPortal_Model_Mysql4_Master_SubPage_Service extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebsubpageservice', 'ID');
	}
	 
	public function getByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	public function getActiveRecordByID($id){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("ID =?", $id)
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
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
	
	public function getActiveList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOptions(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $service){
			/* @var $serviceVO Margshri_WebPortal_VO_Master_SubPage_ServiceVO */
			$serviceDTO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
			$serviceVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($serviceDTO, $service);
			$option[$serviceVO->getID()]= $serviceVO->getValue();
		}
		return 	$option;
	}
	
	public function getActiveOptions(){
		$list = $this->getActiveList();
		$option = array();
	
		foreach($list as $service){
			/* @var $serviceVO Margshri_WebPortal_VO_Master_SubPage_ServiceVO */
			$serviceDTO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
			$serviceVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($serviceDTO, $service);
			$option[$serviceVO->getID()]= $serviceVO->getValue();
		}
		return 	$option;
	}
	
	public function getOptionsByEntityID($entityID){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $service){
			/* @var $serviceVO Margshri_WebPortal_VO_Master_SubPage_ServiceVO */
			$serviceDTO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
			$serviceVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($serviceDTO, $service);
			if($serviceVO->getEntityID() == $entityID){
				$option[$serviceVO->getID()]= $serviceVO->getValue();
			}	
		}
		return 	$option;
	}
	
	
	public function saveDB(Margshri_WebPortal_VO_Master_SubPage_ServiceVO $serviceVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		/* @var $subPageVO Margshri_WebPortal_VO_Master_SubPage_ServiceVO */
		$serviceDTO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
		if($serviceVO->getID() > 0){
			
			$serviceDataObj = $this->getByCode($serviceVO->getCode());
			
			if($serviceDataObj !== false){
				$newServiceDTO = new Margshri_WebPortal_VO_Master_SubPage_ServiceVO();
				/* @var $newServiceVO  Margshri_WebPortal_VO_Master_SubPage_ServiceVO */
				$newServiceVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newServiceDTO, $serviceDataObj);
				
				if($newServiceVO->getID() != $serviceVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Code !';
					return $response;
				}
			}
			
			$rowSet = $serviceDTO->find( $serviceVO->getID() );
			$row    = $rowSet['_data'];
			$serviceVO->setUpdatedAt($serverDate);
			$serviceVO->setUpdatedBy($userID);
		}else{
			$serviceDataObj = $this->getByCode($serviceVO->getCode());
				
			if($serviceDataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Code !';
				return $response;
			}
			
			$row = $serviceDTO->fetchNew();
			$serviceVO->setCreatedAt($serverDate);
			$serviceVO->setCreatedBy($userID);
			$serviceVO->setUpdatedAt($serverDate);
			$serviceVO->setUpdatedBy($userID);
		}
			
		foreach($serviceVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
				
		
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}