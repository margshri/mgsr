<?php 
class Margshri_Transport_Backend_Consignment_Consignment_ConsignmentNoteController extends Mage_Adminhtml_Controller_Action{
	
	private $gridBlock ='transport/Backend_Consignment_Consignment_ConsignmentNote_Grid';
	private $formBlock ='transport/Backend_Consignment_Consignment_ConsignmentNote_Form';
	private $printBlock ='transport/Backend_Consignment_Consignment_ConsignmentNote_Print';
	
	protected function _init(){
	    $consignmentNoteID = $this->getRequest()->getParam('ID');
	    $consignmentNoteVO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
	    
	    if($consignmentNoteID != null){
	        $consignmentNoteModel = Mage::getModel(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO::$modelName);
	        $consignmentNoteDataObj = $consignmentNoteModel->getResource()->getByID($consignmentNoteID);
	        if($consignmentNoteDataObj !== false){
	            $consignmentNoteDTO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
	            $consignmentNoteVO = Margshri_Transport_Helper_Data::callInstanceFunction($consignmentNoteDTO, $consignmentNoteDataObj);
	            
	            $commonModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_CommonVO::$modelName);
	            $commonDataObj = $commonModel->getResource()->getByID($consignmentNoteVO->getCommonID());
	            
	            $vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
	            $vahicaleDataObj = $vahicaleModel->getResource()->getByID($commonDataObj['VahicaleID']);
	            if($vahicaleDataObj !== false){
	                $vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
	                /* @var $vahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
	                $vahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);
	                $consignmentNoteVO->setVahicaleNumber($vahicaleVO->getVahicaleNumber());
	            }
	            
	            
	            
	            /*
	            $cityModel = Mage::getModel(Margshri_Common_VO_Directory_CityList_CityListVO::$modelName);
	            $cityDataObj = $cityModel->getResource()->getByID($consignmentNoteVO->getSourceCityID());
	            $consignmentNoteVO->setSourceCityName($cityDataObj['Value']);
	            $cityDataObj = $cityModel->getResource()->getByID($consignmentNoteVO->getDestinationCityID());
	            $consignmentNoteVO->setDestinationCityName($cityDataObj['Value']);
	            */
	            
			}
		}
		Mage::register('CurrentConsignmentNoteVO', $consignmentNoteVO);
		return $consignmentNoteVO;
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
		/* @var $consignmentNoteVO Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO */ 
	    $consignmentNoteVO = $this->_init();
		
		$this->loadLayout();
		$this->_addContent(
		    $this->getLayout()->createBlock($this->formBlock)->setConsignmentNoteID($consignmentNoteVO->getID())
		);
		$this->renderLayout();
	}
	
	
	public function printAction(){
	    /* @var $consignmentNoteVO Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO */
	    $consignmentNoteVO = $this->_init();
	    
	    $this->loadLayout();
	    /*
	    $this->_addContent(
	        $this->getLayout()->createBlock($this->printBlock)->setConsignmentNoteID($consignmentNoteVO->getID())
	        );
	    */    
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
    		
    		$consignmentNoteDataObj = json_decode($post["ConsignmentNoteDataObj"],true);
    		if($consignmentNoteDataObj == null){
    		    Mage::throwException("Invalid Form Data.");
    		}
    		$consignmentNoteDTO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
    		/* @var $consignmentNoteVO Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO */
    		$consignmentNoteVO = Margshri_Common_Helper_Utility::callInstanceFunction($consignmentNoteDTO, $consignmentNoteDataObj);
    		
    		if($consignmentNoteVO->getConsignorMobileNo() != null && $consignmentNoteVO->getConsigneeMobileNo() != null){
        		if($consignmentNoteVO->getConsignorMobileNo() == $consignmentNoteVO->getConsigneeMobileNo()){
        		    Mage::throwException("Consignor Mobile No And Consignee Mobile No Cannot Be Same.");
        		}
    		}
    		
    		/*
    		if($consignmentNoteVO->getConsignorCityID() != null && $consignmentNoteVO->getConsigneeCityID() != null){
        		if($consignmentNoteVO->getConsignorCityID() == $consignmentNoteVO->getConsigneeCityID()){
        		    Mage::throwException("Consignor City And Consignee City Cannot Be Same.");
        		}
    		}
    		*/
    		
    		if($consignmentNoteVO->getConsignorGstinNo() != null && $consignmentNoteVO->getConsigneeGstinNo() != null){
    		    if($consignmentNoteVO->getConsignorGstinNo() == $consignmentNoteVO->getConsigneeGstinNo()){
    		        Mage::throwException("Consignor GstNo And Consignee GstNo Cannot Be Same.");
    		    }
    		}
    		
    		if($consignmentNoteVO->getSourceCityName() != null && $consignmentNoteVO->getDestinationCityName() != null){
        		if($consignmentNoteVO->getSourceCityName() == $consignmentNoteVO->getDestinationCityName()){
        		    Mage::throwException("From City And To City Cannot Be Same.");
        		}
    		}
    		
    		
    		/*
    		if($consignmentNoteVO->getVahicaleID() == null || $consignmentNoteVO->getVahicaleID() == ""){
    		    Mage::throwException("Please Enter Vahicale Number.");
    		}
    		
    		if($consignmentNoteVO->getVahicaleOwnerID() == null || $consignmentNoteVO->getVahicaleOwnerID() == ""){
    		    Mage::throwException("Please Select Vahicale Owner.");
    		}
    		
    		if($consignmentNoteVO->getDriverID() == null || $consignmentNoteVO->getDriverID() == ""){
    		    Mage::throwException("Please Select Driver.");
    		}
    		*/
    		
    		$adapter = $consignmentNoteDTO->getAdapter();
    		$adapter->beginTransaction();
    		$isTransactionStart = true;
    		
    		$commonModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_CommonVO::$modelName);
    		$commonVO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
    		if($consignmentNoteVO->getCommonID() != null){
    		    $commonDataObj = $commonModel->getResource()->getByID($consignmentNoteVO->getCommonID());
    		    if($commonDataObj !== false){
    		        $commonDTO = new Margshri_Transport_VO_Master_Vahicale_CommonVO();
    		        $commonVO = Margshri_Common_Helper_Utility::callInstanceFunction($commonDTO, $commonDataObj);
    		    }
    		}else{
        		    
    		    if($consignmentNoteVO->getVahicaleNumber() == null || $consignmentNoteVO->getVahicaleNumber() == ""){
    		        Mage::throwException("Please Enter Truck Number.");
    		    }
    		    
    		    $vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
    		    $vahicaleVO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
    		    $vahicaleDataObj = $vahicaleModel->getResource()->getByVahicaleNumber($consignmentNoteVO->getVahicaleNumber());
    		    if($vahicaleDataObj !== false){
    		        $commonVO->setVahicaleID($vahicaleDataObj['ID']);
    		    }else{
    		        $vahicaleVO->setVahicaleNumber($consignmentNoteVO->getVahicaleNumber());
    		        $responseVO = $vahicaleModel->getResource()->saveDB($vahicaleVO);
    		        if($responseVO->getErrorMessage() == null){
    		            $responseData = $responseVO->getResponseData();
    		            $commonVO->setVahicaleID($responseData['ResponseData']['VahicaleID']);
    		        }else{
    		            Mage::throwException("Truck Detail Not Found.");
    		        }
    		    }
        	}
    		
    		
    		
    		if($commonVO->getOwnerID() == null){
    		    if($consignmentNoteVO->getOwnerName() == null || $consignmentNoteVO->getOwnerName() == ""){
    		        Mage::throwException("Please Enter Truck Owner Name.");
    		    }
    		    
    		    if($consignmentNoteVO->getOwnerMobileNo() != null || $consignmentNoteVO->getOwnerMobileNo() != ""){
    		        $ownerModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
    		        $ownerDataObj = $ownerModel->getResource()->getByMobileNo($consignmentNoteVO->getOwnerMobileNo());
    		        $ownerVO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
    		        if($ownerDataObj !== false){
        		        $ownerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
        		        $ownerVO = Margshri_Common_Helper_Utility::callInstanceFunction($ownerDTO, $ownerDataObj);
        		        $commonVO->setOwnerID($ownerVO->getID());
        		    }else{
    		            $ownerVO->setName($consignmentNoteVO->getOwnerName());
    		            $ownerVO->setMobileNo($consignmentNoteVO->getOwnerMobileNo());
    		            $ownerVO->setStatusID(Margshri_Common_VO_Status_StatusVO::$ACTIVE);
    		            $responseVO = $ownerModel->getResource()->saveDB($ownerVO);
    		            if($responseVO->getErrorMessage() == null){
    		                $responseData = $responseVO->getResponseData();
    		                $commonVO->setOwnerID($responseData['ResponseData']['OwnerID']);
    		            }else{
    		                Mage::throwException("Truck Owner Detail Not Found.");
    		            }
    		        }
    		    }
    		}
    		
    		
    		
    		if($commonVO->getDriverID() == null){
    		    if($consignmentNoteVO->getDriverName() == null || $consignmentNoteVO->getDriverName() == ""){
    		        Mage::throwException("Please Enter Driver Name.");
    		    }
    		    
    		    if($consignmentNoteVO->getDriverMobileNo() != null || $consignmentNoteVO->getDriverMobileNo() != ""){
    		        $driverModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_DriverVO::$modelName);
    		        $driverDataObj = $driverModel->getResource()->getByMobileNo($consignmentNoteVO->getDriverMobileNo());
    		        $driverVO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
    		        if($driverDataObj !== false){
    		            $driverDTO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
    		            $driverVO = Margshri_Common_Helper_Utility::callInstanceFunction($driverDTO, $driverDataObj);
    		            $commonVO->setDriverID($driverVO->getID());
    		        }else{
    		            $driverVO->setName($consignmentNoteVO->getDriverName());
    		            $driverVO->setMobileNo($consignmentNoteVO->getDriverMobileNo());
    		            $driverVO->setStatusID(Margshri_Common_VO_Status_StatusVO::$ACTIVE);
    		            $responseVO = $driverModel->getResource()->saveDB($driverVO);
    		            if($responseVO->getErrorMessage() == null){
    		                $responseData = $responseVO->getResponseData();
    		                $commonVO->setDriverID($responseData['ResponseData']['DriverID']);
    		            }else{
    		                Mage::throwException("Truck Driver Detail Not Found.");
    		            }
    		        }
    		    }
    		}
    		
    		
    		$consignmentNoteVO->setVahicaleID($commonVO->getVahicaleID());
    		$consignmentNoteVO->setVahicaleOwnerID($commonVO->getOwnerID());
    		$consignmentNoteVO->setDriverID($commonVO->getDriverID());
    		
    		if($commonVO->getID() == null){
    		    $commonDataObj = $commonModel->getResource()->getByVOCheckDuplicate($commonVO);
    		    if($commonDataObj['ID'] != null){
    		        $commonVO->setID($commonDataObj['ID']);
    		    }
    		}
    		
    		$commonVO->setStatusID(Margshri_Common_VO_Status_StatusVO::$ACTIVE);
    		$responseVO = $commonModel->getResource()->saveDB($commonVO);
    		if($responseVO->getErrorMessage() == null){
    		    $responseData = $responseVO->getResponseData();
    		    $consignmentNoteVO->setCommonID($responseData['ResponseData']['CommonID']);
    		}else{
    		    Mage::throwException("Something went wrong. please try after some time.");
    		}
    		
    		
    		// Set ConsignmentNumber
    		$consignmentNoteModel = Mage::getModel(Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO::$modelName);
    		if($consignmentNoteVO->getID() == null || $consignmentNoteVO->getID() == "" || $consignmentNoteVO->getID() == 0){
    		    
    		    // for first time
    		    $consignmentNumber = 1000;
    		    
    		    $lastConsignmentNoteDataObj = $consignmentNoteModel->getResource()->getLastRecord();
    		    if($lastConsignmentNoteDataObj !== false){
    		        $lastConsignmentNoteDTO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
    		        /* @var $lastConsignmentNoteVO Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO */
    		        $lastConsignmentNoteVO = Margshri_Common_Helper_Utility::callInstanceFunction($lastConsignmentNoteDTO, $lastConsignmentNoteDataObj);
    		    
    		        if($lastConsignmentNoteVO->getConsignmentNo() != null){
    		            $consignmentNumber = $lastConsignmentNoteVO->getConsignmentNo() + 1;
    		        }
    		    }else{
    		        $consignmentNumber++;
    		    }
    		    $consignmentNoteVO->setConsignmentNo($consignmentNumber);
    		}
    		
    		
    		
    		$responseVO = $consignmentNoteModel->getResource()->saveDB($consignmentNoteVO);
    		
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
    
    
    public function getByVahicaleNumberAction(){
        
        try {
            $responseVO = new Margshri_Common_VO_ResponseVO();
            
            $post = $this->getRequest()->getPost();
            if (empty($post)) {
                Mage::throwException("Invalid Form Data.");
            }
            
            $consignmentNoteDataObj = json_decode($post["ConsignmentNoteDataObj"],true);
            if($consignmentNoteDataObj == null){
                Mage::throwException("Invalid Form Data.");
            }
            $consignmentNoteDTO = new Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO();
            /* @var $consignmentNoteVO Margshri_Transport_VO_Consignment_Consignment_ConsignmentNoteVO */
            $consignmentNoteVO = Margshri_Common_Helper_Utility::callInstanceFunction($consignmentNoteDTO, $consignmentNoteDataObj);
            
            if($consignmentNoteVO->getVahicaleNumber() == null){
                Mage::throwException("Please enter truck number.");
            }
            
            $vahicaleVO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
            $vahicaleOwnerVO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
            $vahicaleDriverVO = new Margshri_Transport_VO_Master_Vahicale_DriverVO();
            
            $vahicaleModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_VahicaleVO::$modelName);
            $vahicaleDataObj = $vahicaleModel->getResource()->getByVahicaleNumber($consignmentNoteVO->getVahicaleNumber());
            if($vahicaleDataObj !== false){
                $vahicaleDTO = new Margshri_Transport_VO_Master_Vahicale_VahicaleVO();
                /* @var $vahicaleVO Margshri_Transport_VO_Master_Vahicale_VahicaleVO */
                $vahicaleVO = Margshri_Common_Helper_Utility::callInstanceFunction($vahicaleDTO, $vahicaleDataObj);
                
                // get vahical owner detail
                if($vahicaleVO->getOwnerID() != null){
                    $vahicaleOwnerModel = Mage::getModel(Margshri_Transport_VO_Master_Vahicale_OwnerVO::$modelName);
                    $vahicaleOwnerDataObj = $vahicaleOwnerModel->getResource()->getByID($vahicaleVO->getOwnerID());
                    if($vahicaleOwnerDataObj !== false){
                        $vahicaleOwnerDTO = new Margshri_Transport_VO_Master_Vahicale_OwnerVO();
                        /* @var $vahicaleOwnerVO Margshri_Transport_VO_Master_Vahicale_OwnerVO */
                        $vahicaleOwnerVO = Margshri_Common_Helper_Utility::callInstanceFunction($vahicaleOwnerDTO, $vahicaleOwnerDataObj);
                    }
                }
            }
            
            $vahicalDataObj = array();
            $vahicalDataObj = $vahicaleVO->getDataArray();
            $vahicalDataObj["ID"] = $vahicaleVO->getID();
            
            $vahicalOwnerDataObj = array();
            $vahicalOwnerDataObj = $vahicaleOwnerVO->getDataArray();
            $vahicalOwnerDataObj["ID"] = $vahicaleOwnerVO->getID();
            
            $responseData = array(); 
            $responseData['VahicalDataObj'] = $vahicalDataObj;
            $responseData['VahicalOwnerDataObj'] = $vahicalOwnerDataObj;
                        
            $responseVO->setResponseData("ResponseData", $responseData);
            
            $responseVO->setSuccessMessage("Successfully Fetched.");
            
        } catch (Exception $e) {
            $responseVO->setErrorMessage($e->getMessage());
        }
        $this->getResponse()->setBody(Margshri_Common_Helper_Utility::jsonEncode($responseVO->getResponseData()));
        return;
        
    }
    
    
}// end class
