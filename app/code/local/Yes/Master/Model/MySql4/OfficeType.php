<?php
class Yes_Master_Model_Mysql4_OfficeType extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
    	
    	$this->_init('yesmaster/officetype', 'OfficeTypeid');
    }
    
    public function getOfficeTypeById(Yes_Master_Model_OfficeType $officeTypeVO, $officeTypeId  ){
			$read = $this->_getReadAdapter();
        	 

	        $select = $read->select()
	        			    ->from($this->getMainTable())
	        				->where('OfficeTypeId=?',$officeTypeId );
	   	    $row=  $read->fetchRow($select);
 			         
        
	        if ($row) {
	            $officeTypeVO->setData($row);
	        }
	
	        $this->_afterLoad($officeTypeVO);
	
	        return $this;	      				       
     }

    public function getOfficeTypeList(Yes_Master_Model_OfficeType $officeTypeVO , $orderBy=null){
			$read = $this->_getReadAdapter();
        	 

	        $select = $read->select()
	        			    ->from($this->getMainTable());
	       if($orderBy!=null){
	       		$select->order($orderBy);
	       } 			    
	        				
	   	    $row=  $read->fetchAll($select);
 			         
        
	        if ($row) {
	            $officeTypeVO->setData($row);
	        }
	
	        $this->_afterLoad($officeTypeVO);
	
	        return $this;	      				       
     }
    
     
     
   public function saveDB( $post){
   		$officeTypeVO=  $this->getByCode($post['typeCode']);	
   	    if($officeTypeVO){
   	    	if($officeTypeVO['OfficeTypeId'] != $post['officeTypeId']) {
   	       		$response['status'] ='FAIL';
   	       		$response['message']='Type Code Already Exist';
   	       		return $response;
   	    	}
   	    }   
 		
   	    $userId = Mage::getSingleton('admin/session')->getUser()->getId();
	 	$createdAt=date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
	 	
   	    $officeTypevo = new Yes_Master_Model_VO_OfficeTypeVO($this->getMainTable());
   	    
   	    if($post['officeTypeId']>0){
   	    	$rowSet =$officeTypevo->find($post['officeTypeId']);
   	    	$row= $rowSet['_data'];
   	    	
   	    } else {
   	    	$row = $officeTypevo->fetchNew();
   	    }
   	   
 		$row[$officeTypevo->getTypeCode()]=$post['typeCode'];
 		$row[$officeTypevo->getTypeName()]=$post['typeName'];
 		$row[$officeTypevo->getCreatedAt()]= $createdAt;
 		$row[$officeTypevo->getCreatedBy()]=$userId;
   	    $row->save();
   	   	$response['status'] ='SUCCESS';
   	    $response['message']='Successfully Saved';
   	    return $response;
   	    
   }
   
   public function getByCode($typeCode) {
   	     $read = $this->_getReadAdapter();
   	     $select  = $read->select()
   	     				 ->from($this->getMainTable())
   	     				 ->where('TypeCode=?', $typeCode);
   	     $officeTypeVO=  $read->fetchRow($select);
   	     return $officeTypeVO;				 
   }
     
}