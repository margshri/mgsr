<?php
class Margshri_WebPortal_Model_Mysql4_Master_Right_Bid extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebbid', 'ID');
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
		->from($this->getMainTable());
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getOptions(){
		$dataObjs = $this->getList();
		$options = array();
	
		foreach($dataObjs as $dataObj){
			$DTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
			$options[$VO->getID()]= $VO->getBidName();
		}
		return 	$options;
	}
	

	public function getActiveList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_Master_Right_BidStatusVO::$TO_BE_OPEN);
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getActiveRecord(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getCurrentBid(){
		$todayDate = date("Y-m-d", Mage::getModel('core/date')->timestamp(time()));
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE)
		->where("BiddingDate =?", $todayDate);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	
	
	public function getActiveOptions(){
		$dataObjs = $this->getActiveList();
		$options = array();
	
		foreach($dataObjs as $dataObj){
			$DTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
			$options[$VO->getID()]= $VO->getBidName();
		}
		return 	$options;
	}
	
	public function getByBidCode($BidCode){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("BidCode =?", $BidCode);
		$rowSet =  $read->fetchRow($select);
		return $rowSet;
	}
	 
	
	public function saveDB(Margshri_WebPortal_VO_Master_Right_BidVO $bidVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE 
		$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
	
		if($bidVO->getID() > 0){
			
			$dataObj = $this->getByBidCode($bidVO->getBidCode());
			
			if($dataObj !== false){
				$newBidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
				/* @var $newBidVO Margshri_WebPortal_VO_Master_Right_BidVO */
				$newBidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newBidDTO, $dataObj);
				
				if($bidVO->getID() != $newBidVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Bid Code !';
					return $response;
				}
			}
			
			
			$rowSet = $bidDTO->find( $bidVO->getID());
			$row    = $rowSet['_data'];
			
			$bidVO->setUpdatedAt($serverDate);
			$bidVO->setUpdatedBy($userID);
		}else{
			
			$dataObj = $this->getByBidCode($bidVO->getBidCode());
			
			if($dataObj !== false){
				
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Table Code !';
				return $response;
			}	
			
			$row = $bidDTO->fetchNew();
			
			$bidVO->setCreatedAt($serverDate);
			$bidVO->setCreatedBy($userID);
			$bidVO->setUpdatedAt($serverDate);
			$bidVO->setUpdatedBy($userID);
		}
	
		foreach($bidVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
	
	
	
	public function frontendSaveDB(Margshri_WebPortal_VO_Master_Right_BidVO $bidVO){
	
		$response = array();
		$userID = 1;
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
		// INSERT OR UPDATE
		$bidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
	
		if($bidVO->getID() > 0){
				
			$dataObj = $this->getByBidCode($bidVO->getBidCode());
				
			if($dataObj !== false){
				$newBidDTO = new Margshri_WebPortal_VO_Master_Right_BidVO();
				/* @var $newBidVO Margshri_WebPortal_VO_Master_Right_BidVO */
				$newBidVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newBidDTO, $dataObj);
	
				if($bidVO->getID() != $newBidVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Bid Code !';
					return $response;
				}
			}
				
				
			$rowSet = $bidDTO->find( $bidVO->getID());
			$row    = $rowSet['_data'];
				
			$bidVO->setUpdatedAt($serverDate);
			$bidVO->setUpdatedBy($userID);
		}else{
				
			$dataObj = $this->getByBidCode($bidVO->getBidCode());
				
			if($dataObj !== false){
	
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Table Code !';
				return $response;
			}
				
			$row = $bidDTO->fetchNew();
				
			$bidVO->setCreatedAt($serverDate);
			$bidVO->setCreatedBy($userID);
			$bidVO->setUpdatedAt($serverDate);
			$bidVO->setUpdatedBy($userID);
		}
	
		foreach($bidVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}