<?php

class AdminAPI_AviationSales_SalesBL
{

	public static function getPrincipals(){
		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
		    require_once('Swapp/Block/POS/POSSale/Buttons.php'); 
		    $buttons = new Swapp_Block_POS_POSSale_Buttons();

		    echo(json_encode( (array('data'=>json_encode($buttons->getPrincipals() ), 'status'=>'success' )  ) ) );
		    exit(0);
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);	    

	}


	public static function getPaymentTypes(){
		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
		    require_once('Swapp/Block/POS/POSSale/Buttons.php'); 
		    $buttons = new Swapp_Block_POS_POSSale_Buttons();

   			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);

		    echo( json_encode(array("data"=>$buttons->getPaymentTypes()) ));
		    exit(0);
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);	    

	}

	public static function getServerDate(){
			header('Content-Type: application/json');
			$message = "";
	      try{    

		 	    $request_body = file_get_contents('php://input');  
			    $jsonObj = json_decode($request_body);
			    require_once('Swapp/Block/POS/POSSale/Buttons.php'); 
			    $buttons = new Swapp_Block_POS_POSSale_Buttons();

			    echo( json_encode(array("date"=>$buttons->getServerDate())) );
			    exit(0);
			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);	    

		}

		public static function getEmployeeName(){
			header('Content-Type: application/json');
			$message = "";
	      try{    

		 	    $request_body = file_get_contents('php://input');  
			    $jsonObj = json_decode($request_body);
			    require_once('Swapp/Block/POS/POSSale/Buttons.php'); 
			    $buttons = new Swapp_Block_POS_POSSale_Buttons();
	   			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 				Mage::getSingleton('admin/session')->setUser($model);
 				$emplList = $buttons->getEmployeeName();
 				$dataList = array();
 				foreach ($emplList as $key => $value) {
 						$value['Code']=$key;
 						$dataList[]=$value;
 					}	

			    echo( json_encode(array("data"=>$dataList) ));
			    exit(0);
			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);	    

		}	

		public static function getUnixTimeStamp(){
			header('Content-Type: application/json');
			$message = "";
	      try{    

		 	    $request_body = file_get_contents('php://input');  
			    $jsonObj = json_decode($request_body);
			    require_once('Swapp/Block/POS/POSSale/Buttons.php'); 
			    $buttons = new Swapp_Block_POS_POSSale_Buttons();
			    echo( json_encode(array("timestamp"=>$buttons->getUnixTimeStamp())) );
			    exit(0);
			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);	    

		}


	public static function getFlight(){

		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);

			if(!isset($jsonObj->flightNumber)){
				$result =array("status"=>"fail",'error'=>'Flight Number parameter not found');
				echo json_encode($result);
				return;
			}
			if(!isset($jsonObj->flightDate)){
				$result =array("status"=>"fail",'error'=>'Flight Date parameter not found');
				echo json_encode($result);
				return;
			}		  
			if(!isset($jsonObj->userId)){
				$result =array("status"=>"fail",'error'=>'User Id parameter not found');
				echo json_encode($result);
				return;
			}	

			$flightDate = Mage::helper('swapp/Data')->dateConvertor($jsonObj->flightDate ,'UKtoUS') ;
    		$flightDate = date("Y-m-d", strtotime($flightDate))  ;
			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
    		
    		
 

			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
		 	$_POST['flightDate'] =$jsonObj->flightDate ;
			$_POST['flightNumber'] =$jsonObj->flightNumber ;

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);

			$response=$controllerInstance->getFlightAction();
 			echo $controllerInstance->getResponse()->getBody();
			exit(0);

			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	


	}



	public static function getIndigoOnFlightPayment(){
		header('Content-Type: application/json');
		$message = "";
      try{    

	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);

			if(!isset($jsonObj->principalId)){
				$result =array("status"=>"fail",'error'=>'principal Id  parameter not found');
				echo json_encode($result);
				return;
			}
			if(!isset($jsonObj->thirdPartyTransactionId)){
				$result =array("status"=>"fail",'error'=>'Reference No.  parameter not found');
				echo json_encode($result);
				return;
			}		  
			if(!isset($jsonObj->ThirdPartyTransactionDate)){
				$result =array("status"=>"fail",'error'=>'Date parameter not found');
				echo json_encode($result);
				return;
			}	


			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
		 	$_POST['principalId'] =$jsonObj->principalId ;
			$_POST['thirdPartyTransactionId'] =$jsonObj->thirdPartyTransactionId ;
			$_POST['ThirdPartyTransactionDate'] =$jsonObj->ThirdPartyTransactionDate ;

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);

			$response=$controllerInstance->getIndigoOnFlightPaymentAction();
 			echo $controllerInstance->getResponse()->getBody();

			exit(0);

			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

		 


	}

	public static function getCLPCustomerDetail(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->CustomerRegistrationVO)){
				$result =array("status"=>"fail",'error'=>'CustomerRegistrationVO   parameter not found');
				echo json_encode($result);
				return;
			}
 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
		 	$_POST['CustomerRegistrationVO'] =json_encode($jsonObj->CustomerRegistrationVO,true) ;
 

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->getCLPCustomerDetailAction();

 			echo $controllerInstance->getResponse()->getBody();
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

		 


	}



	public static function getBindProductList(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->POSSaleVO)){
				$result =array("status"=>"fail",'error'=>'POSSaleVO   parameter not found');
				echo json_encode($result);
				return;
			}
 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
		 	$_POST['POSSaleVO'] =json_encode($jsonObj->POSSaleVO,true) ;
			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->getBindProductListAction();

 			echo $controllerInstance->getResponse()->getBody();
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

		 


	}



	public static function getPromotionsPrincipalByWef(){
			header('Content-Type: application/json');
			$message = "";
	      try{    
	 
		 	    $request_body = file_get_contents('php://input');  
			    $jsonObj = json_decode($request_body);
	 
				if(!isset($jsonObj->principalId)){
					$result =array("status"=>"fail",'error'=>'Principal Id   parameter not found');
					echo json_encode($result);
					return;
				}
				if(!isset($jsonObj->flightDate)){
					$result =array("status"=>"fail",'error'=>'Flight date parameter not found');
					echo json_encode($result);
					return;
				}

				$flightDate = Mage::helper('swapp/Data')->dateConvertor( $jsonObj->flightDate ,'UKtoUS') ;
    			$flightDate = date("Y-m-d", strtotime($flightDate))  ;
	
				$promoModel= Mage::getModel("swapp/Masters_sales_promotions_promotionsPrincipal");
    			$promoList=$promoModel->getResource()->getPromotionsPrincipalListByWef($jsonObj->principalId, $flightDate);
  				foreach ($promoList as $key => $value) {
  						$value['promoHash']= hash('sha256', $value['PromotionId']);
  						$promoList[$key]= $value;
  				}
	 
	 			echo json_encode( array("promotion"=>$promoList) );
				exit(0);

				 
				       	
				   
			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);

			 


		}


	public static function getPaymentCardList(){
			header('Content-Type: application/json');
			$message = "";
	      try{    
	 
		 	    $request_body = file_get_contents('php://input');  
			    $jsonObj = json_decode($request_body);
	 
				 
				$model= Mage::getModel(Swapp_VO_Masters_Sales_Bank_PaymentCardVO::$MODELPATH);
    			$paymentCardList=$model->getResource()->getPaymentCardList();
  
	 
			 

	 			echo json_encode( array("data"=>$paymentCardList) );
				exit(0);

				 
				       	
				   
			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);

			 


		}



	public static function getPromotionAction(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->promotionId)){
				$result =array("status"=>"fail",'error'=>'PromotionId  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->promoHash)){
				$result =array("status"=>"fail",'error'=>'PromotionHash  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->nos)){
				$result =array("status"=>"fail",'error'=>'Nos  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->cartTotal)){
				$result =array("status"=>"fail",'error'=>'CartTotal  parameter not found');
				echo json_encode($result);
				return;
			}

		 	$_POST['promotionId'] = $jsonObj->promotionId;
		 	$_POST['promoHash'] = $jsonObj->promoHash;
		 	$_POST['nos'] =$jsonObj->nos;
		 	$_POST['cartTotal'] =$jsonObj->cartTotal;

 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->getPromotionAction();

 			echo $controllerInstance->getResponse()->getBody();
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

		 


	}

	public static function addCustomer(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->CustomerRegistrationVO)){
				$result =array("status"=>"fail",'error'=>'CustomerRegistrationVO  parameter not found');
				echo json_encode($result);
				return;
			}
 			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);

			$_POST['CustomerRegistrationVO'] = json_encode($jsonObj->CustomerRegistrationVO,true);

		  
 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->addCustomerAction();

// 			echo $controllerInstance->getResponse()->getBody();
			
			$result	  = json_decode($controllerInstance->getResponse()->getBody() , true);
			if(array_key_exists("SuccessMessage",$result) ){
				$arr =$result['SuccessMessage'];	
				$result['status']= $arr[0];
				echo json_encode($result);

			}else{
				echo $controllerInstance->getResponse()->getBody();	
			}

			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}




	public static function resendOTPAddCustomer(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->CustomerRegistrationVO)){
				$result =array("status"=>"fail",'error'=>'mobile No  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->userId)){	
				$result =array("status"=>"fail",'error'=>'User Id parameter not found');
				echo json_encode($result);
				return;
			}	

			if(!isset($jsonObj->CustomerRegistrationVO)){
				$result =array("status"=>"fail",'error'=>'CustomerRegistrationVO  parameter not found');
				echo json_encode($result);
				return;
			}
 			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);

			$_POST['CustomerRegistrationVO'] = json_encode($jsonObj->CustomerRegistrationVO,true);

		  

 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->resendOTPAddCustomerAction();
			$result	  = json_decode($controllerInstance->getResponse()->getBody() , true);
			if(array_key_exists("SuccessMessage",$result) ){
				$arr =$result['SuccessMessage'];	
				$result['status']= $arr[0];
				echo json_encode($result);

			}else{
				echo $controllerInstance->getResponse()->getBody();	
			}
			
 			
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}



	public static function verifyOTPAddCustomer(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->OTPNo)){
				$result =array("status"=>"fail",'error'=>'OTPNo  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->OTPId)){
				$result =array("status"=>"fail",'error'=>'OTPId  parameter not found');
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

			$_POST['otpVO'] =json_encode( array("OTPNo"=>$jsonObj->OTPNo, "OTPId"=>$jsonObj->OTPId) ,true) ;

		  

 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->verifyOTPAction();
			$result	  = json_decode($controllerInstance->getResponse()->getBody() , true);
			if(array_key_exists("ErrorMessage",$result) ){
				$arr =$result['ErrorMessage'];	

				$result['ErrorMessage']= $arr[0];
				echo json_encode($result);

			}else{
				echo $controllerInstance->getResponse()->getBody();	
			}
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}



	public static function getOTPForRedeemCLP(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->mobileNo)){
				$result =array("status"=>"fail",'error'=>'mobile No  parameter not found');
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

			$_POST['CustomerRegistrationVO'] =json_encode( array("ContactNumber"=>$jsonObj->mobileNo) ,true) ;

		  

 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->redeemOTPAction();
			$result	  = json_decode($controllerInstance->getResponse()->getBody() , true);
			if(array_key_exists("SuccessMessage",$result) ){
				$arr =$result['SuccessMessage'];	
				$result['status']= $arr[0];
				echo json_encode($result);

			}else{
				echo $controllerInstance->getResponse()->getBody();	
			}
			
 			
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}

	public static function verifyOTPForRedeemCLP(){
		header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			if(!isset($jsonObj->OTPNo)){
				$result =array("status"=>"fail",'error'=>'OTPNo  parameter not found');
				echo json_encode($result);
				return;
			}

			if(!isset($jsonObj->OTPId)){
				$result =array("status"=>"fail",'error'=>'OTPId  parameter not found');
				echo json_encode($result);
				return;
			}

			$_POST['otpVO'] =json_encode( array("OTPNo"=>$jsonObj->OTPNo, "OTPId"=>$jsonObj->OTPId) ,true) ;

		  

 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->verifyOTPAction();

			$result	  = json_decode($controllerInstance->getResponse()->getBody() , true);
			if(array_key_exists("ErrorMessage",$result) ){
				$arr =$result['ErrorMessage'];	

				$result['ErrorMessage']= $arr[0];
				echo json_encode($result);

			}else{
				echo $controllerInstance->getResponse()->getBody();	
			}
			exit(0);
			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);

	}





	public static function saveAviationSale(){
 
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



 			if(array_key_exists("CrewIdImageURL",$posSaleReferenceVO) ){
	 			
	 			$image = $posSaleReferenceVO["CrewIdImageURL"];
	 			$fileName = '/media/boardingpass/' . rand() .'.jpg';
				file_put_contents(Swapp_Utility::getServerPath() .$fileName,  base64_decode($image));
				$posSaleVO["PosSaleRefernceVO"]["CrewIdImageURL"] = $fileName;
			 	$_POST['POSSaleVO'] = json_encode($posSaleVO);
		  }else if(array_key_exists("BoardingPassURL",$posSaleReferenceVO) ){
	 			
	 			$image = $posSaleReferenceVO["BoardingPassURL"];
	 			$fileName = '/media/boardingpass/' . rand() .'_bpass.jpg';
				file_put_contents(Swapp_Utility::getServerPath() .$fileName,  base64_decode($image));
				$posSaleVO["PosSaleRefernceVO"]["BoardingPassURL"] = $fileName;
			 	$_POST['POSSaleVO'] = json_encode($posSaleVO);
		  }else{
		  		$_POST['POSSaleVO'] = json_encode($posSaleVO);
		  }
 
			if(isset($jsonObj->couponObj)){
				$_POST['couponObj']= $jsonObj->couponObj;
			} 
 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
			/*$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 			Mage::getSingleton('admin/session')->setUser($model);
 			*/

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
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




	public static function getUniqueTxnId(){
				header('Content-Type: application/json');
		$message = "";
      try{    
 
	 	    $request_body = file_get_contents('php://input');  
		    $jsonObj = json_decode($request_body);
 
			 
 			require_once('Swapp/controllers/POS/POSSale/POSSaleController.php'); 
		 	 
 

			$controllerInstance = Mage::getControllerInstance(
			  'Swapp_POS_POSSale_POSSaleController',
			  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
			  new Mage_Core_Controller_Response_Http()
			);
 
			$response=$controllerInstance->getUniqueTxnIdAction();

 			echo $controllerInstance->getResponse()->getBody();
			exit(0);

			 
			       	
			   
		}catch(Exception $e){
			$message  = "Please contact to administrator";
			$result=array("status"=>"fail" ,'error'=>array($message ));
			echo json_encode($result);
		}
			exit(0);


	}


		public static function getInvoiceList(){
			header('Content-Type: application/json');
			$message = "";
	      try{    

		 	    $request_body = file_get_contents('php://input');  
			    $jsonObj = json_decode($request_body);
 	   			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 				Mage::getSingleton('admin/session')->setUser($model);

 				//get office	
				$officeModel= Mage::getModel("swapp/Masters_office_userOffice");
    			$office=$officeModel->getResource()->getOfficeByUserID($jsonObj->userId);
    			$officeId = $office['OfficeID']	;

    			$pageNo = $jsonObj->pageNo;
    			$pageSize	= $jsonObj->pageSize;
				$read = Mage::getSingleton('core/resource')->getConnection('core_read');
				$dataList =	 $read->fetchAll(
						"SELECT pos.posSaleId, pos.createdAt, pos.passengerName, pos.email
           		 		from swapp_possale pos 
	            		WHERE OfficeID=".$officeId . " and EWalletTxnId>1 and  cancelled !=1 order by posSaleId desc limit {$pageNo},{$pageSize}");

				$posInvList = array();	
				foreach ($dataList as $key => $value) {
						$dataArr = array("invoiceDate"=> $dataList[$key]["createdAt"], "posSaleId"=> $dataList[$key]["posSaleId"], "passengerName"=>$dataList[$key]["passengerName"] , "invoiceDetail"=>$dataList[$key]["createdAt"]." | " . $dataList[$key]["passengerName"], "email"=> $dataList[$key]["email"]);	
						$posInvList[]= $dataArr;
				}	
				echo( json_encode(array("data"=>$posInvList,"status"=>"success") ));				 			
				 
			    exit(0);
			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);	    

		} 



public static function sendInvoiceonMail(){
			header('Content-Type: application/json');
			$message = "";
	      try{    

		 	    $request_body = file_get_contents('php://input');  
			    $jsonObj = json_decode($request_body);
 	   			$model = Mage::getModel('admin/user')->load($jsonObj->userId);
 				Mage::getSingleton('admin/session')->setUser($model);
				require_once('Swapp/controllers/POS/Invoice/InvoicePrintController.php'); 
			 	$_POST['PosSaleId'] =$jsonObj->posSaleId ;
				$_POST['EmailId'] =$jsonObj->emailId ;

				$controllerInstance = Mage::getControllerInstance(
				  'Swapp_POS_Invoice_InvoicePrintController',
				  new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
				  new Mage_Core_Controller_Response_Http()
				);

				$response=$controllerInstance->sendEmailAction();
	 			//echo $controllerInstance->getResponse()->getBody();
	 			$result	  = json_decode($controllerInstance->getResponse()->getBody() , true);
				if(array_key_exists("SuccessMessage",$result) ){
					$result['status']= "success";
					$result['msg'] = $result['SuccessMessage'];
					echo json_encode($result);

				}else{
					$result['status']= "fail";
					$result['error'] = array($result['ErorrMessage']);
					echo json_encode($result);
				}
				exit(0);

			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);	    

		} 



		public static function ezeTapWebHook(){
			header('Content-Type: application/json');
			$message = "";
	      try{    

		 	    $request_body = file_get_contents('php://input');  
		 	    Mage::log($request_body);
			    $jsonObj = json_decode($request_body);
				if(!isset($jsonObj->success)){
					$result =array("status"=>"fail",'error'=>'Parameter success not found');
					echo json_encode($result);
					return;
				}

				if(!isset($jsonObj->displayPAN)){
					$result =array("status"=>"fail",'error'=>'Parameter displayPAN not found');
					echo json_encode($result);
					return;
				}

				if(!isset($jsonObj->orderNumber)){
					$result =array("status"=>"fail",'error'=>'Parameter orderNumber not found');
					echo json_encode($result);
					return;
				}

				if(!$jsonObj->success)	{
					$result =array("status"=>"fail",'error'=>'Status false');
					echo json_encode($result);
					return;
				}
				




    			$posSaleVO =  new Swapp_VO_POS_POSSaleVO();
				$where 	  = array();
				$where['TxnId =?'] = $jsonObj->orderNumber;
				$data = array('ReferenceNumber'=> $jsonObj->displayPAN);
				$posSaleVO->getAdapter()->update('swapp_uniquetxn', $data, $where);

  				$result['status']= "success";
				$result['msg'] = "Successfully updated";
				echo json_encode($result);

				exit(0);

			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
				exit(0);	    

		} 



		public static function applyAviationCoupon(){
		
			header('Content-Type: application/json');
			$message = "";
			try{
		
				$request_body = file_get_contents('php://input');
				$jsonObj = json_decode($request_body);
		
				if(!isset($jsonObj->mobileNo)){
					$result =array("status"=>"fail",'error'=>'Mobile Number parameter is not found');
					echo json_encode($result);
					return;
				}
				if(!isset($jsonObj->couponcode)){
					$result =array("status"=>"fail",'error'=>'coupon parameter is not found');
					echo json_encode($result);
					return;
				}
		 
			 
		
		
		
				require_once('Swapp/controllers/POS/POSSale/POSSaleController.php');
				$_POST['mobileNo'] =$jsonObj->mobileNo ;
				$_POST['couponcode'] =$jsonObj->couponcode ;
				$_POST['principalId'] =$jsonObj->principalId ;
				$_POST['invoiceAmount'] =$jsonObj->invoiceAmount ;
		
				$controllerInstance = Mage::getControllerInstance(
						'Swapp_POS_POSSale_POSSaleController',
						new Mage_Core_Controller_Request_Http(), // you can replace this with the actual request
						new Mage_Core_Controller_Response_Http()
						);
		
				$response=$controllerInstance->applyAviationCouponAction();

				$respJson  = json_decode($controllerInstance->getResponse()->getBody(),true);

				if(array_key_exists("status",$respJson) ){
					if($respJson["status"]!="success"){
						$message  = $respJson["message"];
						$result=array("status"=>"fail" ,'error'=>array($message ));
						echo json_encode($result);
						exit(0);
					}
				}
	 			echo $controllerInstance->getResponse()->getBody();
				exit(0);
				 
		
			}catch(Exception $e){
				$message  = "Please contact to administrator";
				$result=array("status"=>"fail" ,'error'=>array($message ));
				echo json_encode($result);
			}
			exit(0);
		
		
		
		
		}
		

}
?>
