<?php 
class Margshri_Common_Backend_Donor_DonorController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_Donor_Donor_Grid';
	private $formBlock ='common/Backend_Donor_Donor_Form';
	
	
	protected function _init(){
	    $donationID = $this->getRequest()->getParam('ID');
	    $donationVO = new Margshri_Common_VO_Donation_Donation_DonationVO();
	    if($donationID != null){
	        $donationModel = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
	        $donationDataObj = $donationModel->getResource()->getByID($donationID);
	        if($donationDataObj !== false){
	            $donationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
	            $donationVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationDTO, $donationDataObj);
			}
		}
		Mage::register('CurrentDonationVO', $donationVO);
		return $donationVO;
	}
	
	
	public function indexAction(){
		$this->loadLayout();
		$this->renderLayout();
	} 
	
	
	public function exportAction(){
	
		$gridBlock = $this->getLayout()->createBlock($this->gridBlock);
		$dataObjs  = $gridBlock->getExportContent()->getCollection()->getData();
	
		if($this->getRequest()->getParam('ExportType') == 'xls'){
			$fileName = "firm_".Margshri_Helper_Utility::getUniqueName().".xls";
			Margshri_Helper_Utility::setContentTypeForExport($fileName, "application/vnd.ms-excel");
		}elseif($this->getRequest()->getParam('ExportType') == 'xlsx'){
			$fileName = "firm_".Margshri_Helper_Utility::getUniqueName().".xlsx";
			Margshri_Helper_Utility::setContentTypeForExport($fileName, "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		}
	
	
		$contactPersonName = array();
		
		echo "FirmID \t FirmName \t ContactPersonName \t Address \t MobileNumber1 \t MobileNumber2 \t LandLineNumber \n";
		foreach($dataObjs as $dataObj){
			$contactPersonNameArray = array();
			$contactPersonName = $dataObj['main_table.ContactPersonName'];
			if($contactPersonName != null && $contactPersonName != ""){
				$contactPersonName = trim($contactPersonName);
				if($contactPersonName != ""){
					$contactPersonNameArray = explode(",", $contactPersonName);
				}
			}
			
			$mob1 = "";
			$mob2 = "";
			$noOfContactPersonName = sizeof($contactPersonNameArray);
			if($noOfContactPersonName > 0){
				foreach($contactPersonNameArray as $key=>$contactPersonNameVal){
					if($noOfContactPersonName == 1){
						$mob1 = $dataObj['main_table.MobileNumber1'];
						$mob2 = $dataObj['main_table.MobileNumber2'];
					}elseif($noOfContactPersonName > 1){
						if($key == 0){
							$mob1 = $dataObj['main_table.MobileNumber1'];
							$mob2 = "";
						}elseif($key == 1){
							$mob1 = "";
							$mob2 = $dataObj['main_table.MobileNumber2'];
						}else{
							$mob1 = "";
							$mob2 = "";
						}
					}
					echo $dataObj['main_table.ID']."\t".$dataObj['main_table.Value']."\t".trim($contactPersonNameVal)."\t".$dataObj['main_table.Address']."\t".$mob1."\t".$mob2."\t".$dataObj['main_table.LandLineNumber'];
					echo "\n";
				}
			}else{
				echo $dataObj['main_table.ID']."\t".$dataObj['main_table.Value']."\t".$dataObj['main_table.ContactPersonName']."\t".$dataObj['main_table.Address']."\t".$dataObj['main_table.MobileNumber1']."\t".$dataObj['main_table.MobileNumber2']."\t".$dataObj['main_table.LandLineNumber'];
			}	
			echo "\n";
		}
	
	}
	
	
	public function editAction(){
		/* @var $donationVO Margshri_Common_VO_Donation_Donation_DonationVO */ 
	    $donationVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setDonationID($donationVO->getID())
		);
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}	

	public function saveAction(){
	    
    	try {
    	    $responseVO = new Margshri_Common_VO_ResponseVO();
    	    $isTransactionStart = false;
    	    
    		$post = $this->getRequest()->getPost();
    		if (empty($post)) {
    			Mage::throwException("Invalid Form Data.");
    		}
    		
    		$donationDataObj = json_decode($post["DonationDataObj"],true);
    		if($donationDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$donationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
    		/* @var $donationVO Margshri_Common_VO_Donation_Donation_DonationVO */
    		$donationVO = Margshri_Common_Helper_Utility::callInstanceFunction($donationDTO, $donationDataObj);

    		if($donationVO->getContactNumber() == null || $donationVO->getContactNumber() == "" ){
    		    $donationVO->setContactNumber(null);
    		}
    		
    		if($donationVO->getAddress() == null || $donationVO->getAddress() == "" ){
    		    $donationVO->setAddress(null);
    		}
    		
    		if($donationVO->getReceiptBookID() == null || $donationVO->getReceiptBookID() == "" ){
    		    $donationVO->setReceiptBookID(null);
    		}
    		
    		if($donationVO->getUserID() == null || $donationVO->getUserID() == ""){
    		    $donationVO->setUserID(null);
    		    
    		    if($donationVO->getDonorName() == null){
    		        Mage::throwException("Please Enter Donor Name.");
    		    }
    		}else{
    		    if($donationVO->getDonorName() == null || $donationVO->getDonorName() == "" ){
    		        $donationVO->setDonorName(null);
    		    }
    		}
    		
    		if($donationVO->getProgrammeID() == null || $donationVO->getProgrammeID() == ""){
    		    $donationVO->setProgrammeID(null);
    		}
    		
    		$donationDateArray = explode('-', $donationVO->getDonationDate());
    		$donationVO->setDonationYear($donationDateArray[0]);
    		
    		$adapter = $donationVO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		$donationModel = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
    		/* @var $responseVO Margshri_Common_VO_User_User_UserVO */
    		$responseVO = $donationModel->getResource()->saveDB($donationVO, $responseVO);
    		
    		if($responseVO->getErrorMessage() != null){
    			Mage::throwException($responseVO->getErrorMessage());
    		}
    		
    		$adapter->commit();
    	
    	} catch (Exception $e) {
    		if($isTransactionStart == true){
    			$adapter->rollBack();
    		}
    		$responseVO->setErrorMessage($e->getMessage());
    	}
    	$this->getResponse()->setBody(Margshri_Common_Helper_Utility::jsonEncode($responseVO->getResponseData()));
    	return;
    
    }	
	
}// end class
