<?php 
class Margshri_Common_Backend_Member_MemberController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_Member_Member_Grid';
	private $formBlock ='common/Backend_Member_Member_Form';
	
	
	protected function _init(){
	    $donationID = $this->getRequest()->getParam('ID');
	    $donationVO = new Margshri_Common_VO_Donation_Donation_DonationVO();
	    if($donationID != null){
	        $donationModel = Mage::getModel(Margshri_Common_VO_Donation_Donation_DonationVO::$modelName);
	        $donationDataObj = $donationModel->getResource()->getByID($donationID);
	        if($donationDataObj !== false){
	            $donationDTO = new Margshri_Common_VO_Donation_Donation_DonationVO();
	            $donationVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($donationDTO, $donationDataObj);
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
			$fileName = "member_".Margshri_Helper_Utility::getUniqueName().".xls";
			Margshri_Helper_Utility::setContentTypeForExport($fileName, "application/vnd.ms-excel");
		}elseif($this->getRequest()->getParam('ExportType') == 'xlsx'){
			$fileName = "member_".Margshri_Helper_Utility::getUniqueName().".xlsx";
			Margshri_Helper_Utility::setContentTypeForExport($fileName, "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		}
		
		echo "MemberID \t Date \t MemberName \t Father-HusbandName \t Gender \t MobileNumber \t ReceiptBook \t ReceiptNumber \t Amount \t Address \t CreatedDate \t CreatedBy \n";
		foreach($dataObjs as $dataObj){
		    echo $dataObj['main_table.ID']."\t".$dataObj['main_table.DonationDate']."\t".$dataObj['main_table.DonorName']."\t".$dataObj['main_table.FatherName']."\t".$dataObj['main_table.Description']."\t".$dataObj['main_table.ContactNumber']."\t".$dataObj['receiptbook.BookName']."\t".$dataObj['main_table.ReceiptNumber']."\t".$dataObj['main_table.DonatedAmount']."\t".$dataObj['main_table.Address']."\t".$dataObj['main_table.CreatedAt']."\t".$dataObj['createdby.firstname'];
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
    		$donationVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($donationDTO, $donationDataObj);

    		if($donationVO->getDonorName() == null || $donationVO->getDonorName() == "" ){
    		    Mage::throwException("Please Enter Member Name.");
    		}
    		
    		if($donationVO->getContactNumber() == null || $donationVO->getContactNumber() == "" ){
    		    $donationVO->setContactNumber(null);
    		}
    		
    		if($donationVO->getAddress() == null || $donationVO->getAddress() == "" ){
    		    Mage::throwException("Please Enter Address.");
    		}
    		
    		if($donationVO->getReceiptBookID() == null || $donationVO->getReceiptBookID() == "" ){
    		    Mage::throwException("Please Select Receipt Book.");
    		}
    		 
    		
    		$donationVO->setUserID(null);
    		$donationVO->setDonationTypeID(Margshri_Common_VO_Donation_DonationType_DonationTypeVO::$MEMBERSHIP_RECEIPT);
    		$donationVO->setStatusID(Margshri_Common_VO_Donation_DonationStatus_DonationStatusVO::$PAID);
    		
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
