<?php 
class Margshri_MedicalCamp_Registration_RegistrationController extends Mage_Core_Controller_Front_Action {
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	
    protected function _init($id){
    	$posted = array();
    	
    	if($id !=null){
    		$model   = Mage::getModel('medicalcamp/Registration_Registration');
    		$dataObj = $model->getResource()->getByID($id);
    		$registrationVO = null;
    		
    		
    		if($dataObj !== false){
    			
    			$registrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
    			/* @var $registrationVO Margshri_MedicalCamp_VO_RegistrationVO */
    			$registrationVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($registrationDTO, $dataObj);
    		
    		
	    		// prepair payu money param
	    		$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
	    		$MERCHANT_KEY = "RjCsda";
	    		$SALT = "5er3Gpr7";
	    		$PAYU_BASE_URL = "https://secure.payu.in";
	    		//$PAYU_BASE_URL = "https://test.payu.in";
	    		
	    		$posted['key'] = $MERCHANT_KEY;
	    		$posted['txnid']  = $registrationVO->getTransactionID();
	    		$posted['amount'] = "250";
	    		$posted['productinfo'] = "Registration Fees";
	    		$posted['firstname'] = $registrationVO->getFirstName();
	    		$posted['email'] = $registrationVO->getEmail();
	    		
	    		$hashVarsSeq = explode('|', $hashSequence);
	    		$hash_string = '';
	    		foreach($hashVarsSeq as $hash_var) {
	    			$hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
	    			$hash_string .= '|';
	    		}
	    		
	    		$hash_string .= $SALT;
	    		
	    		
	    		$hash = strtolower(hash('sha512', $hash_string));
	    		$action = $PAYU_BASE_URL . '/_payment';
	    		
	    		$posted['hash'] = $hash;
	    		$posted['action'] = $action;
	    		$posted['phone'] = $registrationVO->getMobileNumber();
	    		$posted['surl'] = "https://www.aapnicity.com/index.php/medicalcamp/Registration_Registration/payuResponse/";
	    		$posted['furl'] = "https://www.aapnicity.com/index.php/medicalcamp/Registration_Registration/payuResponse/";
	    		$posted['curl'] = "https://www.aapnicity.com/index.php/medicalcamp/Registration_Registration/payuResponse/";
	    		
	    		$posted['service_provider'] = "payu_paisa";
	    		$posted['lastname'] = $registrationVO->getLastName();
	    		$posted['address1'] = "";
	    		$posted['address2'] = "";
	    		$posted['city'] = "";
	    		$posted['state'] = "";
	    		$posted['country'] = "";
	    		$posted['zipcode'] = "";
	    		$posted['udf1'] = "";
	    		$posted['udf2'] = "";
	    		$posted['udf3'] = "";
	    		$posted['udf4'] = "";
	    		$posted['udf5'] = "";
	    		$posted['pg'] = "";
	    		 
    		}	
    	}
    	
    	$_SESSION['CurrentPaymentPost'] = $posted;
    	return $posted;
    }
    
    
    public function indexAction(){
    	$this->loadLayout();
    	$this->getLayout()->getBlock('head')->setTitle('Registration');
    	$block = $this->getLayout()->createBlock('medicalcamp/Registration_Info');
    	$block->setTemplate('margshri/medicalcamp/registration/entropy.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
    }


	public function termsAction(){
    	$this->loadLayout();
    	$this->getLayout()->getBlock('head')->setTitle('Registration-Terms');
    	$block = $this->getLayout()->createBlock('medicalcamp/Registration_Terms');
    	//$block->setTemplate('margshri/medicalcamp/registration/terms.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
    }

   
    
    public function admitCardFilterAction(){
    	try {
    		
    		$post = $this->getRequest()->getPost();
    		$errorMsg = array();
    		$succeMsg = array();
    		$responseVO = new Margshri_MedicalCamp_VO_RegistrationVO();
    		
    		if (empty($post)) {
    			$this->loadLayout();
    			$this->getLayout()->getBlock('head')->setTitle('Registration');
    			$block = $this->getLayout()->createBlock('medicalcamp/Registration_AdmitCardFilter');
    			$block->setTemplate('margshri/medicalcamp/registration/admitcardfilter.phtml');
    			
    			$errorMsg['Error'] = "";
    			$_SESSION['CurrentAdmitCardFilter'] = $errorMsg; 
    			
    			$this->getLayout()->getBlock('content')->append($block);
    			$this->renderLayout();
    			
    			
    		}else{
    			$registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
    			$registrationVO->setAddharCardNumber($post["AddharCardNumber"]);
    			
    			//validation
    			if($registrationVO->getAddharCardNumber() == null){
    				Mage::throwException('Please Enter Aadhaar Number');
    			}
    			
    			// GET BY AADHAAR NUMBER
    			$model = mage::getModel('medicalcamp/Registration_Registration');
    			$registrationDataObj = $model->getResource()->getByAadhaarNumber($registrationVO->getAddharCardNumber());

    			if($registrationDataObj !== false){
    				
    				if($registrationDataObj['IsPaid'] == 0){
    					Mage::throwException('Invalid Registration Number');
    				}
    				
    				$this->loadLayout();
    				$this->getLayout()->getBlock('head')->setTitle('Registration');
    				$block = $this->getLayout()->createBlock('medicalcamp/Registration_AdmitCardPrint');
    				$succeMsg['Success'] = $registrationDataObj;
    				$_SESSION['CurrentAdmitCardPrint'] = $succeMsg;
    				$this->getLayout()->getBlock('content')->append($block);
    				$this->renderLayout();
    			}else{
    				$this->loadLayout();
    				$this->getLayout()->getBlock('head')->setTitle('Registration');
    				$block = $this->getLayout()->createBlock('medicalcamp/Registration_AdmitCardFilter');
    				
    				$errorMsg['Error'] = "Invalid Registration Number";
    				$_SESSION['CurrentAdmitCardFilter'] = $errorMsg;
    				
    				$this->getLayout()->getBlock('content')->append($block);
    				$this->renderLayout();
    			}
    			
    		}
    		
    		
    	} catch (Exception $e) {
    		
    		$this->loadLayout();
    		$this->getLayout()->getBlock('head')->setTitle('Registration');
    		$block = $this->getLayout()->createBlock('medicalcamp/Registration_AdmitCardFilter');
    		$block->setTemplate('margshri/medicalcamp/registration/admitcardfilter.phtml');
    		
    		$errorMsg['Error'] = $e->getMessage();
    		$_SESSION['CurrentAdmitCardFilter'] = $errorMsg;
    		
    		$this->getLayout()->getBlock('content')->append($block);
    		$this->renderLayout();
    		
    		
    	}
    }
    
    public function payuResponseAction(){
    	
    	$post = $_POST;
    	$isTrasactionDB = false;
    	$payuResponse = array();
    	$registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
    	$payuResponse['Status'] = "Fail";
    	if(sizeof($post) > 0 && $post != null && $post != ''){
    		if($post['status'] == 'failure'){
    			$payuResponse['Status'] = "Fail"; 
    		}else{
    			$payuResponse['Status'] = "Pass";
    			$registrationVO->setIsPaid(1);
    		}
    	}
    	
    	// save response in table
    	
    	try {
	    	$model = mage::getModel('medicalcamp/Registration_Registration');
	    	$txnid = $post['txnid'];
	    	$registrationDataObj = $model->getResource()->getByTrasactionID($txnid);
	    	
	    	if($registrationDataObj === false){
	    		Mage::throwException('Invalid form data.');
	    	}
	    	$id = $registrationDataObj['ID'];
	    	$paymentResponse= json_encode($post, true);
	    	$registrationVO->setID($id);
	    	$registrationVO->setPaymentResponse($paymentResponse);
	    	$adapter = new Margshri_MedicalCamp_VO_RegistrationVO();
	    	$adapter->getAdapter()->beginTransaction();
	    	$isTrasactionDB = true;
	    	
	    	$response = $model->getResource()->saveDB($registrationVO);
	    	if($response['status'] == "Error"){
	    		Mage::throwException($response['message']);
	    	}
	    	$adapter->getAdapter()->commit();
	    	$isTrasactionDB = false;
    	} catch (Exception $e) {
    		if($isTrasactionDB == true){
    			$adapter->getAdapter()->rollBack();
    		}
    		
    		$payuResponse['Status'] = "Fail"; 
    	}	
	    	
	    	
    	$_SESSION['CurrentPayuResponse'] = $payuResponse;
    	
    	$this->loadLayout();
    	$this->getLayout()->getBlock('head')->setTitle('Registration');
    	$block = $this->getLayout()->createBlock('medicalcamp/Registration_Response');
    	$block->setTemplate('margshri/medicalcamp/registration/response.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
    	
    }
    
    
    public function saveAction(){
    	try {
    		
    		$post = $this->getRequest()->getPost();
    		$errorMsg = array();
    		$response = array();
    		
    		if (empty($post)) {
    			Mage::throwException('Invalid form data.');
    		}
    		$model = mage::getModel('medicalcamp/Registration_Registration');
    		$registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
    		$responseVO = new Margshri_MedicalCamp_VO_RegistrationVO();
    		$helper = Mage::helper("margshri/Utility");
    		$isTrasactionDB = false;
    		
    		$registrationVO->setID($post["ID"]);
    		$registrationVO->setFirstName($post["FirstName"]);
    		$registrationVO->setLastName($post["LastName"]);
    		$registrationVO->setName($post["FirstName"] ." ". $post["LastName"]);
    		$registrationVO->setFatherName($post["FatherName"]);
    		$registrationVO->setGender($post["Gender"]);
    		$registrationVO->setDOB($post["DOB"]);
    		//$registrationVO->setDateOfBirth($post["DateOfBirth"]);
    		$registrationVO->setAddress($post["Address"]);

			$registrationVO->setCountryID($post["CountryID"]);
			$registrationVO->setStateID($post["StateID"]);
			$registrationVO->setDistrictID($post["DistrictID"]);
			$registrationVO->setCityID($post["CityID"]);


			$registrationVO->setClassID($post["ClassID"]);
			$registrationVO->setSubjectID($post["SubjectID"]);
			$registrationVO->setBoardID($post["BoardID"]);


			$registrationVO->setPincode($post["Pincode"]);
    		$registrationVO->setMobileNumber($post["MobileNumber"]);
    		$registrationVO->setEmail($post["Email"]);
    		$registrationVO->setCurrentSchool($post["CurrentSchool"]);
    		$registrationVO->setAddharCardNumber($post["AddharCardNumber"]);
    		
    		

    		//validation
    		if($registrationVO->getAddharCardNumber() == null){
    			Mage::throwException('Please Enter Aadhaar Number');
    		}
    		
    		// GET BY AADHAAR NUMBER
    		$registrationDataObj = $model->getResource()->getByAadhaarNumber($registrationVO->getAddharCardNumber());
    		$isEdit = false;
    		if($registrationDataObj !== false){
    			if($registrationDataObj['IsPaid'] == 1){
    				Mage::getSingleton('core/session')->addError("Already Register With This Aadhaar No ". $registrationVO->getAddharCardNumber());
    				$this->_redirect('*/*/');
    				return;
    			}
    			$isEdit = true;
    		}	
    		
    		$adapter = new Margshri_MedicalCamp_VO_RegistrationVO();
    		
    		if($isEdit == false){
    			$transactionID = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    			$registrationVO->setTransactionID($registrationVO->getAddharCardNumber());
    			
    			$imageFileObj = $_FILES['StudentImgFile'];
    			if($imageFileObj["tmp_name"] != null && $imageFileObj["tmp_name"] != ''){
    				$ext = substr(strrchr($imageFileObj["name"], '.'), 1);
    				$imagePath = 'web_portal/frontend/studentregistration/'.$registrationVO->getTransactionID().'_StudentImage'.'.'.$ext;
    				$registrationVO->setImageURL($imagePath);
    			}
    			
				/*
    			$addharCardFileObj = $_FILES['AddharCardFile'];
    			if($addharCardFileObj["tmp_name"] != null && $addharCardFileObj["tmp_name"] != ''){
    				$ext = substr(strrchr($addharCardFileObj["name"], '.'), 1);
    				$addharCardPath = 'web_portal/frontend/studentregistration/'.$registrationVO->getTransactionID().'_AddharCardImage'.'.'.$ext;
    				$registrationVO->setAddharCardURL($addharCardPath);
    			}
				*/
    		}else{
    			$registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
    			$registrationVO->setID($registrationDataObj['ID']);
    			$registrationVO->setAddharCardNumber($registrationDataObj['AddharCardNumber']);
    		}	
    		
    		$adapter->getAdapter()->beginTransaction();
    		$isTrasactionDB = true;
    		$response = $model->getResource()->saveDB($registrationVO);
    		if($response['status'] == "Error"){
    			Mage::throwException($response['message']);
    		}
    		$adapter->getAdapter()->commit();
    			
    		// GET BY AADHAAR NUBER AFTER NEW ENTRY
    		$afterInsertRegistrationDataObj = $model->getResource()->getByAadhaarNumber($registrationVO->getAddharCardNumber());
    		if($afterInsertRegistrationDataObj === false){
    			Mage::throwException("Insertion Failed !");
    		}
    		
    		$registrationID = $afterInsertRegistrationDataObj['ID'];
    		
    		if($registrationID == null){
    			Mage::throwException("TransactionID not generated !");
    		}	
    		
    		$posted = $this->_init($registrationID);
    		if( sizeof($posted) == 0){
    			Mage::throwException("Data Not Fetch By TransactionID ". $registrationID);
    		}

    		if($isEdit == false){
	    		if($imageFileObj["tmp_name"] != null && $imageFileObj["tmp_name"] != ''){
	    			$isImageUploaded = move_uploaded_file($imageFileObj["tmp_name"], $helper->getServerPath() . '/media/' . $registrationVO->getImageURL() );
	    			if(!$isImageUploaded){
	    				Mage::throwException("Student image could not uploaded !");
	    			}
	    		}
	    		
				/*
	    		if($addharCardFileObj["tmp_name"] != null && $addharCardFileObj["tmp_name"] != ''){
	    			$isAddharCardUploaded = move_uploaded_file($addharCardFileObj["tmp_name"], $helper->getServerPath() . '/media/' . $registrationVO->getAddharCardURL() );
	    			if(!$isAddharCardUploaded){
	    				Mage::throwException("Aadhaar card image could not uploaded !");
	    			}
	    		}
				*/
    		}	
    		
    		Mage::getSingleton('core/session')->addSuccess("you have successfully registered");
    		
    		$this->_initAction();
    		$this->getLayout()->getBlock('head')->setTitle('Registration');
    		$block = $this->getLayout()->createBlock('medicalcamp/Registration_Payment');
    		$this->getLayout()->getBlock('content')->append($block);
    		$this->renderLayout();
    		
    	} catch (Exception $e) {
    		if($isTrasactionDB == true){
    			$adapter->getAdapter()->rollBack();
    		}	
    		$responseVO->setErrorMessage($e->getMessage());
    		//Mage::getSingleton('core/session')->addError("unfortunately you are not registered please try again");
    		Mage::getSingleton('core/session')->addError($e->getMessage());
    		$_SESSION['CurrentRegistrationVO'] = $registrationVO;
    		//Mage::register('CurrentRegistrationVO', $newRegistrationVO);
    		$this->_redirect('*/*/');
    		return;
    	}
    	
    }
    
}
