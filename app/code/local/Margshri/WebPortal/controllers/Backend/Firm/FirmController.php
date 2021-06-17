<?php 
class Margshri_WebPortal_Backend_Firm_FirmController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='webportal/Backend_Firm_Firm_Grid';
	private $buttonsBlock ='webportal/Backend_Firm_Firm_Buttons';
	
	
	protected function _init($firmID){
	
		if($firmID !=null){
			$model   = Mage::getModel('webportal/Firm_Firm_Firm');
			$dataObj = $model->getResource()->getByID($firmID);
				
			if($dataObj !== false){
				$firmDTO = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
				$firmVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($firmDTO, $dataObj);
			}
		}
	
		Mage::register('CurrentFirmVO', $firmVO);
		return Mage::registry('CurrentFirmVO');
	
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
		$firmID = $this->getRequest()->getParam('ID');
		$firmVO = $this->_init($firmID);
		if($firmVO == null){
			$firmVO = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
		}
		
		$this->loadLayout();
		$this->_addContent(
				$this->getLayout()->createBlock($this->buttonsBlock)
				->setFirmID($firmVO->getID())
		);
		$this->renderLayout();
	}
	
	public function gridAction(){
		$gridBlock =$this->getLayout()->createBlock($this->gridBlock);
		$this->getResponse()->setBody($gridBlock->toHtml());
	}	

	public function saveAction(){
    	try {
    		
    		
    		$post = $this->getRequest()->getPost();
    		$isTransactionStart = false;
    		$errorMsg = array();
    		$response = array();
    		
    		if (empty($post)) {
    			Mage::throwException($this->__('Invalid form data.'));
    		}
    		
    		$firmDataObj = json_decode($post["FirmDataObj"],true);
    		 
    		$adapter     = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
    		$responseVO  = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
    		
    		$firmDTO = new Margshri_WebPortal_VO_Firm_Firm_FirmVO();
    		/* @var $firmVO Margshri_WebPortal_VO_Firm_Firm_FirmVO */
    		$firmVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($firmDTO, $firmDataObj);
    		
    		if($firmVO->getPaymentMethodID() == null || $firmVO->getPaymentMethodID() == ''){
    			$firmVO->setPaymentMethodID(null);
    		}
    		
    		if($firmVO->getPriorityID() == null || $firmVO->getPriorityID() == ''){
    			$firmVO->setPriorityID(null);
    		}
    		
//     		$tableDataObjs = $firmVO->getTableVOs();
//     		$tableVOs = array();
//     		foreach ($tableDataObjs as $tableDataObj){
//     			$tableDTO = new Margshri_WebPortal_VO_Master_Table_TableVO();
//     			/* @var $tableVO Margshri_WebPortal_VO_Master_Table_TableVO */ 
//     			$tableVO  = Margshri_WebPortal_Model_DataAccess::callInstanceFunction($tableDTO, $tableDataObj);
//     			$tableVOs[] = $tableVO; 
//     		}
    		
//     		if(sizeof($tableVOs) == 0){
//     			Mage::throwException('Please Select Atleast One Table.');
//     		}
    		
//     		$tableCodes = '';
//     		$counter = 1;
//     		foreach ($tableVOs as $tableVO){
//     			if(sizeof($tableVOs) == 1 || $counter == 1){
//     				$tableCodes = $tableVO->getCode();
//     			}else{
//     				$tableCodes = $tableCodes . '|' . $tableVO->getCode();
//     			}
//     			$counter++;
//     		}
    		
//     		$firmVO->setTableCodes($tableCodes);
    		
    		$adapter->getAdapter()->beginTransaction();
    		$isTransactionStart = true;
    		$model = Mage::getModel('webportal/Firm_Firm_Firm');
    		/* @var $responseVO Margshri_WebPortal_VO_Firm_Firm_FirmVO() */
    		$responseVO = $model->getResource()->saveDB($firmVO);
    		
    		if($responseVO->getErrorMessage() != null){
    			$adapter->getAdapter()->rollBack();
    			Mage::throwException($responseVO->getErrorMessage());
    		}else{
    			$adapter->getAdapter()->commit();
    		}
    
    	} catch (Exception $e) {
    		if($isTransactionStart == true){
    			$adapter->getAdapter()->rollBack();
    		}
    		$responseVO->setErrorMessage($e->getMessage());
    	}
    	$this->getResponse()->setBody( Mage::helper('webportal/Data')->jsonEncode($responseVO->getBaseDataArray()));
    	return;
    
    }	
	
}// end class
