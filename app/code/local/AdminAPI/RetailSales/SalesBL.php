<?php

class AdminAPI_RetailSales_SalesBL
{

	     
 




	public static function saveRetailSale(){
 
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->POSSaleVO)){
				$result =array("status"=>"fail",'error'=>'POSSaleVO  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->userId)){	
				$result =array("status"=>"fail",'error'=>'User Id parameter not found');
				echo json_encode($result);
				return;
			}	

			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
			 
 
			$posSaleVO =json_decode( $jsonObj->POSSaleVO ,true);
			$posSaleReferenceVO = 	$posSaleVO["PosSaleRefernceVO"];

			$emplModel= Mage::getModel("swapp/Masters_employee_employee");
   			$empl=$emplModel->getResource()->getEmployeeById($posSaleVO['SalesEmplID']);
   			$posSaleVO['SalesEmplCode'] = $empl['EmployeeCode'];

   			/**/
   			$adapter = new Swapp_VO_POS_POSSaleVO();
    		$data =	 $adapter->getAdapter()->fetchRow("SELECT ReferenceNumber from swapp_uniquetxn  where TxnId=". $posSaleVO['EWalletTxnId']);
    		if($data){
    				$posSaleVO['CreditCardNumber'] = $data['ReferenceNumber'];
    		}
	    	/**/		

			$posModel= Mage::getModel("swapp/POS_POSSale_POSSale");
    		$posSaleObject=$posModel->getResource()->getByEwalletTxnId( $jsonObj->orderNumber);
    		if(!$posSaleObject){
    				$result['status']= "fail";
					$result['error'] = array("Order Id not found");
					echo json_encode($result);
					exit(0);
    			}   				



 		 
 			$_POST['POSSaleVO'] = json_encode($posSaleVO);
			if(isset($jsonObj->couponObj)){
				$_POST['couponObj']= $jsonObj->couponObj;
			} 
 			require_once('Swapp/controllers/Retail/NewSalesController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_Retail_NewSalesController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->saveAction();
			$respJson  = json_decode($controllerInstance->getResponse()->getBody(),true);
			Mage::log($respJson);
			if(!array_key_exists("LastInsertedPosSaleID",$respJson) ){
				if(array_key_exists("ErrorMessage",$respJson)){
					$message  = $respJson["ErrorMessage"][0];
				}else{
					$message  = $respJson[0];
				}
				$result=array("status"=>"fail" ,'error'=>$message);
				echo json_encode($result);
				exit(0);
			}
			
 			echo $controllerInstance->getResponse()->getBody();
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			Mage::log($e);
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}

 

	public static function cancelRetailSale(){
 
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->POSSaleVO)){
				$result =array("status"=>"fail",'error'=>'POSSaleVO  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->userId)){	
				$result =array("status"=>"fail",'error'=>'User Id parameter not found');
				echo json_encode($result);
				return;
			}	

			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
			 
 
			$posSaleVO =json_decode( $jsonObj->POSSaleVO ,true);
		    $_POST['POSSaleVO'] = json_encode($posSaleVO);
 			require_once('Swapp/controllers/Retail/CancelInvoiceController.php'); 
			 

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_Retail_CancelInvoiceController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->saveAction();
			$respJson  = json_decode($controllerInstance->getResponse()->getBody(),true);
			Mage::log($respJson);
			if(array_key_exists("ErrorMessage",$respJson)  && $respJson["ErrorMessage"][0] ){
				$message  = $respJson["ErrorMessage"][0];
				$result=array("status"=>"fail" ,'error'=>$message);
				echo json_encode($result);
				exit(0);
			}
			
				
				$result=array("status"=>"success" );
				echo json_encode($result);
				exit(0);

 			//echo $controllerInstance->getResponse()->getBody();
			//exit(0);

			 
			       	
			   
		}catch(Exception $e){
			Mage::log($e);
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}


	public static function getBaseStockForOfflineSale(){
		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
		    require_once('Swapp/controllers/Retail/NewSalesController.php'); 
		     
			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_Retail_NewSalesController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);

   			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);

		    echo( json_encode(array("data"=>$controllerInstance->getBaseStockForOfflineSale()) ));
		    exit(0);
		}catch(Exception $e){
Mage::log($e);
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);	  


		  
		 


	}


}
?>
