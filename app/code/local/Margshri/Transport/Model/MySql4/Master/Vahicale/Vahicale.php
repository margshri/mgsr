<?php
class Margshri_Transport_Model_Mysql4_Master_Vahicale_Vahicale extends Mage_Core_Model_Mysql4_Abstract{
	
	protected function _construct(){
	    $this->_init(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$tableAlias, Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$primaryKey);
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
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
	        $VO  = Margshri_Common_Helper_Utility::setVO($DTO, $dataObj);
	        $options[$VO->getID()]= $VO->getVahicaleNumber();
	    }
	    return 	$options;
	}
	
	
	public function getActiveList(){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("StatusID =?", Margshri_Common_VO_Status_StatusVO::$ACTIVE);
	    $rowSet =  $read->fetchAll($select);
	    return $rowSet;
	}
	
	
	public function getActiveOptions(){
	    $dataObjs = $this->getActiveList();
	    $options = array();
	    
	    foreach($dataObjs as $dataObj){
	        $DTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
	        /* @var $VO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
	        $VO  = Margshri_Common_Helper_Utility::setVO($DTO, $dataObj);
	        $options[$VO->getID()]= $VO->getVahicaleNumber();
	    }
	    return 	$options;
	}
	
	
	
	public function getByVahicaleNumber($vahicaleNumber){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where("VahicaleNumber =?", $vahicaleNumber);
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	public function getByVOCheckDuplicate(Margshri_Transport_VO_Master_Vahicale_VahicaleVO $vahicaleVO){
	    $read = $this->_getReadAdapter();
	    $select  = $read->select()
	    ->from($this->getMainTable())
	    ->where(new Zend_Db_Expr(" REPLACE(`VahicaleNumber`, ' ', '') = '" . $vahicaleVO->getVahicaleNumber() . "' ") );
	    $rowSet =  $read->fetchRow($select);
	    return $rowSet;
	}
	
	
	
	public function saveDB(Margshri_Transport_VO_Master_Vahicale_VahicaleVO $vahicaleVO){
	
	    try{
	        $responseVO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
    		$userID = Mage::getSingleton('admin/session')->getUser()->getId();
    		$serverDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
    		
    		$vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
    		
    		$newVahicaleDataObj = $this->getByVOCheckDuplicate($vahicaleVO);
    		if($vahicaleVO->getID() > 0 ){
    		    
    		    if($newVahicaleDataObj !== false){
    		        $newVahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
    		        /* @var $newVahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
    		        $newVahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($newVahicaleDTO, $newVahicaleDataObj);
    		        
    		        if($vahicaleVO->getID() != $newVahicaleVO->getID()){
    		            Mage::throwException("Duplicate Entry!");
    		        }
    		    }
    		    
    		    $rowSet = $vahicaleDTO->find($vahicaleVO->getID());
    			$row    = $rowSet['_data'];
    			
    			$vahicaleVO->setUpdatedAt($serverDate);
    			$vahicaleVO->setUpdatedBy($userID);
    			
    		}else{
    		    
		        if($newVahicaleDataObj !== false){
		            Mage::throwException("Duplicate Entry!");
		        }
    		    
    		    $row = $vahicaleDTO->fetchNew();
    		    $vahicaleVO->setCreatedAt($serverDate);
    		    $vahicaleVO->setCreatedBy($userID);
    		    $vahicaleVO->setUpdatedAt($serverDate);
    		    $vahicaleVO->setUpdatedBy($userID);
    		}
    		
    		foreach($vahicaleVO->getDataArray() as $key=>$value){
    			$row[$key] = $value;
    		}
    		$isSaved = $row->save();
			
		    $responseData = array();  
    		if($isSaved){
    			$responseVO->setSuccessMessage('Successfully Saved !');
    			$responseData['VahicaleID'] = $row['ID'];
    			$responseVO->setResponseData("ResponseData", $responseData);
    		}else{
    			$responseVO->setErrorMessage('Could not Saved !');
    		}
    		
	    } catch (Exception $e) {
	        $responseVO->setErrorMessage($e->getMessage());
	    }
		return $responseVO;
	
	}
	
	 
}