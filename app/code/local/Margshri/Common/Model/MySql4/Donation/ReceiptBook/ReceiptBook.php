<?php
class Margshri_Common_Model_Mysql4_Donation_ReceiptBook_ReceiptBook extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO::$tableAlias, Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO::$primaryKey);
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
	
	
	
// 	public function getOptions(){
// 	    $list = $this->getList();
// 	    $option = array();
	    
// 	    foreach($list as $row){
// 	        $DTO = new Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO();
// 	        /* @var $VO Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO */ 
// 	        $VO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
// 	        $option[$VO->getID()]= $VO->getBookName();
// 	    }
// 	    return 	$option;
// 	}
	
	
	public function getOptions(){
	    $list = $this->getList();
	    $option = array();
	    
	    $adminUserID = Mage::getSingleton('admin/session')->getUser()->getId();
	    
	    
	    $userOfficeModel = Mage::getModel('webportal/Master_Office_UserOffice_UserOffice');
	    $userOfficeDataObj = $userOfficeModel->getResource()->getByAdminUserID($adminUserID);
	    $userOfficeVO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
	    if($userOfficeDataObj != null){
    	    $userOfficeDTO = new Margshri_WebPortal_VO_Master_Office_UserOfficeVO();
    	    $userOfficeVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($userOfficeDTO, $userOfficeDataObj);
	    }
	    
	    
	    foreach($list as $row){
	        $DTO = new Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO();
	        /* @var $VO Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO */
	        $VO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
	        if($adminUserID != 1){
	            if($VO->getOfficeID() == $userOfficeVO->getOfficeID()){
	                $option[$VO->getID()]= $VO->getBookName();
	            }
	        }else{
	            $option[$VO->getID()]= $VO->getBookName();
	        }
	        
	    }
	    return 	$option;
	}
	
	
	
	public function getOpenList(){
	    $openStatusID = 1;
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("StatusID =?", $openStatusID);
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	public function getOpenOptions(){
	    $list = $this->getOpenList();
	    $option = array();
	    
	    foreach($list as $row){
	        $DTO = new Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO();
	        /* @var $VO Margshri_Common_VO_Donation_ReceiptBook_ReceiptBookVO */
	        $VO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($DTO, $row);
	        $option[$VO->getID()]= $VO->getBookName();
	    }
	    return 	$option;
	}
	
	
	
	
	
}