<?php 
class Margshri_Transport_Backend_Master_Vahicale_VahicaleController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='transport/Backend_Master_Vahicale_Vahicale_Grid';
	private $formBlock ='transport/Backend_Master_Vahicale_Vahicale_Form';
	
	
	protected function _init(){
	    $vahicaleID = $this->getRequest()->getParam('ID');
	    $vahicaleVO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
	    if($vahicaleID != null){
	        $vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
	        $vahicaleDataObj = $vahicaleModel->getResource()->getByID($vahicaleID);
	        if($vahicaleDataObj !== false){
	            $vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
	            $vahicaleVO = Margshri_Transport_Helper_Data::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);
			}
		}
		Mage::register('CurrentVahicaleVO', $vahicaleVO);
		return $vahicaleVO;
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
		/* @var $vahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */ 
	    $vahicaleVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setVahicaleID($vahicaleVO->getID())
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
    		
    		$vahicaleDataObj = json_decode($post["VahicaleDataObj"],true);
    		if($vahicaleDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
    		/* @var $vahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
    		$vahicaleVO = Margshri_Transport_Helper_Data::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);

    		
    		if($vahicaleVO->getVahicaleNumber() == null || $vahicaleVO->getVahicaleNumber() == "" ){
    		    Mage::throwException("Please enter vahicale number.");
    		}
    		
    		if($vahicaleVO->getOwnerID() == null || $vahicaleVO->getOwnerID() == "" ){
    		    Mage::throwException("Please select vahicale owner.");
    		}
    		
    		if($vahicaleVO->getStatusID() == null || $vahicaleVO->getStatusID() == "" ){
    		    Mage::throwException("Please select vahicale status.");
    		}
    		
    		/*
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
    		
    		$donationDateArray = explode('-', $donationVO->getDonationDate());
    		$donationVO->setDonationYear($donationDateArray[0]);
    		*/
    		
    		$adapter = $vahicaleDTO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		$vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
    		/* @var $responseVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
    		$responseVO = $vahicaleModel->getResource()->saveDB($vahicaleVO);
    		
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
