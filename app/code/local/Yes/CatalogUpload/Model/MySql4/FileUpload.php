<?php
class Yes_CatalogUpload_Model_Mysql4_FileUpload extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('yescatalogupload/fileupload', 'UploadID');
    }
    
    
    public function saveDB($fileUploadVO)
    {
    	$newFileUploadVO = new Yes_VO_FileUpload_FileUploadVO();
    
    	if(  $fileUploadVO->getUploadID()>0){
    		$rowSet =$newFileUploadVO->find($fileUploadVO->getUploadID());
    		$row= $rowSet['_data'];
    	}  else {
	    	$row = $newFileUploadVO->fetchNew();
    	}	
    	
     	foreach($fileUploadVO->getDataArray() as $key=>$value){
    		$row[$key] = $value;
    	}
    	$row->save();
     	return $newFileUploadVO->getAdapter()->lastInsertId($this->getMainTable());
    }
    
    
    public function getOptionArray(){
    	
    	
    	$options = array();
    	$read = $this->_getReadAdapter();
    	$select = $read->select()
    	->from(array("fups" => $this->getTable("yescatalogupload/fileuploadstatus")) , array("StatusID"=>"statusID", "StatusName"=>"statusName") );
    	 
    	$recordSet= $read->fetchAll($select);
    	 
    	foreach($recordSet   as $row) {
    		$options[$row["StatusID"]] = Mage::helper('catalog')->__($row["StatusName"]);
    	}
    
    	return $options;
    }
    
}


