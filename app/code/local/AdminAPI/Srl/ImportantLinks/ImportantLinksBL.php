<?php

class AdminAPI_Srl_ImportantLinks_ImportantLinksBL
{
	public static function getAllActiveRecord(){
		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    
            $responseArr = array();
			
            $response1 = array();
            $response1['imageUrl'] = "";
            $response1['displayName'] = "record1";
            $response1['link'] = "www.google.co.in";
            $response1['description'] = "record1";
            
            $response2 = array();
            $response2['imageUrl'] = "";
            $response2['displayName'] = "record2";
            $response2['link'] = "www.google.co.in";
            $response2['description'] = "record2";
            
            $responseArr[] = $response1;
            $responseArr[] = $response2;
            $result=array("status"=>"success", 'message'=>array("successfully fetched"), 'dataList'=> $responseArr );
			
			 
			echo json_encode($result);
		}catch(Exception $e){
			$message="Please contact to administrator";
			$result=array("status"=>"fail", 'message'=>array($message), 'dataList'=>array());
			echo json_encode($result);
		}
		exit(0);

	}
}

?>
