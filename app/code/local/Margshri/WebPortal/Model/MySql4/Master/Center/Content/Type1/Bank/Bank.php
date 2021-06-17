<?php
class Margshri_WebPortal_Model_Mysql4_Master_Center_Content_Type1_Bank_Bank extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct()
	{
		$this->_init('webportal/apctwebbank', 'ID');
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
		$option = array();
	
		foreach($dataObjs as $dataObj){
			if($dataObj["Code"] != null){
				$option[$dataObj["ID"]]= Mage::helper("webportal/Data")->camelCase($dataObj["Value"]) . " (" . strtoupper($dataObj["Code"]) . ")";
			}else{
				$option[$dataObj["ID"]]= Mage::helper("webportal/Data")->camelCase($dataObj["Value"]);
			}	
		}
		return 	$option;
	}
	
	public function getVOs(){
		$dataObjs = $this->getList();
		$VOs  = array();
		foreach ($dataObjs as $dataObj){
			$DTO  = new Margshri_WebPortal_VO_Master_Center_Content_Type1_Bank_BankVO();
			/* @var $VO Margshri_WebPortal_VO_Master_Center_Content_Type1_Bank_BankVO */
			$VO   = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $dataObj);
			$VO->setValue(Mage::helper("webportal/Data")->camelCase($VO->getValue()));
			$VO->setCode(strtoupper($VO->getCode()));
			$VOs[]= $VO;
		}	
		return $VOs;
	}
	
	 
	public function saveDB(Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO $branchVO){
	
		$response = array();
		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	
	
		// INSERT OR UPDATE 
		$branchDTO = new Margshri_WebPortal_VO_Center_Content_Type1_Bank_BranchVO();
	
		if($branchVO->getid() > 0){
			$rowSet = $branchDTO->find( $contentVO->getid() );
			$row    = $rowSet['_data'];
		}else{
			$row = $branchDTO->fetchNew();
		}
	
		foreach($branchVO->getDataArray() as $key=>$value){
			$row[$key] = $value;
		}
		$row->save();
	
		$response['status']  = 'SUCCESS';
		$response['message'] = 'Successfully Saved';
		return $response;
	
	}
}