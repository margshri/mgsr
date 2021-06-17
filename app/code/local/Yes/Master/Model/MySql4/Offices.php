<?php
class Yes_Master_Model_Mysql4_Offices extends Mage_Core_Model_Mysql4_Abstract
{
    
    protected function _construct()
    {
        $this->_init('yesmaster/offices', 'OfficeID');
    }
    
    
    public function getOffices(Yes_Master_Model_Offices $object, $cols , $whereClause='' , $orderby ='OfficeID asc' , $limit=null)
    {
    	
    	
    	$whereClause = "OfficeCode";
        $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
        $cols = implode(",", $cols);
        $sql = " select {$cols} from {$this->getTable('yesmaster/offices')}  
                 where {$whereClause} order by {$orderby}" ;  
        if($limit != null){
                $sql .= " limit " . $limit;
        }
        
        
        $stmnt = $con->prepare($sql);
        $stmnt->execute();
        $data  = $stmnt->fetchAll();        
        
        if ($data) {
            $object->setData($data);
        }

        $this->_afterLoad($object);

        return $this;
    	
        
    	$select = $this->_getReadAdapter()->select()
            ->from($this->getTable('yesmaster/offices'), $cols)
            ->order( $orderby)
            ->where($whereClause);
        
        $data = $this->_getReadAdapter()->fetchAll($select);

        if ($data) {
            $object->setData($data);
        }

        $this->_afterLoad($object);

        return $this;
        
    }
    
    public function getOfficesWithState(Yes_Master_Model_Offices $object, $cols , $whereClause='' , $orderby ='OfficeID asc' , $limit =null)
    {

        $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
        $cols = implode(",", $cols);
        $sql = " select {$cols} from {$this->getTable('yesmaster/offices')}  of left join {$this->getTable('yesmaster/state')} st on of.stateId = st.stateId where {$whereClause} order by {$orderby}" ;  
        if($limit != null){
                $sql .= " limit " . $limit;
        }
        
        
        $stmnt = $con->prepare($sql);
        $stmnt->execute();
        $data  = $stmnt->fetchAll();        
        
        if ($data) {
            $object->setData($data);
        }

        $this->_afterLoad($object);

        return $this;
    }
    
    public function getOfficeIdForUser()
    {
    	
    	    $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
    	    $userId = Mage::getSingleton('admin/session')->getUser()->getId();
            $sql ="select OfficeID from admin_user where user_id ={$userId}";
            $officeId = 0;
            $stmnt = $con->prepare($sql);
            $stmnt->execute();
            $resultRows = $stmnt->fetchAll();
            
            foreach($resultRows as $resultRow){
                    $officeId = $resultRow['OfficeID'];
            }           
            return $officeId ;
    }
    
    public function getOfficeForUser()
    {	
    	
    	    $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
    	    $userId = Mage::getSingleton('admin/session')->getUser()->getId();
            $sql ="select au.OfficeID, ofc.OfficeTypeId from admin_user au inner join {$this->getTable('yesmaster/offices')} ofc on au.OfficeID = ofc.OfficeID where user_id ={$userId}";
            $officeId = 0;
            $stmnt = $con->prepare($sql);
            $stmnt->execute();
            $resultRows = $stmnt->fetchAll();
    	 
			return $resultRows;
             
    }
    
    
    public function getReportingOfficesForUser($userId)
    {
     		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
           // $userId = Mage::getSingleton('admin/session')->getUser()->getId();
            $sql ="select ReportingOffices from admin_user where user_id ={$userId}";
            $officeId = 0;
            $stmnt = $con->prepare($sql);
            $stmnt->execute();
            $resultRows = $stmnt->fetchAll();
            
            foreach($resultRows as $resultRow){
                    $reportingOffices = $resultRow['ReportingOffices'];
            }           
            
            return $reportingOffices ;
    }
    
		    public function insertUpdateOffice($post,$request /*, $terminal */)
		    {
		            try {
		                    $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
		                    
		                    $duplicate = $this->isDuplicate($request, $con);
		                    if($duplicate  === true){
		                            $con = null;
		                            $response['status'] = 'Duplicate';
		                            return $response;
		                    }
		                    $userId = Mage::getSingleton('admin/session')->getUser()->getId();
		                    $officeID=$request['officeID'];
		                    $createdAt=date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
		                    
		                    $con->beginTransaction();
		                    if($officeID != ''){
		                        $sql = "update {$this->getTable('yesmaster/offices')} set  officeCode = :officeCode , officeName=:officeName,   TINNo = :TINNo , oadd1 =:oadd1 , oadd2= :oadd2, oadd3=:oadd3,  oadd4 = :oadd4,  ophone =:ophone , stateId= :stateId ,   binAddressAbbreviation='{$request['binAddressAbbreviation']}' , binStacking = '{$post['binStacking']}' , ZoneId = {$post['zone']} , OfficeTypeId = {$post['officeType']}  where officeId= '{$officeID}'";
		                        $stmnt = $con->prepare($sql);
		                        $stmnt->bindParam(':officeCode' , $request['officeCode'] );
		                        $stmnt->bindParam(':officeName'  , $request['officeName']);
		                        $stmnt->bindParam(':oadd1'  , $request['oadd1']);
		                        $stmnt->bindParam(':oadd2'  , $request['oadd2']);
		                        $stmnt->bindParam(':oadd3'  , $request['oadd3']);
		                        $stmnt->bindParam(':oadd4'  , $request['oadd4']);
		                        $stmnt->bindParam(':ophone'  , $request['ophone']);                        
		                        $stmnt->bindParam(':stateId'  , $request['stateName']);
		                        $stmnt->bindParam(':TINNo'  , $request['tinno']);
		                        
		                        
		                        $stmnt->execute();
		                    } else{
		                        // bindParam(":var" , accept only variable not constant);
		                         
		                        
		                        $sql = "insert into  {$this->getTable('yesmaster/offices')} (officeCode , officeName , TINNo, oadd1, oadd2, oadd3, oadd4, ophone, stateId, binAddressAbbreviation, binStacking, ZoneId, OfficeTypeId, createdAt, createdBy )  
		                                       values (:officeCode, :officeName, :TINNo, :oadd1, :oadd2, :oadd3,  :oadd4, :ophone, :stateId , '{$request['binAddressAbbreviation']}',  {$post['binStacking']}, {$post['zone']}, {$post['officeType']},  :createdAt, {$userId} )";
		                       
								//echo $sql;
								//exit;
		                        
		                        $stmnt = $con->prepare($sql);
		                        $stmnt->bindParam(':officeCode' , $request['officeCode'] );
		                        $stmnt->bindParam(':officeName'  , $request['officeName']);
		                        $stmnt->bindParam(':oadd1'  , $request['oadd1']);
		                        $stmnt->bindParam(':oadd2'  , $request['oadd2']);
		                        $stmnt->bindParam(':oadd3'  , $request['oadd3']);
		                        $stmnt->bindParam(':oadd4'  , $request['oadd4']);
		                        $stmnt->bindParam(':ophone'  , $request['ophone']);                        
		                        $stmnt->bindParam(':stateId'  , $request['stateName']);
		                        $stmnt->bindParam(':TINNo'  , $request['tinno']);
		                        $stmnt->bindParam(':createdAt'  , $createdAt);
		                        $stmnt->execute();
		                        $officeID= $con->lastInsertId();
		                    }
		                    
		                    /* save officeActivity */
		                    if(key_exists('activityChk' , $post)){
		                    	//create array of user selected activities.
		                    	$activityDTO = $post['activityChk'];
		                    	
		                    	//an associative array to keep DTO and VO values
		                    	$activityDTOVO = array();
		                    	
		                    	//iterate $activityDTO and populate DTOVO array with value "C" i.e create in DB
		                    	foreach($activityDTO as $key =>$value){
		                    		$activityDTOVO[$value] = "C"; 
		                    	}
		                    	
		                    	//fetch offceActivityVOs for current office
		                    	$currOfficeId =$officeID ; 
		                    	$model = Mage::getModel('yesmaster/offices');
        						$model->getResource()->getOfficeActivity($model, $currOfficeId);
        						$officeActivityVOs = $model->getData() ;  
		                    	
        						//iterate $officeActivityVOs and populate DTOVO with value 'U' and 'I' 'U' stands Update , 'I stands In-active. If Acitivity found in DTOVO array then value will "U" else "I"
        						if(is_array($officeActivityVOs)) {
			        						foreach($officeActivityVOs as $key => $row){
			            							if( array_key_exists($row['ActivityId'], $activityDTOVO)){
			            									   $activityDTOVO[ $row['ActivityId'] ] = "U";
										            }else {
										            		   $activityDTOVO[ $row['ActivityId'] ] = "I";
										            }
									        }
        						}
								//update table officeactivity by iterate DTOVO array, if value is "C" then insert into table, "U" value not treating because not changed in any attributes, "I" update status with "inactive".        						
								$write = $this->_getWriteAdapter();
								$column =array('OfficeId' , 'ActivityId' , 'StatusId' , 'UpdatedAt');
						        foreach($activityDTOVO as $key => $status){
						        	if($status=="C"){
										$row =  array("0"=>array( $currOfficeId ,$key , StatusVO::$ACTIVE ,$createdAt));  						        		
						        		$write->insertArray( $this->getTable('yesmaster/officeactivity') ,  $column , $row );  
						        	}elseif($status=="I"){
						        		$where = $write->quoteInto('OfficeId = ?', $currOfficeId);
						        		$where .=  ' And ' . $write->quoteInto('ActivityId = ?', $key);
						        		$write->update($this->getTable('yesmaster/officeactivity') , array("StatusId"=>StatusVO::$INACTIVE , "UpdatedAt"=>$createdAt), $where );
						        	}elseif($status=="U"){
						        		$where = $write->quoteInto('OfficeId = ?', $currOfficeId);
						        		$where .=  ' And ' . $write->quoteInto('ActivityId = ?', $key);
						        		$write->update($this->getTable('yesmaster/officeactivity') , array("StatusId"=>StatusVO::$ACTIVE , "UpdatedAt"=>$createdAt), $where );
						        	} 
						        }
						        
 		                    	
		                    }
		                     
		                    /*
	                          // handle wms_officesTerminal
	                            if($request['officeID'] !=""){
	                                $sql = "delete from {$this->getTable('yesmaster/officesTerminal')}  where  officeId = {$officeID} ";
	                                $stmnt = $con->prepare($sql);  
			                        $stmnt->execute();
	                            }   
	                            if(count($terminal) >0){
	                            	  $sql="";
	                            	  foreach($terminal as $row){
						                        if ($row !=""){
						                                if($sql != ""){
						                                      $sql =  $sql .    " , " ;
						                                } else {
						                                	$sql = " values " ; 
						                                  }
						                                    $sql .=  " ( {$officeID},  {$row['bank']} , '{$row['mid']}', '{$row['tid']}' , '{$createdAt}' , {$userId})";
						                        }           
						              }
						              if($sql !=""){
						                          $stmnt = $con->prepare("Insert into {$this->getTable('yesmaster/officesTerminal')} (officeId,  bankId, mid, tid, createdAt, createdBy)  {$sql}");
						                          $stmnt->execute();                        
						              }
	                            }
		                      //end handle wms_officesTerminal
    						*/
		                      $con->commit();
		                        
		                        if($request['officeID'] != ''){
		                               $response['message']='Office successfully updated ';
		                        } else {
		                               $response['message']='Office successfully created ';
		                        }
		                               $response['officeID'] = $officeID;
		                               $response['status'] = 'Saved';
		                    
		            } catch (Exception $e) {
		                        $con->rollBack();
		                        $response['message']= "Error: "  . $e->getMessage();
		                        $response['status'] = 'Error';      
		            }                
		                     $con = null;
		                     return $response;
		    }


    
		  private function isDuplicate($request, $con)
		  {
		     $sql = "";
		    if($request['officeID'] != ''){
		        $officeID= $request['officeID'];
		        $officeCode = $request['officeCode'];
		        $sql ="select officeId from {$this->getTable('yesmaster/offices')}  where officeId != {$officeID} and officeCode = '{$officeCode}' ";
		     } else {
		        $officeCode= $request['officeCode'];
		        $sql ="select officeId from {$this->getTable('yesmaster/offices')}  where  officeCode = '{$officeCode}' ";
		        
		     }        
		    
		        $stmnt = $con->prepare($sql);
		        $stmnt->execute();
		        $data  = $stmnt->fetchAll();        
		        if(count($data)>0){
		              return  true;
		        } else {
		            return false;
		        }
		    
		  }
    
  
	    public function isOfficeSale($officeID)
	    {
	                $response ="";
	        try {
	                $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
	                       
	                $sql = "Select posSaleId from {$this->getTable('springompos/posSale')}  where officeId = {$officeID} limit 1" ;
	                 
	                $stmnt = $con->prepare($sql);
	                $stmnt->execute();
	                $result = $stmnt->fetchAll();
	                $response['status']='NOT FOUND';
	                if(count($result) >0){
	                        $response['status']='FOUND';    
	                }                
	                
	        } catch (Exception $e) {
	            $con->rollBack();
	            $response['status']='FAIL';     
	            $response['message']= "Error: "  . $e->getMessage();
	        }                
	             $con = null;
	             
	             return $response;
	        
	        
	    }
    		  

        public function deleteOffice($officeID)
        {
				try {
                            $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
                         $con->beginTransaction();
                            $sql = "delete from {$this->getTable('yesmaster/offices')} Where OfficeID = {$officeID} ";
                            $stmnt = $con->prepare($sql);
                            $stmnt->execute();
                            
                            /*
                            $sql = "delete from {$this->getTable('yesmaster/officesTerminal')} Where officeId = {$officeID} ";
                            $stmnt = $con->prepare($sql);
                            $stmnt->execute();
                            */
                            
                         $con->commit();                         
                            $response['status']="DELETED";
                     }catch (Exception $e) {
                        $con->rollBack();
                        $response['status']= "Error: "  . $e->getMessage();      
                     }                
                     $con = null;
                     return $response;
            }
      
    public function getOfficeTerminal($officeId)
    {
                $response =""; 
        try {
                $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
                $whereClause="";
                
                 
                $sql  = " Select bankId, mid, tid    
                            from {$this->getTable('yesmaster/officesTerminal')}  
                            where officeId = {$officeId}" ;
                $stmnt = $con->prepare($sql);
                $stmnt->execute();
                $response = $stmnt->fetchAll();
        } catch (Exception $e) {
            $con->rollBack();
        }                
             $con = null;
             
             return $response;
        
    }

	public function getOfficeById(Mage_Core_Model_Abstract $VO, $officeId  )
	{
		
			$read = $this->_getReadAdapter();
        	 

	        $select = $read->select()
	        			    ->from( array('op'=>$this->getMainTable() ) )
	        				->where('officeId=?',$officeId );
	   	    $row=  $read->fetchRow($select);
 			         
        
	        if ($row) {
	            $VO->setData($row);
	        }
	
	        $this->_afterLoad($VO);
	
	        return $this;	      				       
     }    

    public function getOfficesBy_Ids_OfficeType($officeIds,$officeTypeId)
    {
     	
    		$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
           // $userId = Mage::getSingleton('admin/session')->getUser()->getId();
            $sql ="select group_concat(officeId  SEPARATOR ',' ) officeId from {$this->getMainTable()} where officeId in ({$officeIds}) and officeTypeId in ({$officeTypeId}) ";
             
            $read = $this->_getReadAdapter();
            $officeId =       $read->fetchOne($sql);    
            return $officeId;
    }

    
    public function getOfficeActivity(Mage_Core_Model_Abstract $officeActivityVO , $currOfficeId =null , $status=null){
			$read = $this->_getReadAdapter();
        	 

	        $select = $read->select()
	        			    ->from($this->getTable('yesmaster/officeactivity'));
	       if($currOfficeId!=null){
	       		$select->where("OfficeId=?",$currOfficeId);
	       } 			    
	       if($status!=null){
	       		$select->where("StatusId=?",$status);
	       } 			    
	       
	       
 	   	    $row=  $read->fetchAll($select);
 			         
        
	        if ($row) {
	            $officeActivityVO->setData($row);
	        }
	
	        $this->_afterLoad($officeActivityVO);
	
	        return $this;	      				       
     }

     public function getBinStackValueById($officeId){
     	$read = $this->_getReadAdapter();
     	$sql = $read->select()
     				->from(array("ofc"=>$this->getMainTable()) , array("binStacking") )
     				->where("officeID=?", $officeId);
     	return $read->fetchOne($sql);			
     	
     }
     
     

	 
	public function getOptionArray(){
	    $options = array();
    	$read = $this->_getReadAdapter();
		$select = $read->select()
		    				   ->from(array("ofc" => $this->getTable("yesmaster/offices")) , array("OfficeId"=>"officeId", "OfficeName"=>"officeName") );
	//	    				   ->where("stor.status=1"); 
 		    				   
		$recordSet= $read->fetchAll($select);    				   
	    
        foreach($recordSet   as $row) {
            $options[$row["OfficeId"]] = Mage::helper('catalog')->__($row["OfficeName"]);
        }

        return $options;	
	}		    				     

	public function getOptionArrayByBase(){
		$model = Mage::getModel('yesmaster/systemConfig');
		$baseOfficeTypeId = $model->getResource()->getConfigValue($model, "entityId=".SystemConfigVO::$Office_TYPE_ID_OF_BASE);
		
	    $options = array();
    	$read = $this->_getReadAdapter();
		$select = $read->select()
		    				   ->from(array("ofc" => $this->getTable("yesmaster/offices")) , array("OfficeId"=>"officeId", "OfficeName"=>"officeName") )
		    				    ->where("ofc.officeTypeId=?", $baseOfficeTypeId); 
 		    				   
		$recordSet= $read->fetchAll($select);    				   
	    
        foreach($recordSet   as $row) {
            $options[$row["OfficeId"]] = Mage::helper('catalog')->__($row["OfficeName"]);
        }

        return $options;	
	}		    				     

    public function getOfficeByZone($officeIds,$zoneId)
    {
        
            $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
            $sql ="select group_concat(officeId  SEPARATOR ',' ) officeId from {$this->getMainTable()} where zoneId = {$zoneId} and officeId in ({$officeIds})  ";
             
            $read = $this->_getReadAdapter();
            $officeId =       $read->fetchOne($sql);    
            return $officeId;
    }
	
	
}


