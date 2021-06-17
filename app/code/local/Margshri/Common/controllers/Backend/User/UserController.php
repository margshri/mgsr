<?php 
class Margshri_Common_Backend_User_UserController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='common/Backend_User_User_Grid';
	private $formBlock ='common/Backend_User_User_Form';
	
	
	protected function _init(){
	    $userID = $this->getRequest()->getParam('ID');
	    $userVO = new Margshri_Common_VO_User_User_UserVO();
	    if($userID != null){
	        $userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
			$userDataObj = $userModel->getResource()->getByID($userID);
			if($userDataObj !== false){
			    $userDTO = new Margshri_Common_VO_User_User_UserVO();
			    $userVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($userDTO, $userDataObj);
			}
		}
		Mage::register('CurrentUserVO', $userVO);
		return $userVO;
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
		foreach($dataObjs as $dataObj){
			// GET ALL WAY BILL NUMBER
			$wayBillNumbers[] = $dataObj['main_table.ContactPersonName'];
		}
	
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
		/* @var $userVO new Margshri_WebPortal_VO_Firm_Firm_FirmVO */ 
		$userVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setUserID($userVO->getID())
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
    		
    		$userDataObj = json_decode($post["UserDataObj"],true);
    		if($userDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$userDTO = new Margshri_Common_VO_User_User_UserVO();
    		/* @var $userVO Margshri_Common_VO_User_User_UserVO */
    		$userVO = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($userDTO, $userDataObj);

    		$adapter = $userVO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		$userModel = Mage::getModel(Margshri_Common_VO_User_User_UserVO::$modelName);
    		/* @var $responseVO Margshri_Common_VO_User_User_UserVO */
    		$responseVO = $userModel->getResource()->saveDB($userVO, $responseVO);
    		
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
