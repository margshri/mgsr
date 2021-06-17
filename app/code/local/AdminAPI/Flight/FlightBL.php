<?php

class AdminAPI_Flight_FlightBL
{
	public static function getFlightNoSalesInfo(){

		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);

			if(!isset($jsonObj->flightCode)){
				$result =array("status"=>"fail",'error'=>'Flight Code parameter not found');
				echo json_encode($result);
				return;
			}
			if(!isset($jsonObj->userId)){
				$result =array("status"=>"fail",'error'=>'User Id parameter not found');
				echo json_encode($result);
				return;
			}		  
			
			 
		    $flightDate=  date("Y-m-d", Mage::getModel('core/date')->timestamp(time())) . " 00:00:00";
		    $officeId = Mage::getModel('swapp/masters_office_office')->getResource()->getOfficeIdForUserId($jsonObj->userId);

			$model = Mage::getModel('swapp/POS_flightOperation');
			$flightOperation =   $model->getResource()->getByFlightCodeandDate($jsonObj->flightCode, $flightDate, $officeId );

			$flightOperationDO = array(); 

			 

			if(!$flightOperation){
				$message  = "Flight is not scheduled";
   				$result=array("status"=>"fail" , 'error'=>array( $message));
				echo json_encode($result);
				exit(0);        	
			}

		 
			$flightOperationDO['ReasonId'] =$flightOperation['ReasonId'];
			$flightOperationDO['ReasonName'] =$flightOperation['Reason'];
			$flightOperationDO['FlightOperationId'] =   $flightOperation['flightOperationId'];
			$result=array("status"=>"success" , 'data'=> $flightOperationDO );
			echo json_encode($result);
			exit(0);        	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	


	}



	public static function getFlightNoSaleReasons(){

		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);


			$model = Mage::getModel('swapp/POS_flightNoSaleReason');
			$noReason=   $model->getResource()->getNoSaleReasonList( );

			if(!$noReason){
				$message  = "No sale reasons not fetched";
   				$result=array("status"=>"fail" , 'error'=>array( $message));
				echo json_encode($result);
				exit(0);        	
			}

	 
			$result=array("status"=>"success" , 'data'=> $noReason );
			echo json_encode($result);
			exit(0);        	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	


	}


	public static function saveFlightNoSaleReasons(){

		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);

			if(!isset($jsonObj->flightOperationId)){
				$result =array("status"=>"fail",'error'=>'Flight Operation Id parameter not found');
				echo json_encode($result);
				return;
			}
			if(!isset($jsonObj->userId)){
				$result =array("status"=>"fail",'error'=>'User Id parameter not found');
				echo json_encode($result);
				return;
			}		  

			if(!isset($jsonObj->passengerName)){
				$result =array("status"=>"fail",'error'=>'Passenger name parameter not found');
				echo json_encode($result);
				return;
			}		  
			
			if(!isset($jsonObj->seatNo)){
				$result =array("status"=>"fail",'error'=>'Seat No. parameter not found');
				echo json_encode($result);
				return;
			}		  


			if(!isset($jsonObj->reasonId)){
				$result =array("status"=>"fail",'error'=>'Reason Id parameter not found');
				echo json_encode($result);
				return;
			}		  
			 

			$model = Mage::getModel('swapp/POS_flightOperation');
			$flightOperation =   $model->getResource()->getFlightAndPrincipalByID($jsonObj->flightOperationId);
			if(!$flightOperation){
				$message  = "Flight is not scheduled";
   				$result=array("status"=>"fail" , 'error'=>array( $message));
				echo json_encode($result);
				exit(0);        	
			}
			 
			if(!isset($flightOperation['ReasonId'])  && isset($flightOperation['closerUserId']) && $flightOperation['closerUserId']>0){
				$message  = "Flight is already closed";
   				$result=array("status"=>"fail" , 'error'=>array( $message));
				echo json_encode($result);
				exit(0);        	
			}

			$adapter = new Swapp_VO_POS_FlightNoSaleCustomerInfoVO();

			$adapter->getAdapter()->beginTransaction();

 			 
			if(!isset($flightOperation['ReasonId'])){
			    $officeId = Mage::getModel('swapp/masters_office_office')->getResource()->getOfficeIdForUserId($jsonObj->userId);
		    	$serverDate =date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
				$flightNoSaleReasonVO = new Swapp_VO_POS_FlightNoSaleReasonInfoVO();
				$flightNoSaleReasonVO->setReasonID($jsonObj->reasonId);
				$flightNoSaleReasonVO->setFlightOperationID($jsonObj->flightOperationId);
				$flightNoSaleReasonVO->setCreatedAt($serverDate);
				$flightNoSaleReasonVO->setCreatedBy($jsonObj->userId);
		
				$row = $flightNoSaleReasonVO->fetchNew();

				foreach($flightNoSaleReasonVO->getDataArray() as $key=>$value){
					$row[$key] = $value;
				}

				$row->save();
	    		$flightNoSaleReasonInfoID = $flightNoSaleReasonVO->getAdapter()->lastInsertId($flightNoSaleReasonVO->getTableName());
				$con = Mage::getSingleton('core/resource')->getConnection('default_setup');

				$sql = "Update  swapp_flightoperation set  closerDate=now(), closerUserId = {$jsonObj->userId} where flightOperationId = {$jsonObj->flightOperationId} ";
				$stmnt = $con->prepare($sql);
				$stmnt->execute();

			}else{
				$flightNoSaleReasonInfoID = $flightOperation['FlightNoSaleReasonInfoID'];
			}	

			$fileName = '/media/boardingpass/' . rand() .'.jpg';
			file_put_contents(Swapp_Utility::getServerPath() .$fileName,  base64_decode($jsonObj->image));


			//get serial number of nosalecustomeinfo
			 $con = Mage::getSingleton('core/resource')->getConnection('default_setup');

	        $sql = " select max(serialno) serialno
                 from swapp_flightnosalecustomerinfo fl
                 where FlightOperationID =".  $jsonObj->flightOperationId ;

		    $stmnt = $con->prepare($sql);
		    $stmnt->execute();
		    $rowObj  = $stmnt->fetchAll();
			$serialNo=1;

			if($rowObj && $rowObj[0]['serialno']){
					$serialNo = $rowObj[0]['serialno'] +1;
			}
   			$flightNoSaleCustomerVO = new Swapp_VO_POS_FlightNoSaleCustomerInfoVO();
			$flightNoSaleCustomerVO->setCustomerName($jsonObj->passengerName);
			$flightNoSaleCustomerVO->setMobileNo($jsonObj->mobileNo);
			$flightNoSaleCustomerVO->setSeatNo($jsonObj->seatNo);
			$flightNoSaleCustomerVO->setBoardingPassNo('');
			$flightNoSaleCustomerVO->setFlightNoSaleReasonInfoID($flightNoSaleReasonInfoID);
			$flightNoSaleCustomerVO->setImageUrl($fileName  );
			$flightNoSaleCustomerVO->setSerialNo($serialNo);
			$flightNoSaleCustomerVO->setFlightOperationID($jsonObj->flightOperationId);

			$row = $flightNoSaleCustomerVO->fetchNew();

			foreach($flightNoSaleCustomerVO->getDataArray() as $key=>$value){
				$row[$key] = $value;
			}
			$row->save();
			$adapter->getAdapter()->commit(); 	

			$result=array("status"=>"success" , 'data'=> array('message'=>'Successfully Saved')  );
			echo json_encode($result);
			exit(0);        	
			   
		}catch(Exception $e){
Mage::log($e);
			$adapter->getAdapter()->rollBack();
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	


	}


}

?>
