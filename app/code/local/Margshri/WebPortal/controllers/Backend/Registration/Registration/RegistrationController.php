<?php 
class Margshri_WebPortal_Backend_Registration_Registration_RegistrationController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='webportal/Backend_Registration_Registration_Grid';
	private $buttonsBlock ='webportal/Backend_Registration_Registration_Buttons';
	private $printBlock ='webportal/Backend_Registration_Registration_Print';
	
	protected function _init($registrationID){
		
		if($registrationID!=null){
			$model   = Mage::getModel('webportal/Registration_Registration_Registration');
			$dataObj = $model->getResource()->getByID($registrationID);
			
			if($dataObj !== false){
				$registrationDTO= new Margshri_MedicalCamp_VO_RegistrationVO();
				$registrationVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($registrationDTO, $dataObj);
			}
		}
		
		Mage::register('CurrentRegistrationVO', $registrationVO);
		return Mage::registry('CurrentRegistrationVO');
	
	}
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}
	
	public function editAction(){
		$registrationID = $this->getRequest()->getParam('ID');
		$registrationVO = $this->_init($registrationID);
		if($registrationVO== null){
			$registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
		}
		
		$this->loadLayout();
		$this->_addContent(
				$this->getLayout()->createBlock($this->buttonsBlock)
				->setRegistrationID($registrationVO->getID())
				);
		$this->renderLayout();
	}
	
	
	public function printAction(){
	    $registrationID = $this->getRequest()->getParam('ID');
	    $registrationVO = $this->_init($registrationID);
	    if($registrationVO== null){
	        $registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
	    }
	    
	    $this->loadLayout();
	    /*
	    $this->_addContent(
	        $this->getLayout()->createBlock($this->printBlock)
	        ->setRegistrationID($registrationVO->getID())
	        );
	    */
	    $this->renderLayout();
	}
	
	
	public function exportAction(){
	    
	    $gridBlock = $this->getLayout()->createBlock($this->gridBlock);
	    $dataObjs  = $gridBlock->getExportContent()->getCollection()->getData();
	    
	    if($this->getRequest()->getParam('ExportType') == 'xls'){
	        $fileName = "registration_".Margshri_Helper_Utility::getUniqueName().".xls";
	        Margshri_Helper_Utility::setContentTypeForExport($fileName, "application/vnd.ms-excel");
	    }elseif($this->getRequest()->getParam('ExportType') == 'xlsx'){
	        $fileName = "registration_".Margshri_Helper_Utility::getUniqueName().".xlsx";
	        Margshri_Helper_Utility::setContentTypeForExport($fileName, "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	    }
	    
	    $classOption = array("1"=>"5th", "2"=>"8th", "3"=>"10th", "4"=>"12th", "5"=>"Graduation", "6"=>"Post Graduation", "7"=>"Other");
	    $cityOption = Mage::getModel('webportal/Directory_CityList')->getResource()->getGridOptions();
	    $isRejectedOptions = array(1=>"NO", 2=>"YES");
	    $genderOptions = array(1=>"Male", 2=>"Female");
	    
	    echo "SNo \t DateTime \t StudentName \t Father-HusbandName \t MobileNumber \t Gender \t RegistrationNumber \t PassadClass \t Detail \t Persentage \t IsRejected \t Address \t City \n";
	    
	    $serialNo = 1;
	    foreach($dataObjs as $dataObj){
	        
	        $className = "";
	        if(array_key_exists($dataObj['main_table.ClassID'], $classOption)){
	            $className = $classOption[$dataObj['main_table.ClassID']];
	        }
	        
	        
	        $cityName = "";
	        if(array_key_exists($dataObj['main_table.CityID'], $cityOption)){
	            $cityName = $cityOption[$dataObj['main_table.CityID']];
	        }
	        
	        $isRejectedValue = "";
	        if(array_key_exists($dataObj['main_table.IsPaid'], $isRejectedOptions)){
	            $isRejectedValue = $isRejectedOptions[$dataObj['main_table.IsPaid']];
	        }
	        
	        
	        $gender = "";
	        if(array_key_exists($dataObj['main_table.Gender'], $genderOptions)){
	            $gender = $genderOptions[$dataObj['main_table.Gender']];
	        }
	        
	        
	        $address= $dataObj['main_table.Address'];
	        $address= str_replace(' ', '-', $address);
	        $address= preg_replace('/[^A-Za-z0-9\-]/', '', $address);
	        $address= str_replace('-', ' ', $address);
	        
	        
	        $address = preg_replace("/\s+/", " ", $address);
	        $address = trim(preg_replace("/\t+/", " ", $address));
	        
	        
	        echo $serialNo ."\t".$dataObj['main_table.CreatedAt']."\t".$dataObj['main_table.Name']."\t".$dataObj['main_table.FatherName']."\t".$dataObj['main_table.MobileNumber'] ."\t". $gender   ."\t".$dataObj['main_table.TransactionID']."\t".$className ."\t" . $dataObj['main_table.Qualification'] ."\t" . $dataObj['main_table.Percentage'] ."\t" . $isRejectedValue ."\t" . $address ."\t" . $cityName;
	        echo "\n";
	        
	        $serialNo++;
	    }
	    
	}
	
	public function saveAction(){
		try {
			
			
			$post = $this->getRequest()->getPost();
			$isTransactionStart = false;
			$errorMsg = array();
			$response = array();
			
			if (empty($post)) {
				Mage::throwException('Invalid form data.');
			}
			
			$responseVO  = new Margshri_MedicalCamp_VO_RegistrationVO();
			$adapter = $responseVO->getAdapter();
			$registrationVO = new Margshri_MedicalCamp_VO_RegistrationVO();
			
			$registrationVO->setID($post["ID"]);
			// $registrationVO->setCreatedAt($post["RegistrationDataObj"]);
			$registrationVO->setName($post["Name"]);
			$registrationVO->setFatherName($post["FatherName"]);
			$registrationVO->setMobileNumber($post["MobileNumber"]);
			$registrationVO->setGender($post["Gender"]);
			$registrationVO->setAddress($post["Address"]);
			$registrationVO->setCityID($post["CityID"]);
			$registrationVO->setPercentage($post["Percentage"]);
			$registrationVO->setClassID($post["ClassID"]);
			$registrationVO->setQualification($post["Qualification"]);
			$registrationVO->setIsPaid($post["IsPaid"]);
			
			$userID = $post["UserID"];
			if($userID == null || $userID == ""){
			    $userID = null;
			}
			$registrationVO->setUserID($userID);
			
			$programmeID = $post["ProgrammeID"];
			if($programmeID == null || $programmeID == ""){
			    $programmeID = null;
			}
			$registrationVO->setProgrammeID($programmeID);
			
			
			$registrationModel = Mage::getModel('webportal/Registration_Registration_Registration');
			
// 			if($registrationVO->getID() > 0){
// 			    $registrationDataObj = $registrationModel->getResource()->getByID($registrationVO->getID());
// 				if($registrationDataObj !== false){
// 					$newRegistrationDTO= new Margshri_MedicalCamp_VO_RegistrationVO();
// 					/* @var $newRegistrationVO Margshri_MedicalCamp_VO_RegistrationVO */
// 					$newRegistrationVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($newRegistrationDTO, $registrationDataObj);
// 					$newRegistrationVO->setRollNo($registrationVO->getRollNo());
// 				}
// 			}
			
			$adapter->beginTransaction();
			$isTransactionStart = true;
			/* @var $responseVO Margshri_MedicalCamp_VO_RegistrationVO */
			$responseVO = $registrationModel->getResource()->saveDB($registrationVO);
			
			if($responseVO->getErrorMessage() != null){
				$adapter->rollBack();
				Mage::throwException($responseVO->getErrorMessage());
			}else{
				$adapter->commit();
				Mage::getSingleton('core/session')->addSuccess('Successfully Saved.');
				$this->_redirect("*/*");
			}
			
		} catch (Exception $e) {
			if($isTransactionStart == true){
				$adapter->rollBack();
			}
			
			Mage::getSingleton('core/session')->addError($e->getMessage());
			Mage::register('CurrentRegistrationVO', $registrationVO);
			$this->loadLayout();
			$this->_addContent(
			    $this->getLayout()->createBlock($this->buttonsBlock)
			    ->setRegistrationID($registrationVO->getID())
			    );
			$this->renderLayout();
		}
		return;
		
	}
}// end class
