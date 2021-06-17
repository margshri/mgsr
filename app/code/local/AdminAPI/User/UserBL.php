<?php

class AdminAPI_User_UserBL
{
	public static function getUser(){
		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);



			if(!isset($jsonObj->userName)){
				$result =array("status"=>"fail",'error'=>'userName parameter not found');
				echo json_encode($result);
				return;
			}
		  
	 		$userModel = Mage::getModel('admin/user');
			$user =   $userModel->loadByUsername($jsonObj->userName)->getData();

			$userDO = array(); 
			if($user['user_id']){
				if(!Mage::helper('core')->validateHash( $jsonObj->password,$user['password'])){
						$message = "Invalid Password";					
				}
			}else{
				$message = "Invalid User Name";
			}		

			if($message =="" ){

			 		$model = Mage::getModel('swapp/Masters_Office_UserOffice');
					$userOffice=$model->getResource()->getOfficeByUserID($user['user_id']);

			 		$officeModel = Mage::getModel('swapp/Masters_Office_office');
					$office=$officeModel->getResource()->getByID($userOffice['OfficeID']);

					$mposid = $userOffice['MPOSId']	;

					
					$userDO['userId'] = $user['user_id']	;
					$userDO['userName'] = $user['firstname'] . ' ' . $user['lastname'];
					$userDO['mposid'] = $mposid;
					$userDO['officeTypeId'] = $office['OfficeTypeId'];
					$userDO['verticalTypeId'] = $office['VerticalTypeID'];
					$userDO['TINNo'] = $office['TINNo'];
	   				$result=array("status"=>"success" , 'data'=> $userDO );
			
			}else{
   				$result=array("status"=>"fail" , 'error'=>array($message ));
     	
				echo json_encode($result);
				exit(0);        	
			}
				echo json_encode($result);
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}
}

?>
