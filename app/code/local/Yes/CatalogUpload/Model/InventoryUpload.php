<?php
class Yes_CatalogUpload_Model_InventoryUpload extends Mage_Core_Model_Abstract  {
	
	private	$fileUploadVO;
	private $templateVO;
	private	$catalogProductWebsiteVO;
	private	$catalogInventoryStockItemVO;
	private	$catalogInventoryStockStatusVO;
	private $catalogFileUploadVO;
	
	private $fileManagement;
	private $templateManagement;
	private $recordManagement;
	private $filePath;
	
	/**
	 * Initialize resource model
	 */
	protected function _construct()
	{
		parent::_construct();
		$this->_init('yescatalogupload/inventoryUpload');
	
		$this->fileUploadVO = new Yes_VO_FileUpload_FileUploadVO();
		$this->templateVO = new Yes_VO_Template_TemplateVO();

		$this->fileManagement = new Yes_Services_FileManagementServices();
		$this->templateManagement = new Yes_Services_TemplateManagementServices();
		$this->recordManagement = new Yes_Services_RecordManagementServices();
		$this->filePath = Yes_Utility::getServerPath() . "/var/repository/uploadedfiles/catalog/inventory/";
	}
	
	public function fileProcessing($recordFile)
	{
		
		$fileName = Yes_Utility::getUniqueName();
		$sourceFileExtension  	= substr($recordFile['name'], strrpos($recordFile['name'], '.') + 1);
		$sourceFileSize	= $recordFile["size"];
		$sourceFileFormatType   = $recordFile["type"];
		
	    $this->fileUploadVO->setFileName($fileName . ".{$sourceFileExtension}" );
	    $this->fileUploadVO->setErrorFileName($fileName . "error.log");
	    $this->fileUploadVO->setReferenceName(basename($recordFile['name']));
	    $this->fileUploadVO->setFileURL( $this->filePath . ".{$fileName}" );
	    $this->fileUploadVO->setFlatFileUrl( $this->filePath. $fileName . "_INVENTORY.DAT");
	    $this->fileUploadVO->setErrorFileURL($this->filePath.$fileName ."error.log");
	    $this->fileUploadVO->setTemplateID(Yes_VO_Template_TemplateVO::$INVENTORY_UPLOAD_TEMPLATE_ID);
	    $this->fileUploadVO->setUploadeddAt(date("Y-m-d h:i:s"));
	    
	    $this->fileUploadVO->setFileSize($sourceFileSize);
	    $this->fileUploadVO->setFileExtension($sourceFileExtension);
	    $this->fileUploadVO->setFileFormatType($sourceFileFormatType);
	    $this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$PENDING);
	    $this->fileUploadVO->setNRowsError(0);
	    $this->fileUploadVO->setRowsProcessed(0);
	    
	    $model= Mage::getModel("yescatalogupload/fileUpload");
	    $uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    $this->fileUploadVO->setUploadID($uploadId);
	   
	    
	    
	    $errorMessage =  $this->preValidation($recordFile);
	    
	    if(sizeof($errorMessage) > 0)  { 
	    	$errorFile= Yes_Services_FileManagementServices::fileOpen($this->fileUploadVO->getErrorFileURL());
	    	foreach($errorMessage as $value){
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $value);
	    	}
	    	
	    	Yes_Services_FileManagementServices::fileClose($errorFile);
	    	
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$FAILED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	
	    	//return ;
	    	$response['status'] = 'FAIL';
	    	$response['message']='upload process fail. see error log';
	    	return $response;
	    }
	    
	    $errorMessage = $this->generateFlatFile($recordFile); 

	    if(sizeof($errorMessage) > 0)  {
	    	$errorFile= Yes_Services_FileManagementServices::fileOpen($this->fileUploadVO->getErrorFileURL());
	    	foreach($errorMessage as $value){
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $value);
	    	}
	    	Yes_Services_FileManagementServices::fileClose($errorFile);
	    	 
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$FAILED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	//return ;
	    	
	    	$response['status'] = 'FAIL';
	    	$response['message']='upload process fail. see error log';
	    	return $response;
	    }
		
	    $errorMessage = $this->recordValidation();
	    
	    if(sizeof($errorMessage) > 0)  {
	    	
	    	$errorFile= Yes_Services_FileManagementServices::fileOpen($this->fileUploadVO->getErrorFileURL());
	    		$headingData = "RowNo." . "\t" . "Column Name" . "\t" . "Error Messege" ."\n" ;
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $headingData);
	    	foreach($errorMessage as $value){
	    		Yes_Services_FileManagementServices::fileWrite($errorFile, $value);
	    	}
	    	Yes_Services_FileManagementServices::fileClose($errorFile);
	    	 
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$FAILED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	//return ;
	    	
	    	$response['status'] = 'FAIL';
	    	$response['message']='upload process fail. see error log';
	    	return $response;
	    }else {
	    	$this->fileUploadVO->setStatus(Yes_VO_FileUpload_FileUploadStatusVO::$COMPLETED);
	    	$uploadId = $model->getResource()->saveDB($this->fileUploadVO);
	    	
			$response['status'] ='SUCCESS';
		    $response['message']='Inventory File Successfully Uploaded';
		    return $response;
		 }
	}
	
	public function preValidation($recordFile)
	{
		
		// check fileSize & fileExtension & fleType
		
		 $isValidFileSize = $this->fileManagement->is_ValidFileSize($this->fileUploadVO->getFileSize());
		 $isValidFileExt = $this->fileManagement->is_ValidFileExtension($this->fileUploadVO->getFileExtension());
		 $isValidFileType = $this->fileManagement->is_ValidFileType($this->fileUploadVO->getFileFormatType());
		 
		 $errorMessage = array();
		 if(!$isValidFileSize )  $errorMessage[] = "File Size exceed the limit(" . (Yes_ApplicationConstant::$DATA_FILE_SIZE_LIMIT/(1000*1000)) . "(MB)" . "\n";
		 if(!$isValidFileExt ) $errorMessage[] = "File Extension not permitted." . "\n" ;
		 if(!$isValidFileType )  $errorMessage[] = "File not parsed." . "\n" ;		 	
		 
		 return $errorMessage;
	}
	
	
	public function generateFlatFile($recordFile)
	{
		
		// get file extension from fileUploadVO
		$fileExt = $this->fileUploadVO->getFileExtension();
		
		if($fileExt == Yes_ApplicationConstant::$XLS_FILE_EXT)
		{
			//$this->setFlatFileUrl();
			$xlsHandler = new Yes_Handlers_XlsFileHandler();
			$isGenerateFlatFile = $xlsHandler->createFlatFile($this->fileUploadVO->getFlatFileUrl(),$recordFile);
		}
		if($fileExt == Yes_ApplicationConstant::$XLSX_FILE_EXT)
		{
			//$this->setFlatFileUrl();
			$xlsxHandler = new Yes_Handlers_XlsxFileHandler();
			$isGenerateFlatFile = $xlsxHandler->createFlatFile($this->fileUploadVO->getFlatFileUrl(),$recordFile);
		}
		$errorMessage = array();
		if(!$isGenerateFlatFile) $errorMessage[] = "Flat file not generated." ."\n"; 
		
		return $errorMessage;
	}
	
	
	public function recordValidation()
	{
		
		$errorMessage = array();
		
		// Get Template Array
		$this->setTemplateUrl();
		if($this->templateVO->getTemplateExt() == Yes_ApplicationConstant::$CSV_TEMPLATE_EXT)
		{	
			$csvTemplateHandler = new Yes_Handlers_CsvTemplateHandler();
			$templateArray = $csvTemplateHandler->readTemplate($this->templateVO->getTemplateUrl());
		}		
			
		
		// Get Flate File Array
		$flatFileHandler = new Yes_Handlers_FlatFileHandler();
		$flatFileArray = $flatFileHandler->readFlatFile($this->fileUploadVO->getFlatFileUrl());
	
		 
		for($rowIndex=0; $rowIndex < (sizeof($flatFileArray) - 1) ; $rowIndex++ )
		{
			
			$this->fileUploadVO->setRowsProcessed( $this->fileUploadVO->getRowsProcessed() + 1 );
			//First Row For template validation
			if($rowIndex == 0) 
			{
				$isValidTemplate =	$this->templateManagement->is_ValidProductTemplate($templateArray, $flatFileArray[$rowIndex]);
				if(!$isValidTemplate)
				{ 
					$errorMessage[] = "Template not matched" ."\n";
					return $errorMessage;
				}
			}else{
				// Data Validation Starting From Second Row
				$this->dataRowProcessing($errorMessage , $templateArray,  $flatFileArray[$rowIndex], $rowIndex);
			}// end if else statement
 		}// end for loop
 		 
 		if($errorMessage != null)
 		{
 			return $errorMessage;
 		}
 		 
			
	} //end recordValidation function

	
	
	private function dataRowProcessing(&$errorMessage, $templateArray, $rowData, $rowIndex){
		
		
		$isDataRowValid=true;
		$model = Mage::getModel('yescatalogupload/inventoryUpload');
				
		$cataloginventorystockitemVOList = array();
		$cataloginventorystockstatusVOList = array();
		
		$this->catalogProductWebsiteVO = new Yes_VO_Catalog_CatalogProductWebsiteVO();
		$this->catalogInventoryStockItemVO = new Yes_VO_Catalog_CatalogInventoryStockItemVO();
		$this->catalogInventoryStockStatusVO = new Yes_VO_Catalog_CatalogInventoryStockStatusVO();
		$this->catalogFileUploadVO = new Yes_VO_Catalog_CatalogFileUploadVO();
		
		for($colIndex = 0 ; $colIndex < sizeof($templateArray) ; $colIndex++)
		{
				$columnKey = null;
				$columnException = explode('~', $templateArray[$colIndex]->getColumnException());

				$columnKey = $templateArray[$colIndex]->getColumnKey();
				//Remove dependency key from the array 
				if(in_array(Yes_VO_Exception_ExceptionVO::$DEPENDENCY_KEY, $columnException ))
				{ 
						$index = array_search(Yes_VO_Exception_ExceptionVO::$DEPENDENCY_KEY, $columnException);
						unset($columnException[$index]);
				}
					
				// check column length
				$isColumnLengthValid = $this->recordManagement->isColumnLengthValid($templateArray[$colIndex]->getColumnLength(), $rowData[$colIndex]);
					
				if(!$isColumnLengthValid)
				{
					$errorMessage[] =  $rowIndex . " exceeds " . $templateArray[$colIndex]->getColumnName() . " " . "column  length" . "\n";
				}
				
				// check column type validation
				$isColumnTypeValid = $this->recordManagement->isColumnTypeValid($columnException, $rowData[$colIndex]);
				if($isColumnTypeValid != null)
				{
					$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . $isColumnTypeValid . "\n";
				}
				
				
				// check dependency for duplication and set the value  in respective VO according to  their code
				if($columnKey != null)
				{	
							if($columnKey ==  'sku')
							{
								$entityId =  $this->getEntityIdBySku($rowData[$colIndex]);
								
								if($entityId == null){
									$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . "Sku does not exist." . "\n";
								} 
							}
							if($columnKey ==  'website_id')
							{
								$websiteId =  $this->getWebsiteId($rowData[$colIndex]);
								if($websiteId == null)
								{
									$errorMessage[] = $rowIndex . "\t" . $templateArray[$colIndex]->getColumnName() . "\t\t" . "Website Id Not Found" . "\n";
								}
							}
							
				}//end dependency if statement					
				
				
				//if data validation failed set error in erroMessage array
				if(sizeof($errorMessage)>0 ){
						$isDataRowValid = false;
						continue;
				}	
				
				//set attribute VOs
				$backendType=null;
				$attributeId=$templateArray[$colIndex]->getAttributeID();
				
				//if statement is used to handle value \n it is taking as ascii value 75
				if( $attributeId >0){
					$model->getResource()->getBackendTypeByID($model, $attributeId);
					$backendType = $model->getData('backend_type');
				}	
				if($backendType=="static" ){ 
					if($columnKey ==  'website_id') $this->catalogProductWebsiteVO->setWebsiteId($this->getWebsiteId($rowData[$colIndex]));
				}
				
				// set vo
				if( $columnKey == 'qty') {
					$this->catalogInventoryStockItemVO->setQty($rowData[$colIndex]);
					$this->catalogInventoryStockStatusVO->setQty($rowData[$colIndex]);
				}
				
		}// end columns for loop
		$this->catalogInventoryStockItemVO->setStockId(Yes_VO_Catalog_CatalogInventoryStockItemVO::$STOCK_ID);
		$this->catalogInventoryStockItemVO->setUseConfigMinQty(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_MIN_QTY);
		$this->catalogInventoryStockItemVO->setIsQtyDecimal(Yes_VO_Catalog_CatalogInventoryStockItemVO::$IS_QTY_DECIMAL);
		$this->catalogInventoryStockItemVO->setUseConfigBackorders(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_BACKORDERS);
		$this->catalogInventoryStockItemVO->setUseConfigMinSaleQty(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_MIN_SALE_QTY);
		$this->catalogInventoryStockItemVO->setUseConfigMaxSaleQty(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_MAX_SALE_QTY);
		$this->catalogInventoryStockItemVO->setIsInStock(Yes_VO_Catalog_CatalogInventoryStockItemVO::$IS_IN_STOCK);
		$this->catalogInventoryStockItemVO->setLowStockDate(Yes_VO_Catalog_CatalogInventoryStockItemVO::$LOW_STOCK_DATE);
		$this->catalogInventoryStockItemVO->setUseConfigNotifyStockQty(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_NOTIFY_STOCK_QTY);
		$this->catalogInventoryStockItemVO->setUseConfigManageStock(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_MANAGE_STOCK);
		$this->catalogInventoryStockItemVO->setStockStatusChangedAuto(Yes_VO_Catalog_CatalogInventoryStockItemVO::$STOCK_STATUS_CHANGED_AUTO);
		$this->catalogInventoryStockItemVO->setUseConfigQtyIncrements(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_QTY_INCREMENTS);
		$this->catalogInventoryStockItemVO->setUseConfigEnableQtyInc(Yes_VO_Catalog_CatalogInventoryStockItemVO::$USE_CONFIG_ENABLE_QTY_INC);
		$this->catalogInventoryStockItemVO->setIsDecimalDivided(Yes_VO_Catalog_CatalogInventoryStockItemVO::$IS_DECIMAL_DIVIDED);
		
		$this->catalogInventoryStockStatusVO->setStockId(Yes_VO_Catalog_CatalogInventoryStockStatusVO::$STOCK_ID);
		$this->catalogInventoryStockStatusVO->setStockStatus(Yes_VO_Catalog_CatalogInventoryStockStatusVO::$STOCK_STATUS);
		
		
		if(!$isDataRowValid){
			 $this->fileUploadVO->setNRowsError( $this->fileUploadVO->getNRowsError() + 1);
			 return;
		}
		 	 	   
				    Mage::getModel('yescatalogupload/inventoryUpload')->getResource()->beginTransaction();
					
					try {
							$this->catalogFileUploadVO->setFileUploadID($this->fileUploadVO->getUploadID());
							$this->catalogFileUploadVO->setSKUEntityID($entityId);
							$catalogFileUploadId = $model->getResource()->saveCatalogFileUpload($model , $this->catalogFileUploadVO);
							$this->catalogFileUploadVO->setCatalogFileUploadID($catalogFileUploadId);
						
							$this->catalogInventoryStockItemVO->setProductId($entityId);
							$itemId = $model->getResource()->saveCatalogInventoryStockItem($model , $this->catalogInventoryStockItemVO);
							$this->catalogInventoryStockItemVO->setItemId($itemId);
							 
							$this->catalogInventoryStockStatusVO->setProductId($entityId);
							$this->catalogInventoryStockStatusVO->setWebsiteId($this->catalogProductWebsiteVO->getWebsiteId());
							$model->getResource()->saveCatalogInventoryStockStatus($model , $this->catalogInventoryStockStatusVO);
							
							Mage::getModel('yescatalogupload/inventoryUpload')->getResource()->commit();
							
					}catch(Exception $e){
						Mage::getModel('yescatalogupload/inventoryUpload')->getResource()->rollBack();
						$errorMessage[] = "insertion failed" . "\n";
					} 				
	}// end of data row processing function
	
	public function getEntityIdBySku($skuCode){
		
		$model = Mage::getModel('yescatalogupload/inventoryUpload');
		$model->getResource()->getEntityIdBySku($model, $skuCode);
		return $model->getData('entity_id');
	}
	public function getWebsiteId($websiteCode){
		$model = Mage::getModel('yescatalogupload/inventoryUpload');
		$model->getResource()->getWebsiteIdByCode($model, $websiteCode);
		return $model->getData('website_id');
	}
	
	// set template file path with name in TemplateVO
	public function setTemplateUrl(){
		$model = Mage::getModel('yesmaster/fileUploadTemplate');
		$model->getResource()->getById($model,Yes_VO_Template_TemplateVO::$INVENTORY_UPLOAD_TEMPLATE_ID);
		$this->templateVO->setTemplateUrl(Yes_Utility::getServerPath() . $model->getData('FileURL'));
		$this->templateVO->setTemplateExt($model->getData('FileExtensions'));
	}// end setTemplateFilePathWithName function
}// end class