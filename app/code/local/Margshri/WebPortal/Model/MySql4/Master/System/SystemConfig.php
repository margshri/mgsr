<?php
class Margshri_WebPortal_Model_Mysql4_Master_System_SystemConfig extends Mage_Core_Model_Mysql4_Abstract{

	
	protected function _construct()
	{
		$this->_init('webportal/apctwebsystemconfig', 'ID');
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
			/* @var $VO Margshri_WebPortal_VO_Master_System_SystemConfigVO */
			$DTO = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= $VO->getSystemName();
		}
		return 	$option;
	}
	
	
	public function getByID($configID){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ID =?', $configID);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getByConfigCode($configCode){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where('ConfigCode =?', $configCode);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getConfigValueByConfigCode($configCode){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable(), array("ConfigValue"))
		->where('ConfigCode =?', $configCode);
		$rowSet =  $read->fetchRow($select);
		return $rowSet['ConfigValue'];
	}
	
	
	public function saveDB(Margshri_WebPortal_VO_Master_System_SystemConfigVO $systemConfigVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE
		$systemConfigDTO = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
	
		if($systemConfigVO->getID() > 0){
				
			$systemConfigDataObj = $this->getByConfigCode($systemConfigVO->getConfigCode());
			if($systemConfigDataObj !== false){
				$newSystemConfigDTO = new Margshri_WebPortal_VO_Master_System_SystemConfigVO();
				/*  @var $newSystemConfigVO  Margshri_WebPortal_VO_Master_System_SystemConfigVO */
				$newSystemConfigVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newSystemConfigDTO, $systemConfigDataObj);
	
				if($newSystemConfigVO->getID() != $systemConfigVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Config Code Already Exist';
					return $response;
				}
			}
				
				
				
			$rowSet = $systemConfigDTO->find($systemConfigVO->getID());
			$row = $rowSet['_data'];
				
			$systemConfigVO->setUpdatedAt($serverDate);
			$systemConfigVO->setUpdatedBy($userID);
		}else{
				
			$systemConfigDataObj = $this->getByConfigCode($systemConfigVO->getConfigCode());
			if($systemConfigDataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Config Code Already Exist';
				return $response;
			}
				
			$row = $systemConfigDTO->fetchNew();
				
			$systemConfigVO->setCreatedAt($serverDate);
			$systemConfigVO->setCreatedBy($userID);
			$systemConfigVO->setUpdatedAt($serverDate);
			$systemConfigVO->setUpdatedBy($userID);
				
		}
	
		foreach($systemConfigVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}