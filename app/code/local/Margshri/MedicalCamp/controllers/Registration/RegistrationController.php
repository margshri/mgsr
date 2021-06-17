<?php 
class Margshri_MedicalCamp_Registration_RegistrationController extends Mage_Core_Controller_Front_Action {
	
	protected function _initAction(){
		$this->loadLayout();
		return $this;
	}

	
	protected function _init($transactionID){
    	
	    $registrationData = null;
    	if($transactionID != null){
    		$model = Mage::getModel('medicalcamp/Registration_Registration');
    		$dataObj = $model->getResource()->getByTransactionID($transactionID);
    		
    		if($dataObj !== false){
    			$registrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
    			/* @var $registrationVO Margshri_MedicalCamp_VO_RegistrationVO */
    			$registrationVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($registrationDTO, $dataObj);
    			$registrationData = $registrationVO->getDataArray();
    			$registrationData['ID'] = $registrationVO->getID();
    		}	
    	}
    	
    	Mage::getSingleton('core/session')->setData("CurrentRegistrationData", $registrationData);
    	return $registrationData;
    }
    
    
    public function indexAction(){
        $this->loadLayout();
    	$this->renderLayout();
    }

    
    public function showNewFormAction(){
        $this->loadLayout();
        $this->renderLayout();
    }
    
    
    public function editAction(){
        try {
            $post = $this->getRequest()->getPost();
            $registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
            
            if (empty($post)) {
                Mage::throwException('unexpected error occurred. please try after some time.');
            }
            
            $registrationVO->setTransactionID($post['TransactionID']);
            $registrationVO->setMobileNumber($post['MobileNumber']);
            if($registrationVO->getTransactionID() == null){
                Mage::throwException('Please Enter Registration Number.');
            }
            
            if($registrationVO->getMobileNumber() == null){
                Mage::throwException('Please Enter Mobile Number.');
            }
            
            
            
            $registrationModel = Mage::getModel('medicalcamp/Registration_Registration');
            $registrationDataObj = $registrationModel->getResource()->getByTransactionIDAndMobileNumber($registrationVO->getTransactionID(), $registrationVO->getMobileNumber());
            
            if($registrationDataObj === false){
                Mage::throwException('Registraion Number Or Mobile Number Invalid.');
            }
            
            $registrationDTO = new Margshri_MedicalCamp_VO_RegistrationVO();
            /* @var $persistedRegistrationVO Margshri_MedicalCamp_VO_RegistrationVO */
            $persistedRegistrationVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($registrationDTO, $registrationDataObj);
            
            
            // added by vipin date 22-12-2020
            if($persistedRegistrationVO->getCreatedAt() != null){
                $createdDate = date("Y-m-d", strtotime($persistedRegistrationVO->getCreatedAt()));
                if($createdDate < "2020-12-22"){
                    Mage::throwException('Registraion Number Or Mobile Number Invalid.');
                }
            }
             
            
            $registrationData = $persistedRegistrationVO->getDataArray();
            $registrationData['ID'] = $persistedRegistrationVO->getID();
            
            Mage::getSingleton('core/session')->setData("CurrentRegistrationData", $registrationData);
            
            $this->loadLayout();
            $this->renderLayout();
        } catch (Exception $e) {
            $registrationVO->setErrorMessage($e->getMessage());
            $dataArray = $registrationVO->getDataArray();
            $baseDataArray = $registrationVO->getBaseDataArray();
            $mergeArray = array_merge($dataArray,$baseDataArray);
            Mage::getSingleton('core/session')->setData("CurrentRegistrationData", $mergeArray);
            $this->_redirect('*/*/');
            return;
        }
        
    }
    
    
    public function responseAction(){
        $registrationData = Mage::getSingleton('core/session')->getData("CurrentRegistrationData");
        if($registrationData == null){
            $this->_redirect('*/*');
        }else{
            $this->_initAction();
            $this->renderLayout();
        }
    }
    
    
	public function termsAction(){
    	$this->loadLayout();
    	$this->getLayout()->getBlock('head')->setTitle('Registration-Terms');
    	$block = $this->getLayout()->createBlock('medicalcamp/Registration_Terms');
    	//$block->setTemplate('margshri/medicalcamp/registration/terms.phtml');
    	$this->getLayout()->getBlock('content')->append($block);
    	$this->renderLayout();
    }
 
    public function showGeniusAction(){
        $this->_initAction();
        $this->renderLayout();
    }
    
    public function saveAction(){
    	try {
    		
    		$post = $this->getRequest()->getPost();
    		$registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
    		
    		if (empty($post)) {
    			Mage::throwException('unexpected error occurred. please try after some time.');
    		}
    		
    		$registrationModel = mage::getModel('medicalcamp/Registration_Registration');
    		$adapter = new Margshri_MedicalCamp_VO_RegistrationVO();
    		$helper = Mage::helper("margshri/Utility");
    		$isTrasactionDB = false;
    		
    		/*
    		if( isset($_SESSION['LastFormKey']) ){
    			if($_SESSION['LastFormKey'] == $post['form_key']){
    				Mage::throwException('Invalid form data.');
    			}else{
    				$_SESSION['LastFormKey'] = $post['form_key'];
    			}
    		}else{
    			$_SESSION['LastFormKey'] = $post['form_key'];
    		}
    		*/
    		
    		$registrationVO->setID($post["ID"]);
    		$registrationVO->setName($post["Name"]);
    		$registrationVO->setFatherName($post["FatherName"]);
    		$registrationVO->setMobileNumber($post["MobileNumber"]);
    		$registrationVO->setClassID($post["ClassID"]);
    		$registrationVO->setAddress($post["Address"]);
			$registrationVO->setCountryID($post["CountryID"]);
			$registrationVO->setStateID($post["StateID"]);
			$registrationVO->setDistrictID($post["DistrictID"]);
			$registrationVO->setCityID($post["CityID"]);

    		//validation
    		if($registrationVO->getName() == null){
    		    Mage::throwException('Please Enter Student Name.');
    		}
    		
    		if($registrationVO->getFatherName() == null){
    		    Mage::throwException('Please Enter Father Name.');
    		}
    		
    		if($registrationVO->getMobileNumber() == null){
    		    Mage::throwException('Please Enter Mobile Number.');
    		}
    		
    		if($registrationVO->getClassID() == null){
    		    Mage::throwException('Please Enter Class.');
    		}else{
    		    if($registrationVO->getClassID() == 7){
        		    $registrationVO->setQualification($post["Qualification"]);
        		    if($registrationVO->getQualification() == null){
        		        Mage::throwException('Please Enter Class Value.');
        		    }
    		    }
    		}
    		
    		if($registrationVO->getAddress() == null){
    		    Mage::throwException('Please Enter Address.');
    		}
    		
    		if($registrationVO->getCityID() == null){
    		    Mage::throwException('Please Select City.');
    		}

    		$transactionID = 0;
    		$studentImageFileObj = $_FILES['StudentImgFile'];
    		$qualificationImageFileObj = $_FILES['QualificationImgFile'];
    		if($registrationVO->getID() == 0 || $registrationVO->getID() == null || $registrationVO->getID() == ""){
    		    
    		    if($studentImageFileObj["tmp_name"] == null && $studentImageFileObj["tmp_name"] == ''){
    		        Mage::throwException('Please Select Student Image.');
		        }
		        
		        if($qualificationImageFileObj["tmp_name"] == null && $qualificationImageFileObj["tmp_name"] == ''){
		            Mage::throwException('Please Select Document Image.');
		        }
		        
		        $persistedRegistrationDataObj = $registrationModel->getResource()->getLastRecord();
		        if($persistedRegistrationDataObj === false){
		            $transactionID = 1001;
		        }else{
		            $transactionID = $persistedRegistrationDataObj['TransactionID'] + 1;
		        }
		        
		        
    		}else{
    		    $persistedRegistrationDataObj = $registrationModel->getResource()->getByID($registrationVO->getID());
    		    if($persistedRegistrationDataObj == null){
    		        Mage::throwException('unexpected error occurred. please try after some time.');
    		    }
    		    $transactionID = $persistedRegistrationDataObj['TransactionID'];
    		}
    		$registrationVO->setTransactionID($transactionID);
			
    		if($studentImageFileObj["tmp_name"] != null && $studentImageFileObj["tmp_name"] != ''){
    		    $studentImageExt = substr(strrchr($studentImageFileObj["name"], '.'), 1);
    		    $studentImagePath = 'mgsr/frontend/studentregistration/'.$registrationVO->getTransactionID().'_StudentImage'.'.'.$studentImageExt;
    		    $registrationVO->setImageURL($studentImagePath);
    		}
    		
    		if($qualificationImageFileObj["tmp_name"] != null && $qualificationImageFileObj["tmp_name"] != ''){
    		    $qualificationImageExt = substr(strrchr($qualificationImageFileObj["name"], '.'), 1);
    		    $qualificationImagePath = 'mgsr/frontend/studentregistration/'.$registrationVO->getTransactionID().'_DocumentImage'.'.'.$qualificationImageExt;
    		    $registrationVO->setQualificationURL($qualificationImagePath);
    		}
    		
    		$adapter->getAdapter()->beginTransaction();
    		$isTrasactionDB = true;
    		$response = $registrationModel->getResource()->saveDB($registrationVO);
    		if($response['status'] == "Error"){
    			Mage::throwException($response['message']);
    		}
    		
    		$posted = $this->_init($registrationVO->getTransactionID());
    		if(sizeof($posted) == 0){
    		    Mage::throwException("unexpected error occurred. please try after some time");
    		}

    		if($studentImageFileObj["tmp_name"] != null && $studentImageFileObj["tmp_name"] != ''){
    		    $isStudentImageUploaded = move_uploaded_file($studentImageFileObj["tmp_name"], $helper->getServerPath() . '/media/' . $registrationVO->getImageURL() );
    		    if(!$isStudentImageUploaded){
    		        Mage::throwException("Student image could not uploaded !");
    		    }
    		}
    		
    		if($qualificationImageFileObj["tmp_name"] != null && $qualificationImageFileObj["tmp_name"] != ''){
    		    $isQualificationImageUploaded = move_uploaded_file($qualificationImageFileObj["tmp_name"], $helper->getServerPath() . '/media/' . $registrationVO->getQualificationURL() );
    		    if(!$isQualificationImageUploaded){
    		        Mage::throwException("Student image could not uploaded !");
    		    }
    		}

    		$adapter->getAdapter()->commit();
    		
    		$this->_redirect('*/*/response');
    		
    	} catch (Exception $e) {
    		if($isTrasactionDB == true){
    			$adapter->getAdapter()->rollBack();
    		}
    		
    		$registrationVO->setErrorMessage($e->getMessage());
    		$dataArray = $registrationVO->getDataArray();
    		$dataArray['ID'] = $registrationVO->getID();
    		$baseDataArray = $registrationVO->getBaseDataArray();
    		$mergeArray = array_merge($dataArray,$baseDataArray);
    		Mage::getSingleton('core/session')->setData("CurrentRegistrationData", $mergeArray);
    		$this->_redirect('*/*/showNewForm');
    		return;
    	}
    	
    }
    
}
