<?php
class Yes_Master_Model_Mysql4_UserOffice extends Mage_Core_Model_Mysql4_Abstract
{
    public $dataResult = array();    
    protected function _construct()
    {
        $this->_init('yesmaster/useroffice', 'user_id');
    }
    
    
    public function loadData(Yes_Master_Model_UserOffice $object, $user_id)
    {
		
    	
    	$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
        $sql = "select au.user_id, au.firstname, au.lastname, au.username  , of.OfficeName , of.OfficeID from {$this->getTable('yesmaster/useroffice')}  au left join {$this->getTable('yesmaster/offices')} of on au.OfficeId = of.OfficeId where  user_id={$user_id}" ;  
      
        $stmnt = $con->prepare($sql);
        $stmnt->execute();
        $recordSet  = $stmnt->fetchAll();
        foreach($recordSet as $row)
        {
        	$data =$row;
        }        
        if ($data) {
            $object->setData($data);
        }

        $this->_afterLoad($object);

        return $this;
    }
    
    public function getUserOffice(Yes_Master_Model_UserOffice $object, $cols , $whereClause='' , $orderby ='user_id asc' , $limit =null)
    {
    
    	$con = Mage::getSingleton('core/resource')->getConnection('default_setup');
        $cols = implode(",", $cols);
        $sql = " select {$cols} from {$this->getTable('yesmaster/useroffice')}  au left join {$this->getTable('yesmaster/offices')} of on au.OfficeID = of.OfficeID where {$whereClause} order by {$orderby}" ;  
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
    
     
    public function insertUpdateUserOffice($request )
    {
            try {
                    $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
                    
                    $userId = Mage::getSingleton('admin/session')->getUser()->getId();
                    $user_id=$request['user_id'];
                    $officeId=$request['OfficeID'];
                    
                    $con->beginTransaction();
                   
                        $sql = "update {$this->getTable('yesmaster/useroffice')} set  OfficeID= :OfficeID  , reportingOffices=:reportingOffices  where user_id= '{$user_id}'";
                        $stmnt = $con->prepare($sql);
                        $stmnt->bindParam(':OfficeID'  , $request['OfficeID']);
                        $stmnt->bindParam(':reportingOffices'  , $request['reportingOffices']);
                        
                        
                        $stmnt->execute();
                    
                         $con->commit();
                        
                               $response['message']='UserOffice successfully updated ';
                               $response['user_id'] = $user_id;
                               $response['status'] = 'Saved';
                    
            } catch (Exception $e) {
                        $con->rollBack();
                        $response['message']= "Error: "  . $e->getMessage();
                        $response['status'] = 'Error';      
            }                
                     $con = null;
                     return $response;
    }

    
    public function isUserOfficeSale($userName)
    {
                $response ="";
        try {
                $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
                       
                $sql = "Select posSaleId from {$this->getTable('springompos/posSaleAdminUser')}  where firstName = {$firstName} limit 1" ;
                 
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
    
    
    public function deleteUserOffice($userName)
    {
                   try {
                            $con = Mage::getSingleton('core/resource')->getConnection('default_setup');
                         $con->beginTransaction();
                            $sql = "delete from {$this->getTable('yesmaster/adminUser')} Where userName = {$userName} ";
                            $stmnt = $con->prepare($sql);
                            $stmnt->execute();
                         $con->commit();                         
                            $response['status']="DELETED";
                     }catch (Exception $e) {
                        $con->rollBack();
                        $response['status']= "Error: "  . $e->getMessage();      
                     }                
                     $con = null;
                     return $response;
            }
    
  private function isDuplicate($request, $con)
  {
  	 $sql = "";
  	if($request['user_id'] != ''){
  		$user_id= $request['user_id'];
  		$userName= $request['username'];
  		$sql ="select user_id from {$this->getTable('yesmaster/useroffice')}  where user_id != {$user_id} and username = '{$userName}' ";
  	 } else {
        $userName= $request['username'];
        $sql ="select username from {$this->getTable('yesmaster/useroffice')}  where  username = '{$userName}' ";
  	 	
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
            
 }

