<?php
class Margshri_WebPortal_Model_Mysql4_Center_Content_Type1_Bank_ATM extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebbankatm', 'ID');
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
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO $atmVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$atmDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO();
	
		if($atmVO->getID() > 0){
			
			if($atmVO->getCode() != null){
				$dataObj = $this->getByCode($atmVO->getCode());
				if($dataObj !== false){
					$newATMDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO();
					// @var $newBranchVO  Margshri_WebPortal_VO_Center_Content_Type1_Bank_ATMVO 
					$newATMVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newATMDTO, $dataObj);
					
					if($newATMVO->getID() != $atmVO->getID()){
						$response['status']  = 'ERROR';
						$response['message'] = 'ATM Code Already Exist !';
						return $response;
					}
				}
			}	
			
			
			$rowSet = $atmDTO->find( $atmVO->getID() );
			$row    = $rowSet['_data'];
			
			$atmVO->setUpdatedAt($serverDate);
			$atmVO->setUpdatedBy($userID);
		}else{
			
			if($atmVO->getCode() != null){
				$dataObj = $this->getByCode($atmVO->getCode());
				if($dataObj !== false){
					$response['status']  = 'ERROR';
					$response['message'] = 'ATM Code Already Exist !';
					return $response;
				}
			}	
			
			
			
			$row = $atmDTO->fetchNew();
			
			$atmVO->setCreatedAt($serverDate);
			$atmVO->setCreatedBy($userID);
			$atmVO->setUpdatedAt($serverDate);
			$atmVO->setUpdatedBy($userID);
			
		}
	
		foreach($atmVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}