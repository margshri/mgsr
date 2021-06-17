<?php
class Margshri_WebPortal_Model_Mysql4_Master_Table_Table extends Mage_Core_Model_Mysql4_Abstract{

	protected function _construct()
	{
		$this->_init('webportal/apctwebtable', 'ID');
	}
	
	public function getList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable());
		//->order("Code Asc");
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getAscList(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->order("FileName Asc");
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getOrderList($column, $order){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->order(" " .$column. " " . $order . " ");
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	public function getListForSearch(){
		$read = $this->_getReadAdapter();
		$select  = $read->select()
		->from($this->getMainTable())
		->where("StatusID =?", Margshri_WebPortal_VO_StatusVO::$ACTIVE)
		->where("UseInSearch =?", 1)
		->order("TableTypeID Asc");
		$rowSet =  $read->fetchAll($select);
		return $rowSet;
	}
	
	
	public function getOptions(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $row){
			$DTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= $VO->getValue();
		}
		return 	$option;
	}
	
	
	public function getOptionsForGrid(){
		$list = $this->getAscList();
		$option = array();
	
		foreach($list as $row){
			$DTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= $VO->getFileName();
		}
		return 	$option;
	}
	
	public function getOptions1(){
		$list = $this->getList();
		$option = array();
	
		foreach($list as $row){
			$DTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
			$VO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
			$option[$VO->getID()]= array("Value"=>$VO->getValue(), "Code"=>$VO->getCode());
		}
		return 	$option;
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
	
	
	
	public function saveDB(Margshri_WebPortal_VO_Master_Table_TableVO $tableVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE
		$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
	
		if($tableVO->getID() > 0){
			
			$tableDataObj = $this->getByCode($tableVO->getCode());
			if($tableDataObj !== false){
				
				$newTableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
				/* @var $newTableVO Margshri_WebPortal_VO_Master_Table_TableVO */
				$newTableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newTableDTO, $tableDataObj);
				
				if($tableVO->getID() != $newTableVO->getID()){
					$response['status']  = 'ERROR';
					$response['message'] = 'Duplicate Code';
					return $response;
				}	 
			}
			
			$rowSet = $tableDTO->find( $tableVO->getID() );
			$row    = $rowSet['_data'];
			
			$tableVO->setUpdatedAt($serverDate);
			$tableVO->setUpdatedBy($userID);
		}else{
			
			$tableDataObj = $this->getByCode($tableVO->getCode());
			if($tableDataObj !== false){
				$response['status']  = 'ERROR';
				$response['message'] = 'Duplicate Code';
				return $response;
			}
			
			$row = $tableDTO->fetchNew();
			$tableVO->setCreatedAt($serverDate);
			$tableVO->setCreatedBy($userID);
			$tableVO->setUpdatedAt($serverDate);
			$tableVO->setUpdatedBy($userID);
		}
	
		foreach($tableVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}